<?php

namespace Database\Seeders;

use App\Models\RoleHasPermission;
use Illuminate\Database\Seeder;

class RoleHasPermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('role_has_permissions')->truncate();
        
        $arr_role_has_permission = [
            ['permission_id' => 1,  'role_id' => 1,],
            ['permission_id' => 5,  'role_id' => 1,],
            ['permission_id' => 9,  'role_id' => 1,],
            ['permission_id' => 13, 'role_id' => 1,],
            ['permission_id' => 14, 'role_id' => 1,],
            ['permission_id' => 15, 'role_id' => 1,],
            ['permission_id' => 16, 'role_id' => 1,],
            ['permission_id' => 1,  'role_id' => 2,],
            ['permission_id' => 2,  'role_id' => 2,],
            ['permission_id' => 3,  'role_id' => 2,],
            ['permission_id' => 4,  'role_id' => 2,],
            ['permission_id' => 5,  'role_id' => 2,],
            ['permission_id' => 6,  'role_id' => 2,],
            ['permission_id' => 7,  'role_id' => 2,],
            ['permission_id' => 8,  'role_id' => 2,],
            ['permission_id' => 9,  'role_id' => 2,],
            ['permission_id' => 10, 'role_id' => 2,],
            ['permission_id' => 11, 'role_id' => 2,],
            ['permission_id' => 12, 'role_id' => 2,],
            ['permission_id' => 13, 'role_id' => 2,],
            ['permission_id' => 14, 'role_id' => 2,],
            ['permission_id' => 15, 'role_id' => 2,],
            ['permission_id' => 16, 'role_id' => 2,],
        ];
        $count = count($arr_role_has_permission);
        
        $this->command->warn(PHP_EOL . 'Creating Role has Permission...');
        
        $this->command->getOutput()->progressStart($count);
        foreach($arr_role_has_permission as $role_has_permission)
        {
            RoleHasPermission::factory()->create($role_has_permission);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();
        
        $this->command->info(PHP_EOL . 'Role has Permission created');
    }
}