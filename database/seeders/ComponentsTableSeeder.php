<?php

namespace Database\Seeders;

use App\Models\Component;
use Illuminate\Database\Seeder;

class ComponentsTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('components')->truncate();
        
        $arr_components = [
            ['id' => 1,'name' => 'Központi komponens',],
            ['id' => 2,'name' => 'Központi komponens',],
        ];
        $count = count($arr_components);
        
        $this->command->warn(PHP_EOL . 'Creating components...');
        
        $this->command->getOutput()->progressStart($count);
        foreach($arr_components as $component)
        {
            Component::factory()->create($component);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();
        
        $this->command->info(PHP_EOL . 'Components created');
    }
}