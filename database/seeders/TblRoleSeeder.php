<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TblRoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_role')->insert([
            ['role' => 'Chef'],
            ['role' => 'Mesero']
        ]);
    }
}
