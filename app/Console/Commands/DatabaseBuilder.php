<?php

/*
 * $signature = 'db:builder {subdomain}'; 
 * 
 * php artisan db:builder showtime
 * php artisan db:builder --db_name="showtime-p" --db_user="showtime_p1" --db_user="pa$$w0rd"
 * php artisan db:builder showtime --db_name="showtime-p" --db_user="showtime_p1" --db_user="pa$$w0rd"
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class DatabaseBuilder extends Command //implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:builder {subdomain?}'
            . ' {--db_name=}'
            . ' {--db_user=}'
            . ' {--db_password=}'
            . ' {--save_path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Példány datbázisának elkészítése';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /*
        dd($this->argument(),$this->options());
        dd(
            $this->option('db_name'),
            $this->option('db_user'),
            $this->option('db_password'),
        );
        */
        $this->table(
            ['db_name', 'db_user', 'db_password'],
            [
                ['db_name' => $this->option('db_name'), 
                'db_user' => $this->option('db_user'), 
                'db_password' => $this->option('db_password')]
            ]
        );
    }
    
    protected function promptForMissingArgumentsUsing(): array {
        return [
            'db_name' => 'Adatbázis neve?',
            'db_user' => 'Felhasználó neve?',
            'db_password' => 'Felhasználó jelszava?',
        ];
    }
}
