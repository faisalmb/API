<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_currencies', function (Blueprint $table) {
            $table->string('id',300)->unique();
            $table->unsignedBigInteger('currency_id',300);
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->string('company_id',300);
            $table->foreign('company_id')->references('id')->on('companies');
            $table->boolean('IsActive')->default(true);
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
        Schema::dropIfExists('company_currencies');
    }
}
