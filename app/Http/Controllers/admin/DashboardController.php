<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\resetPasswordRequest;
use App\Http\Requests\UserProfileUpdate;
use App\Http\Services\AuthService;
use App\Http\Services\CommonService;
use App\Http\Services\ProfileService;
use App\Jobs\SendMail;
use App\Jobs\sendNotification;
use App\Model\BuyCoinHistory;
use App\Model\Coin;
use App\Model\DepositeTransaction;
use App\Model\Escrow;
use App\Model\MembershipBonusDistributionHistory;
use App\Model\MembershipClub;
use App\Model\Order;
use App\Model\SendMailRecord;
use App\Model\Wallet;
use App\Model\WithdrawHistory;
use App\Services\ERC20TokenApi;
use App\Services\Logger;
use App\User;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public $service;
    public $logger;
    function __construct()
    {
        $this->service = new ProfileService();
        $this->logger = new Logger();
    }

    public function adminDashboard()
    {
        $data['title'] = __('Admin Dashboard');
        $data['total_coin_type'] = Coin::where('status', STATUS_ACTIVE)->count();
        $data['total_coin'] = Wallet::sum('balance');
        $data['total_user'] = User::count();
        $total_active_user = User::where('status', STATUS_ACTIVE)->count();
        $total_inactive_user = User::where('status','<>', STATUS_ACTIVE)->count();
        $data['active_percentage'] = ($total_active_user*100)/$data['total_user'];
        $data['inactive_percentage'] = ($total_inactive_user*100)/$data['total_user'];
        $data['withdrawal_income'] = WithdrawHistory::where(['status' => STATUS_ACTIVE])->sum('fees');
        $data['order_income'] = Order::where(['status' => TRADE_STATUS_TRANSFER_DONE])->sum('fees');
        $data['escrow_income'] = Escrow::where(['status' => STATUS_ACTIVE])->sum('fees');
        $allMonths = all_months();
        // deposit
        $monthlyDeposits = DepositeTransaction::select(DB::raw('sum(amount) as totalDepo'), DB::raw('MONTH(created_at) as months'))
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', STATUS_SUCCESS)
            ->groupBy('months')
            ->get();

        if (isset($monthlyDeposits[0])) {
            foreach ($monthlyDeposits as $depsit) {
                $data['deposit'][$depsit->months] = $depsit->totalDepo;
            }
        }
        $allDeposits = [];
        foreach ($allMonths as $month) {
            $allDeposits[] =  isset($data['deposit'][$month]) ? $data['deposit'][$month] : 0;
        }
        $data['monthly_deposit'] = $allDeposits;

        // withdrawal
        $monthlyWithdrawals = WithdrawHistory::select(DB::raw('sum(amount) as totalWithdraw'), DB::raw('MONTH(created_at) as months'))
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', STATUS_SUCCESS)
            ->groupBy('months')
            ->get();

        if (isset($monthlyWithdrawals[0])) {
            foreach ($monthlyWithdrawals as $withdraw) {
                $data['withdrawal'][$withdraw->months] = $withdraw->totalWithdraw;
            }
        }
        $allWithdrawal = [];
        foreach ($allMonths as $month) {
            $allWithdrawal[] =  isset($data['withdrawal'][$month]) ? $data['withdrawal'][$month] : 0;
        }
        $data['monthly_withdrawal'] = $allWithdrawal;

        // trade
        $monthlyTrades = Order::select(DB::raw('sum(amount) as totalTrade'), DB::raw('MONTH(created_at) as months'))
            ->whereYear('created_at', Carbon::now()->year)
            ->where(['status' => TRADE_STATUS_TRANSFER_DONE, 'is_reported' => STATUS_DEACTIVE])
            ->groupBy('months')
            ->get();

        if (isset($monthlyTrades[0])) {
            foreach ($monthlyTrades as $trade) {
                $data['trade'][$trade->months] = $trade->totalTrade;
            }
        }
        $allTrades = [];
        foreach ($allMonths as $month) {
            $allTrades[] =  isset($data['trade'][$month]) ? $data['trade'][$month] : 0;
        }
        $data['monthly_trade'] = $allTrades;

        return view('admin.dashboard', $data);
    }

    // admin profile
    public function adminProfile(Request $request)
    {
        $data['title'] = __('Profile');
        $data['tab']='profile';
        $data['user']= User::where('id', Auth::id())->first();
        $data['settings'] = allsetting();

        return view('admin.profile.index',$data);
    }

    // update user profile
    public function UserProfileUpdate(UserProfileUpdate $request)
    {
        $response = $this->service->userProfileUpdate($request);
        if ($response['success']) {
            return redirect()->back()->with('success',$response['message']);
        } else {
            return redirect()->back()->with('dismiss',$response['message']);
        }
    }

    // profile upload image
    public function uploadProfileImage(Request $request)
    {
        $rules['file_one'] = 'required|image|max:2024|mimes:jpg,jpeg,png,jpg,gif,svg|max:2048|dimensions:max_width=500,max_height=500';
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            $message = $validator->getMessageBag()->getMessages()['file_one'][0];
            if ($message == 'The file one has invalid image dimensions.')
                $message =  __('Image size must be less than (height:500,width:500)');

            return redirect()->back()->with('dismiss',$message);
        }
        try {
            $img = Input::file('file_one');
            $user_data = (!empty($request->id) ) ? User::find(decrypt($request->id)) : Auth::user();

            if ($img !== null) {
                $photo = uploadFile($img, IMG_USER_PATH, !empty($user_data->photo) ? $user_data->photo : '');
                $user = User::find($user_data->id);
                $user->photo  = $photo;
                $user->save();
                return redirect()->back()->with('success',__('Profile picture uploaded successfully'));
            } else {
                return redirect()->back()->with('dismiss',__('Please input a image'));
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('dismiss', $e->getMessage());
        }

    }

    public function changePasswordSave(resetPasswordRequest $request)
    {
        $service = new AuthService();
        $change = $service->changePassword($request);
        if ($change['success']) {
            return redirect()->back()->with('success',$change['message']);
        } else {
            return redirect()->back()->with('dismiss',$change['message']);
        }
    }

    // send email
    public function sendEmail()
    {
        $data['title'] = __('Send Email');

        return view('admin.notification.email', $data);
    }

    //send notification
    public function sendNotification()
    {
        $data['title'] = __('Send Notification');

        return view('admin.notification.notification', $data);
    }

    // send mail process
    public function sendEmailProcess(Request $request)
    {
        $rules = [
            'subject' => 'required',
            'email_message' => 'required',
            'email_type' => 'required'
        ];
        $messages = [
            'subject.required' => __('Subject field can not be empty'),
            'email_message.required' => __('Message field can not be empty'),
            'email_type.required' => __('Email type field can not be empty'),
        ];
        $validator = Validator::make( $request->all(), $rules, $messages );
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with(['dismiss' => $validator->errors()->first() ]);
        } else {
            $data['subject'] = $request->subject;
            $data['email_message'] = $request->email_message;
            $data['type'] = $request->email_type;
            $data['mailTemplate'] = 'email.genericemail';

            if (!empty($request->email_headers)) {
                $data['email_header'] = $request->email_headers;
            }
            if (!empty($request->footers)) {
                $data['email_footer'] = $request->footers;
            }

//            app(CommonService::class)->sendEmailToAlUser($data);
            dispatch(new SendMail($data))->onQueue('send-email');

            return redirect()->back()->with('success',__('Mail sent successfully'));
        }
    }

    // send notification process
    public function sendNotificationProcess(Request $request)
    {
        $rules = [
            'title' => 'required',
            'notification_body' => 'required',
        ];

        $messages = [
            'title.required' => 'Notification title can not be empty',
            'notification_body.required' => 'Notification body can not be empty',
        ];

        $this->validate($request, $rules, $messages);

        $service = new CommonService();
        try {
//            $response = $service->sendNotificationProcess($request);
            $data['title'] = $request->title;
            $data['notification_body'] = $request->notification_body;
            dispatch(new sendNotification($data))->onQueue('default');

            return redirect()->back()->with(['success' => 'Notification sent successfully']);

        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return redirect()->back()->with(['dismiss' => 'Something went wrong. Please try again']);
        }
    }

    /*
     * clearEmailRecord
     *
     * clear email record
     *
     *
     *
     *
     */

    public function clearEmailRecord()
    {
        $record = SendMailRecord::all();
        if(count($record) > 0) {
            SendMailRecord::truncate();
            return redirect()->back()->with('success',__('All records are deleted successfully'));
        } else {
            return redirect()->back()->with('dismiss',__('Records are already deleted'));
        }
    }

     // check node url
    public function adminCheckNodeUrl()
    {
        $coinApi = new ERC20TokenApi();
        $requestData = array(
            "type" => 1,
            "address" => "testaddress",
        );
        $result = $coinApi->checkWalletBalance($requestData);
        return $result;
    }
}
