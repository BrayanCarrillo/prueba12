<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_staff')->insert([
            ['staffID' => 1, 'username' => 'Juan', 'password' => '$2y$10$skZTaK.l3byhf5ksLAjVMOitNwe5tqQMPnx406VFuHRY4NUoBBLdu', 'status' => 1, 'role' => 'Chef'],
            ['staffID' => 4, 'username' => 'Pedro', 'password' => '1234abcd..', 'status' => 1, 'role' => 'Mesero'],
            ['staffID' => 5, 'username' => 'Adriana', 'password' => '1234abcd..', 'status' => 1, 'role' => 'Chef'],
            ['staffID' => 6, 'username' => 'Robert', 'password' => '1234abcd..', 'status' => 1, 'role' => 'Chef'],
            ['staffID' => 7, 'username' => 'Sofia', 'password' => 'abc123', 'status' => 1, 'role' => 'Mesero'],
            ['staffID' => 9, 'username' => 'Marin', 'password' => '$2y$10$hb4gjT7ju.5c6WztfWf.NOkYahrVSQr9jsV/4VWy2QajUxfFXOnai', 'status' => 1, 'role' => 'Chef'],
        ]);
    }
}
