<?php

namespace App\Jobs;

use App\Repository\OfferRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class DynamicRateJob implements ShouldQueue
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
        Log::info('Set dynamic price and rate for all offer start');
        try {
            app(OfferRepository::class)->updateOfferWithDynamicRate();
        } catch (\Exception $e) {
            Log::info('Set dynamic price and rate exception '. $e->getMessage());
        }
        Log::info('Set dynamic price and rate for all offer end');
    }
}
