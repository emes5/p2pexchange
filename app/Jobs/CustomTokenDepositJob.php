<?php

namespace App\Jobs;

use App\Repository\CustomTokenRepository;
use App\Services\Logger;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CustomTokenDepositJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $logger = new Logger();
        $logger->log('CustomTokenDepositJob', 'called');
        try {
            $logger->log('CustomTokenDepositJob', 'process start');
            $repo = new CustomTokenRepository();
            $repo->depositCustomToken();
        } catch (\Exception $e) {
            $logger->log('CustomTokenDepositJob', $e->getMessage());
        }
        $logger->log('CustomTokenDepositJob', 'end');
    }
}
