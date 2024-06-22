<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TblAdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_admin')->insert([
            'username' => 'admin',
            'password' => Hash::make('1234abcd..')
        ]);
    }
}
