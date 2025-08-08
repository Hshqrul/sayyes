<?php

namespace App\Console\Commands;

use App\Models\Rsvp;
use Illuminate\Console\Command;

class SetEventIdCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rsvp:set-event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set event id to rsvps';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $rsvps = Rsvp::all();
        $this->output->progressStart(count($rsvps));
        foreach (array_chunk($rsvps->all(), 10) as $batch) {
            foreach ($batch as $rsvp) {
                $rsvp->event_id = 1;
                $rsvp->save();
            }
            $this->output->progressAdvance(10);
        }
        $this->output->progressFinish();
    }
}
