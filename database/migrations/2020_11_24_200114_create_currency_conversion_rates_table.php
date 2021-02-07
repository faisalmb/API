<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyConversionRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_conversion_rates', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('Official_sale_price',300);
            $table->string('Official_purchase_price',300);
            $table->string('informal_sale_price',300);
            $table->string('informal_purchase_price',300);
            $table->unsignedBigInteger('from_currency_id');
            $table->foreign('from_currency_id')->references('id')->on('currencies');
            $table->unsignedBigInteger('to_currency_id');
            $table->foreign('to_currency_id')->references('id')->on('currencies');
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
        Schema::dropIfExists('currency_conversion_rates');
    }
}
