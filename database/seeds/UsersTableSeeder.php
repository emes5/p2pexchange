<?php

use App\Model\Wallet;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(
            [ 'email'=>'admin@email.com'],
            [
            'first_name'=>'Mr.',
            'last_name'=>'Admin',
            'unique_code'=>uniqid().date('').time(),
            'role'=>USER_ROLE_ADMIN,
            'status'=>STATUS_SUCCESS,
            'is_verified'=>1,
            'password'=>\Illuminate\Support\Facades\Hash::make('123456'),
            'created_at' => Carbon::now(),
                'country' => 'US'
        ]);

        User::firstOrCreate(
            ['email'=>'user@email.com'],
            [
            'first_name'=>'Mr',
            'last_name'=>'User',
            'unique_code'=>uniqid().date('').time(),
            'role'=>USER_ROLE_USER,
            'status'=>STATUS_SUCCESS,
            'is_verified'=>1,
            'password'=>\Illuminate\Support\Facades\Hash::make('123456'),
            'created_at' => Carbon::now(),
                'country' => 'US'
        ]);
    }
}
