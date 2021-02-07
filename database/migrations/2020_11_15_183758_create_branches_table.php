<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->string('id',300)->unique();
            $table->string('user_id',300);
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('company_id',300);
            $table->foreign('company_id')->references('id')->on('companies');
            $table->text('name');
            $table->string('location',40);
            $table->text('type');
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
        Schema::dropIfExists('branches');
    }
}
