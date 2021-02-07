<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_phones', function (Blueprint $table) {
            $table->string('id',300)->unique();
            $table->string('phone',40);
            $table->string('type',40);
            $table->string('branch_id',300);
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->boolean('IsActive')->default(true);
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branch_phones');
    }
}
