<?php

namespace App\Http\Controllers\admin\marketplace;

use App\Http\Services\CommonService;
use App\Model\Buy;
use App\Model\Coin;
use App\Model\Order;
use App\Model\OrderDispute;
use App\Model\Sell;
use App\Repository\MarketRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class MarketplaceController extends Controller
{
    /*
   *
   * buy sell List
   * Show the list of specified resource.
   * @return \Illuminate\Http\Response
   *
   */
    public function offerList(Request $request, $id)
    {
        if($id == BUY) {
            $title =  __('Buy Offer List');
            $sub_menu = 'buy_offer';
        } else {
            $title =  __('Sell Offer List');
            $sub_menu = 'sell_offer';
        }
        $data['type'] = $id;
        $data['title'] = $title;
        $data['sub_menu'] = $sub_menu;

        if ($request->ajax()) {
            if($request->type == BUY) {
                $items = Buy::select('buys.*');
            } else {
                $items = Sell::select('sells.*');
            }

            return datatables($items)
                ->addColumn('status', function ($item) {
                    return offer_active_status($item->status);
                })
                ->addColumn('user_id', function ($item) {
                    return '<a href="'.route('userTradingProfile',encrypt($item->user_id)).'">'.$item->user->first_name.' '.$item->user->last_name.'</a>';
                })
                ->addColumn('coin_rate', function ($item) {
                    return $item->coin_rate.' '.$item->currency;
                })
                ->addColumn('coin_type', function ($item) {
                    return check_default_coin_type($item->coin_type);
                })
                ->addColumn('country', function ($item) {
                    return !empty($item->country) ? countrylist($item->country) : '';
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at;
                })
                ->addColumn('activity', function ($item) use ($request) {
                    $html = '<ul class="d-flex activity-menu">';
                    $html .= '<li class="viewuser"><a title="'.__('Details').'" href="' . route('offerDetails', [($item->unique_code),$request->type]) . '"><img src="'.asset("assets/admin/images/user-management-icons/activity/view.svg").'" class="img-fluid" alt=""></a></li>';
                    $html .= '</ul>';
                    return $html;
                })
                ->rawColumns(['activity','user_id'])
                ->make(true);
        }

        return view('admin.marketplace.offer.list', $data);
    }
 /*
   *
   * buy sell order List
   * Show the list of specified resource.
   * @return \Illuminate\Http\Response
   *
   */
    public function orderList(Request $request)
    {
        $data['title'] = __('Trade List');
        $data['sub_menu'] = 'order';

        if ($request->ajax()) {

            $items = Order::select('*');

            return datatables($items)
                ->addColumn('status', function ($item) {
                    return trade_order_status($item->status);
                })
                ->addColumn('is_reported', function ($item) {
                    return trade_order_dispute($item->is_reported);
                })
                ->addColumn('buyer_id', function ($item) {
                    return $item->buyer->first_name.' '.$item->buyer->last_name;
                })
                ->addColumn('coin_type', function ($item) {
                    return check_default_coin_type($item->coin_type);
                })
                ->addColumn('seller_id', function ($item) {
                    return $item->seller->first_name.' '.$item->seller->last_name;
                })
                ->addColumn('rate', function ($item) {
                    return $item->rate.' '.$item->currency;
                })
                ->addColumn('price', function ($item) {
                    return $item->price.' '.$item->currency;
                })
                ->addColumn('amount', function ($item) {
                    return $item->amount.' '.$item->coin_type;
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at;
                })
                ->addColumn('activity', function ($item) use ($request) {
                    $html = '<ul class="d-flex activity-menu">';
                    $html .= '<li class="viewuser"><a title="'.__('Details').'" href="' . route('orderDetails', ($item->unique_code)) . '"><img src="'.asset("assets/admin/images/user-management-icons/activity/view.svg").'" class="img-fluid" alt=""></a></li>';
                    $html .= '</ul>';
                    return $html;
                })
                ->rawColumns(['activity'])
                ->make(true);
        }

        return view('admin.marketplace.order.list', $data);
    }

 /*
   *
   * buy sell order dispute List
   * Show the list of specified resource.
   * @return \Illuminate\Http\Response
   *
   */
    public function orderDisputeList(Request $request)
    {
        $data['title'] = __('Trade Dispute List');
        $data['sub_menu'] = 'dispute';

        if ($request->ajax()) {

            $items = Order::where('is_reported',STATUS_ACTIVE);

            return datatables($items)
                ->addColumn('status', function ($item) {
                    return trade_order_status($item->status);
                })
                ->addColumn('coin_type', function ($item) {
                    return check_default_coin_type($item->coin_type);
                })
                ->addColumn('buyer_id', function ($item) {
                    return $item->buyer->first_name.' '.$item->buyer->last_name;
                })
                ->addColumn('seller_id', function ($item) {
                    return $item->seller->first_name.' '.$item->seller->last_name;
                })
                ->addColumn('rate', function ($item) {
                    return $item->rate.' '.$item->currency;
                })
                ->addColumn('price', function ($item) {
                    return $item->price.' '.$item->currency;
                })
                ->addColumn('amount', function ($item) {
                    return $item->amount.' '.$item->coin_type;
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at;
                })
                ->addColumn('activity', function ($item) use ($request) {
                    $html = '<ul class="d-flex activity-menu">';
                    $html .= '<li class="viewuser"><a title="'.__('Details').'" href="' . route('orderDisputeDetails', ($item->unique_code)) . '"><img src="'.asset("assets/admin/images/user-management-icons/activity/view.svg").'" class="img-fluid" alt=""></a></li>';
                    $html .= '</ul>';
                    return $html;
                })
                ->rawColumns(['activity'])
                ->make(true);
        }

        return view('admin.marketplace.dispute.list', $data);
    }

    // offer details
    public function offerDetails($id, $type)
    {
        if($type == BUY) {
            $title =  __('Buy Offer Details');
            $sub_menu = 'buy_offer';
            $item = Buy::where('unique_code',$id)->first();
        } else {
            $title =  __('Sell Offer Details');
            $sub_menu = 'sell_offer';
            $item = Sell::where('unique_code',$id)->first();
        }
        $data['type'] = $type;
        $data['title'] = $title;
        $data['sub_menu'] = $sub_menu;
        if(isset($item)) {
            $data['item'] = $item;

            return view('admin.marketplace.offer.details',$data);
        } else {
            return redirect()->back()->with(['dismiss' => __('Offer not found.')]);
        }
    }

    // order details
    public function orderDetails($id)
    {
        $item = Order::where('unique_code',$id)->first();

        $data['title'] = __('Trade Details');
        $data['sub_menu'] = 'order';
        if(isset($item)) {
            $data['item'] = $item;

            return view('admin.marketplace.order.details',$data);
        } else {
            return redirect()->back()->with(['dismiss' => __('Order not found.')]);
        }
    }

    // order dispute details
    public function orderDisputeDetails($id)
    {
        $item = Order::where(['unique_code' => $id, 'is_reported' => STATUS_ACTIVE])->first();

        $data['title'] = __('Trade Dispute Details');
        $data['sub_menu'] = 'dispute';
        if(isset($item)) {
            $data['dispute'] = OrderDispute::where('order_id', $item->id)->first();
            $data['item'] = $item;

            return view('admin.marketplace.dispute.details',$data);
        } else {
            return redirect()->back()->with(['dismiss' => __('Order not found.')]);
        }
    }

    // user trade profile
    public function userTradeProfile(Request $request, $user_id)
    {
        $data['title'] = __('Trade Profile');
        $id = app(CommonService::class)->checkValidId($user_id);
        if (is_array($id)) {
            return redirect()->back()->with(['dismiss' => __('Data not found.')]);
        }
        $data['user'] = User::find($id);
        $data['coins'] = Coin::where('status', STATUS_ACTIVE)->get();
        $data['buys'] = Buy::where(['status' => STATUS_ACTIVE, 'user_id' => $id])->orderBy('id', 'DESC')->paginate(20);
        $data['sells'] = Sell::where(['status' => STATUS_ACTIVE, 'user_id' => $id])->orderBy('id', 'DESC')->paginate(20);

        if ($request->ajax()) {

            $items = Order::where(['is_reported' => 0])->where(function ($query) use ($id) {
                $query->where('buyer_id', $id)
                    ->orWhere('seller_id', $id);
            });

            return datatables($items)
                ->addColumn('status', function ($item) {
                    return trade_order_status($item->status);
                })
                ->addColumn('buyer_id', function ($item) {
                    return $item->buyer->first_name.' '.$item->buyer->last_name;
                })
                ->addColumn('seller_id', function ($item) {
                    return $item->seller->first_name.' '.$item->seller->last_name;
                })
                ->addColumn('rate', function ($item) {
                    return $item->rate.' '.$item->currency;
                })
                ->addColumn('price', function ($item) {
                    return $item->price.' '.$item->currency;
                })
                ->addColumn('amount', function ($item) {
                    return $item->amount.' '.$item->coin_type;
                })
                ->editColumn('created_at', function ($item) {
                    return $item->created_at ? with(new Carbon($item->created_at))->format('d M Y') : '';
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d %M %Y') like ?", ["%$keyword%"]);
                })
                ->addColumn('activity', function ($item) use ($request) {
                    $html = '<ul class="d-flex activity-menu">';
                    $html .= '<li class="viewuser"><a title="'.__('Details').'" href="' . route('orderDetails', encrypt($item->id)) . '"><img src="'.asset("assets/admin/images/user-management-icons/activity/view.svg").'" class="img-fluid" alt=""></a></li>';
                    $html .= '</ul>';
                    return $html;
                })
                ->rawColumns(['activity'])
                ->make(true);
        }

        return view('admin.marketplace.user.profile',$data);
    }

    // admin Refund Escrow process
    public function adminRefundEscrow($order_id)
    {
        try {
            $marketRepo = new MarketRepository();
            $response = $marketRepo->adminRefundEscrowProcess($order_id);
            if ($response['success'] == true) {
                return redirect()->back()->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);

        } catch (\Exception $e) {
            Log::info('adminRefundEscrow exception -> '.$e->getMessage());
            return redirect()->back()->with('dismiss', __('Something went wrong'));
        }
    }

    // admin Escrow release process
    public function adminReleaseEscrow($order_id)
    {
        try {
            $marketRepo = new MarketRepository();
            $response = $marketRepo->adminReleaseEscrowProcess($order_id);
            if ($response['success'] == true) {
                return redirect()->back()->with('success', $response['message']);
            }

            return redirect()->back()->withInput()->with('dismiss', $response['message']);

        } catch (\Exception $e) {
            Log::info('adminReleaseEscrow exception -> '.$e->getMessage());
            return redirect()->back()->with('dismiss', __('Something went wrong'));
        }
    }

}
