<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSelldetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selldetails', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sell_id');
            $table->unsignedInteger('barang_id');
            $table->integer('jumlahkeluar');
            $table->timestamps();

            $table->foreign('sell_id')->references('id')->on('sells')
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
        Schema::dropIfExists('selldetails');
    }
}
