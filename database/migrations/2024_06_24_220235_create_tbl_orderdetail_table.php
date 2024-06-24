<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_orderdetail', function (Blueprint $table) {
            $table->increments('orderDetailID');
            $table->integer('orderID')->unsigned();
            $table->integer('itemID')->unsigned();
            $table->integer('quantity');
            $table->integer('mesaID')->unsigned()->nullable();
            // No foreign key
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_orderdetail');
    }
}
