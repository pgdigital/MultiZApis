<?php

namespace App\Console\Commands\Schedule;

use App\Models\Campaign;
use Illuminate\Console\Command;

class RuningCampaigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:runing-campaigns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $campaigns = Campaign::query()
            ->where('start_date', '>=', now())
            ->where('end_date', '<=', now())
            ->get();

        $campaigns->each(function($campaign) {
            if($campaign->start_date <= now() && $campaign->status == 'Programado') {
                $campaign->update([
                    'status' => 'Ativa'
                ]);
            } else if($campaign->end_date >= now() && $campaign->status == 'Ativa') {
                $campaign->update([
                    'status' => 'Finalizada'
                ]);
            } else {
                // Execução das campanhas
            }
        });
    }
}
