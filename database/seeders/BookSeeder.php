<?php

namespace Database\Seeders;

//use Database\Factories\BookFactory;
// php artisan migrate:fresh --seed


use Database\Factories\BookFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('books')->truncate();
        
        $this->command->warn(PHP_EOL . 'Creating books...');
        
        $count = 1000;
        
        $this->command->getOutput()->progressStart($count);
        
        for( $i = 0; $i < $count; $i++ )
        {
            Book::factory(1)->create();
            $this->command->getOutput()->progressAdvance();
        }
        
        $this->command->getOutput()->progressFinish();
        
        $this->command->info(PHP_EOL . 'Books created');
    }
}
