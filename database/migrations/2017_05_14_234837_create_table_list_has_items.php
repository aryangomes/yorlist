<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableListHasItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_has_items', function (Blueprint $table) {
            $table->integer('lists_idList')->unsigned();
            $table->integer('items_idItem')->unsigned();
            $table->integer('qtd')->default(1);
            $table->float('price')->default(0);
            $table->boolean('isInCart')->default(0);
            $table->float('subTotal')->default(0);
            $table->timestamps();

            $table->foreign('lists_idList')
                ->references('idList')
                ->on('lists')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('items_idItem')
                ->references('idItem')
                ->on('items')
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
        Schema::dropIfExists('list_has_items');
    }
}
