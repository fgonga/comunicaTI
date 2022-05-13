<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cti:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Instala a aplicação';

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
     * @return int
     */
    public function handle(): int
    {
        $this->info('Instalando a aplicação...');
        $this->call("migrate:fresh");
        $this->call("db:seed");
        return  1;
    }
}
