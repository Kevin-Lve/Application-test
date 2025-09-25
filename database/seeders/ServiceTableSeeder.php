<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ServiceTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('service')->delete();
        
        \DB::table('service')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nom' => 'IT',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'nom' => 'FES',
                'created_at' => '2025-05-05 11:13:20',
                'updated_at' => '2025-05-05 11:13:20',
            ),
            2 => 
            array (
                'id' => 4,
                'nom' => 'Maintenance',
                'created_at' => '2025-05-12 20:11:45',
                'updated_at' => '2025-05-12 20:11:45',
            ),
        ));
        
        
    }
}