<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('posts')->truncate();
        
        $this->command->warn(PHP_EOL . 'Creating posts...');
        
        $count = 1000;
        $this->command->getOutput()->progressStart($count);
        
        for( $i = 0; $i < $count; $i++ )
        {
            \App\Models\Post::factory(1)->create();
            $this->command->getOutput()->progressAdvance();
        }
        
        $this->command->getOutput()->progressFinish();
        $this->command->info(PHP_EOL . 'Posts created');
    }
}
