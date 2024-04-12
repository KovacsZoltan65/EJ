<?php

namespace Database\Seeders;

use App\Models\SubdomainState;
use Illuminate\Database\Seeder;

class SubdomainStatesTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('subdomain_states')->truncate();
        
        $arr_subdomain_states = [
            ['id' => 1, 'name' => 'Aktív',],
            ['id' => 2, 'name' => 'Felfüggesztve',],
            ['id' => 3, 'name' => 'Leállítva(HQ)',],
            ['id' => 4, 'name' => 'Leállítva(példány)',],
        ];
        $count = count($arr_subdomain_states);
        
        $this->command->warn(PHP_EOL . 'Creating Roles...');
        
        $this->command->getOutput()->progressStart($count);
        foreach($arr_subdomain_states as $state)
        {
            SubdomainState::factory()->create($state);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();
        
        $this->command->info(PHP_EOL . 'Roles created');
        
    }
}