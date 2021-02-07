<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->string('id',300)->unique();
            $table->string('branch_id',300);
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->string('item_id',300);
            $table->foreign('item_id')->references('id')->on('items');
            $table->text('quantity');
            $table->unsignedBigInteger('base_unit_id')->nullable();
            $table->foreign('base_unit_id')->references('id')->on('units')->onDelete('cascade'); 
            $table->unsignedBigInteger('show_unit_id')->nullable();
            $table->foreign('show_unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->text('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
