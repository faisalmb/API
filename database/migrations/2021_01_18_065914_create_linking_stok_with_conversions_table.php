<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkingStokWithConversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linking_stok_with_conversions', function (Blueprint $table) {
            $table->string('id',300)->unique();
            $table->string('stock_id',300)->nullable();
            $table->foreign('stock_id')->references('id')->on('stocks');
            $table->string('conversions_id',300)->nullable();
            $table->foreign('conversions_id')->references('id')->on('item_unit_conversions');
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
        Schema::dropIfExists('linking_stok_with_conversions');
    }
}
