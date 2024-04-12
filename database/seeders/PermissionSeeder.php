<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('model_has_permissions')->truncate();
        \DB::table('permissions')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $arr_permissions = [
            ['id' => 1,  'name' => 'permission list',   'guard_name' => 'web',],
            ['id' => 2,  'name' => 'permission create', 'guard_name' => 'web',],
            ['id' => 3,  'name' => 'permission edit',   'guard_name' => 'web',],
            ['id' => 4,  'name' => 'permission delete', 'guard_name' => 'web',],
            ['id' => 5,  'name' => 'role list',         'guard_name' => 'web',],
            ['id' => 6,  'name' => 'role create',       'guard_name' => 'web',],
            ['id' => 7,  'name' => 'role edit',         'guard_name' => 'web',],
            ['id' => 8,  'name' => 'role delete',       'guard_name' => 'web',],
            ['id' => 9,  'name' => 'user list',         'guard_name' => 'web',],
            ['id' => 10, 'name' => 'user create',       'guard_name' => 'web',],
            ['id' => 11, 'name' => 'user edit',         'guard_name' => 'web',],
            ['id' => 12, 'name' => 'user delete',       'guard_name' => 'web',],
            ['id' => 13, 'name' => 'post list',         'guard_name' => 'web',],
            ['id' => 14, 'name' => 'post create',       'guard_name' => 'web',],
            ['id' => 15, 'name' => 'post edit',         'guard_name' => 'web',],
            ['id' => 16, 'name' => 'post delete',       'guard_name' => 'web',],
        ];
        $count = count($arr_permissions);
        
        $this->command->warn(PHP_EOL . 'Creating Permissions...');
        $this->command->getOutput()->progressStart($count);
        foreach($arr_permissions as $permission)
        {
            Permission::factory()->create($permission);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();
        $this->command->info(PHP_EOL . 'Permissions created');
    }
}