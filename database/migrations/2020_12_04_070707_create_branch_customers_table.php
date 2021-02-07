<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_customers', function (Blueprint $table) {
            $table->string('id',300)->unique();
            $table->string('branch_id',300);
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('customer_types');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('phone',40);
            $table->string('name',40);
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
        Schema::dropIfExists('branch_customers');
    }
}
