<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblOrderdetailTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_orderdetail', function (Blueprint $table) {
            $table->increments('orderDetailID');
            $table->unsignedInteger('orderID');
            $table->unsignedInteger('itemID');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('mesaID')->nullable();
            $table->timestamps();

            $table->foreign('orderID')->references('orderID')->on('tbl_order')->onDelete('cascade');
            $table->foreign('itemID')->references('itemID')->on('tbl_menuitem');
            $table->foreign('mesaID')->references('mesaID')->on('tbl_mesa')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_orderdetail');
    }
}
