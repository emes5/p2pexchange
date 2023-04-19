<?php

namespace App\Console\Commands;

use App\Jobs\DefaultCoinWithWallet;
use App\Services\Logger;
use Illuminate\Console\Command;

class DefaultCoinWallet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'default-coin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'We need to add new default coin . for this we need to create new coin named coin type Default and make all user wallet';

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
        $logger = new Logger();
        $logger->log('DefaultCoinWallet', 'Called');
        dispatch(new DefaultCoinWithWallet())->onQueue('default');
    }
}
