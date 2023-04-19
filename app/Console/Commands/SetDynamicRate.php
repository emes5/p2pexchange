<?php

namespace App\Console\Commands;

use App\Jobs\DynamicRateJob;
use Illuminate\Console\Command;
use App\Services\Logger;

class SetDynamicRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:set-dynamic-rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'We need to update offer info (market price and coin rate) for dynamic pricing';

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
        $logger->log('SetDynamicRate', 'Called');
        dispatch(new DynamicRateJob())->onQueue('default');
    }
}
