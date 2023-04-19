<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class AddUserName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:username';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add missing username for user and that should be unique';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::whereNull('username')->get();
        if (isset($users[0])) {
            foreach ($users as $user) {
                $user->update(['username' => make_unique_slug($user->first_name.$user->last_name, 'users', 'username')]);
            }
        }
    }
}
