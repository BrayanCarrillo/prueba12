<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblMenuItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_menuitem', function (Blueprint $table) {
            $table->increments('itemID');
            $table->integer('menuID')->unsigned();
            $table->text('menuItemName');
            $table->decimal('price', 15, 2);
            $table->boolean('activate');
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
        Schema::dropIfExists('tbl_menuitem');
    }
}
