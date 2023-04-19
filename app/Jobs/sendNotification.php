<?php

namespace App\Jobs;

use App\Http\Services\CommonService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class sendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        $this->data = $event;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('notification send start');
        try {
            app(CommonService::class)->sendNotificationProcess($this->data);
        } catch (\Exception $e) {
            Log::info('notification send exception '. $e->getMessage());
        }
        Log::info('notification send end');
    }
}
