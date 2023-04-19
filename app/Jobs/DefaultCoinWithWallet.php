<?php

namespace App\Jobs;

use App\Model\Coin;
use App\Model\Wallet;
use App\Services\Logger;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class DefaultCoinWithWallet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $logger = new Logger();
        $logger->log('DefaultCoinWithWallet', 'queue start');
        DB::beginTransaction();
        try {
            $defaultCoin = Coin::updateOrCreate(['type' => DEFAULT_COIN_TYPE], ['name'=>allsetting('coin_name'). ' Coin', 'type'=> DEFAULT_COIN_TYPE,'unique_code'=>uniqid().date('').time(),'status' => STATUS_ACTIVE]);
            if ($defaultCoin) {
                $users = User::select('*')->get();
                foreach ($users as $user) {
                    $data = [
                        'user_id' => $user->id,
                        'coin_id' => $defaultCoin->id,
                        'coin_type' => $defaultCoin->type,
                        'name' => $defaultCoin->type. ' Wallet',
                        'unique_code' => uniqid().date('').time(),
                        'is_primary' => STATUS_ACTIVE
                    ];
                    Wallet::updateOrCreate(['user_id' => $user->id, 'coin_id' => $defaultCoin->id],$data);
                }
                DB::commit();
                $logger->log('DefaultCoinWithWallet', 'Default wallet created');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $logger->log('DefaultCoinWithWallet', $e->getMessage());
        }
    }
}
