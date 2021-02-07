<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemUnitConversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_unit_conversions', function (Blueprint $table) {
            $table->string('id',300)->unique();
            $table->string('item_id',300);
            $table->foreign('item_id')->references('id')->on('items');
            $table->unsignedBigInteger('base_unit_id')->nullable();
            $table->foreign('base_unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->string('multiplier',300);
            $table->unsignedBigInteger('to_unit_id')->nullable();
            $table->foreign('to_unit_id')->references('id')->on('units')->onDelete('cascade'); 
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
        Schema::dropIfExists('item_unit_conversions');
    }
}
