<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->string('id',300)->unique();
            $table->string('branch_id',300);
            $table->foreign('branch_id')->references('id')->on('branches');  
            $table->unsignedBigInteger('master_id')->nullable(); 
            $table->foreign('master_id')->references('id')->on('account_master_groups')->onDelete('cascade'); 
            $table->string('parent_id',300)->nullable(); 
            $table->foreign('parent_id')->references('id')->on('account_sub_groups');
            $table->string('name',300);
            $table->string('info',300);
            $table->boolean('debt')->default(false);
            $table->boolean('credit')->default(false);
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
        Schema::dropIfExists('accounts');
    }
}
