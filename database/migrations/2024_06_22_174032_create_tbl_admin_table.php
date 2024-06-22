<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblAdminTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_admin', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('username', 25);
            $table->string('password', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_admin');
    }
}
