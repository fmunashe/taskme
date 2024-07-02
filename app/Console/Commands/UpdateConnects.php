<?php

namespace App\Console\Commands;

use App\Models\Connect;
use Illuminate\Console\Command;

class UpdateConnects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:connects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to update connects for each user profile every month';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $connects = Connect::all();
        foreach ($connects as $connect) {
            $connect->update([
                'totalConnects' => $connect->totalConnects + 2
            ]);
        }
    }
}
