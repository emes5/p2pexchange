<?php
/**
 * Created by PhpStorm.
 * User: bacchu
 * Date: 9/12/19
 * Time: 12:56 PM
 */

namespace App\Http\Services;

use App\Model\AffiliationCode;
use App\Model\Coin;
use App\Model\UserVerificationCode;
use App\Model\Wallet;
use App\Repository\AffiliateRepository;
use App\Services\Logger;
use App\Services\MailService;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WalletService
{

    public $logger;
    function __construct()
    {
        $this->logger = new Logger();
    }

    /**
     * @param $request
     * @return array
     */
    public function userWalletUpdate($userId)
    {
        $response = ['success' => false, 'message' => __('Something went wrong')];
        try {
            $coins = Coin::where(['status' => STATUS_ACTIVE])->orderBy('id', 'desc')->get();
            if(isset($coins[0])) {
                foreach ($coins as $coin) {
                    Wallet::firstOrCreate(['user_id' => $userId, 'coin_id' => $coin->id],[
                        'name' => $coin->type. ' Wallet',
                        'coin_type' => $coin->type,
                        'unique_code' => uniqid().date('').time()
                    ]);
                }
            }
            $response =  ['success' => true, 'message' => __('Wallet created successfully')];
        } catch (\Exception $exception) {
            $this->logger->log('userProfileUpdate', $exception->getMessage());
            $response = ['success' => false, 'message' => __('Something went wrong')];
        }
        return $response;
    }


    // my wallet
    public function myWalletList($userId)
    {
        try {
            $this->userWalletUpdate($userId);
            $data['wallets'] = Wallet::join('coins', 'coins.id', '=', 'wallets.coin_id')
                ->where(['wallets.user_id' => $userId, 'coins.status' => STATUS_ACTIVE])
                ->orderBy('wallets.id','ASC')
                ->select('wallets.*')
                ->get();
            $data['coins'] = Coin::where('status', STATUS_ACTIVE)->get();
            $data['title'] = __('My Wallet');
            $response = ['success' => true, 'message' => __('Success'), 'data' => $data];
        } catch (\Exception $e) {
            $this->logger->log('userProfileUpdate', $e->getMessage());
            $response = ['success' => false, 'message' => __('Something went wrong'), 'data' => []];
        }
        return $response;
    }
}
