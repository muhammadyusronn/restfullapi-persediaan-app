<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBuydetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buydetail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('buy_id');
            $table->unsignedInteger('barang_id');
            $table->integer('jumlahmasuk');
            $table->integer('hargabeli');
            $table->timestamps();

            $table->foreign('buy_id')->references('id')->on('buy')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('items')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buydetail');
    }
}
