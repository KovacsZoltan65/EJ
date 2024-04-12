<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('roles')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $arr_roles = [
            ['id' => 1,'name' => 'writer',      'guard_name' => 'web',],
            ['id' => 2,'name' => 'admin',       'guard_name' => 'web',],
            ['id' => 3,'name' => 'super-admin', 'guard_name' => 'web',]
        ];
        $count = count($arr_roles);
        
        $this->command->warn(PHP_EOL . 'Creating Roles...');
        
        $this->command->getOutput()->progressStart($count);
        foreach($arr_roles as $role)
        {
            Role::factory()->create($role);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();
        
        $this->command->info(PHP_EOL . 'Roles created');
    }
}