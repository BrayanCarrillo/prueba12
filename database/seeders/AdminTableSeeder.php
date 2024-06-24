<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_admin')->insert([
            ['ID' => 0, 'username' => 'admin', 'password' => '1234abcd..'],
            ['ID' => 1, 'username' => 'admin1', 'password' => '$2y$10$.8dKdxlVSSfV1CsiPj2Xqe6Wifbre0xzIDHPoYw.n/DlI5yQm3xRu'],
        ]);
    }
}
