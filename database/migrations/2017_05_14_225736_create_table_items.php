<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('idItem');
            $table->string('name', 100);
            $table->integer('categories_idCategory')->unsigned();
            $table->timestamps();



        });

        Schema::table('items', function (Blueprint $table) {

            $table->foreign('categories_idCategory')
                ->references('idCategory')
                ->on('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
