<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\obsPort;

class enablePortPolling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'obsman:enablePortPolling {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enable polling of a port in Observium';

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
        $id = $this->argument('id');
        $port = obsPort::find($id);
        $port->enablePolling();
    }
}
