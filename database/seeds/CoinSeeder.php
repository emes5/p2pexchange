<?php

use App\Model\Coin;
use Illuminate\Database\Seeder;

class CoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coin::firstOrCreate(['type'=>'BTC'],['name'=>'Bitcoin','unique_code'=>uniqid().date('').time()]);
        Coin::firstOrCreate(['type'=>'USDT'],['name'=>'Tether USD', 'unique_code'=>uniqid().date('').time(),]);
        Coin::firstOrCreate(['type'=>'ETH'],['name'=>'Ether', 'unique_code'=>uniqid().date('').time(),]);
        Coin::firstOrCreate(['type'=>'LTC'],['name'=>'Litecoin','unique_code'=>uniqid().date('').time(),]);
        Coin::firstOrCreate(['type'=>'DOGE'],['name'=>'Ether','unique_code'=>uniqid().date('').time(),]);
        Coin::firstOrCreate(['type'=>'BCH'],['name'=>'Bitcoin Cash','unique_code'=>uniqid().date('').time(),]);
        Coin::firstOrCreate(['type'=>'DASH'],['name'=>'Dash','unique_code'=>uniqid().date('').time(),]);
        Coin::firstOrCreate(['type'=> DEFAULT_COIN_TYPE],['name'=>allsetting('coin_name'). ' Coin','unique_code'=>uniqid().date('').time(),]);
        Coin::firstOrCreate(['type'=> COIN_TYPE_LTCT],['name'=>'LTCT','unique_code'=>uniqid().date('').time(),]);
    }
}
