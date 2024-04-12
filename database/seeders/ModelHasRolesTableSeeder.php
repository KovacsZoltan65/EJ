<?php

namespace Database\Seeders;

use App\Models\ModelHasRole;
use Illuminate\Database\Seeder;

class ModelHasRolesTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('model_has_roles')->truncate();
        
        $arr_model_has_role = [
            ['role_id' => 1,'model_type' => 'App\Models\User','model_id' => 4,],
            ['role_id' => 2,'model_type' => 'App\Models\User','model_id' => 3,],
            ['role_id' => 3,'model_type' => 'App\Models\User','model_id' => 2,],
        ];
        
        $count = count($arr_model_has_role);
        
        $this->command->warn(PHP_EOL . 'Creating Model has Role...');
        
        $this->command->getOutput()->progressStart($count);
        foreach($arr_model_has_role as $component)
        {
            ModelHasRole::factory()->create($component);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();
        
        $this->command->info(PHP_EOL . 'Model has Role created');
    }
}