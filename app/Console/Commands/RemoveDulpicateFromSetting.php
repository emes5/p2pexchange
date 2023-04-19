<?php

namespace App\Console\Commands;

use App\Model\AdminSetting;
use Illuminate\Console\Command;

class RemoveDulpicateFromSetting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove-duplicate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $duplicates = AdminSetting::select('slug','value','id')
            ->groupBy('slug')
            ->havingRaw('COUNT(*) > 1')
            ->get();
        if (isset($duplicates[0])) {
            foreach ($duplicates as $record) {
                AdminSetting::where(['id' => $record->id])->delete();
            }
        }
    }
}
