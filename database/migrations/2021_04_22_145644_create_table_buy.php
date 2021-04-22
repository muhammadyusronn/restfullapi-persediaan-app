<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBuy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kodetransaksi', '10')->unique();
            $table->date('tanggaltransaksi');
            $table->integer('totaltransaksi');
            $table->unsignedInteger('supplier_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('supplier')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('buy');
    }
}
