<?php

namespace Database\Seeders;

use App\Models\Seed;
use Illuminate\Database\Seeder;

class SeedsTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('seeds')->truncate();
        
        $arr_sheeds = [
            ['id' => 1,'seed' => 'UserTableSeeder_2022_08_08_100001','batch' => 1,],
            ['id' => 2,'seed' => 'SubdomainStateTableSeeder_2022_08_08_100002','batch' => 1,],
            ['id' => 3,'seed' => 'RolesTableSeeder_2022_08_08_100003','batch' => 1,],
        ];
        $count = count($arr_sheeds);
        
        $this->command->warn(PHP_EOL . 'Creating Seeds...');
        
        $this->command->getOutput()->progressStart($count);
        foreach($arr_sheeds as $sheed)
        {
            Seed::factory()->create($sheed);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();
        
        $this->command->info(PHP_EOL . 'Seeds created');
    }
}