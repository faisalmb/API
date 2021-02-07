<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->string('id',300)->unique();
            $table->string('company_id',300);
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedBigInteger('category_id')->nullable(); 
            $table->foreign('category_id')->references('id')->on('item_categories')->onDelete('cascade'); 
            $table->string('name',100);
            $table->string('ename',100);
            $table->string('commercial_name',200);
            $table->string('supplier',200);
            $table->string('info',500);
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
        Schema::dropIfExists('items');
    }
}
