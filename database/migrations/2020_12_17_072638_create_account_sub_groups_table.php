<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountSubGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_sub_groups', function (Blueprint $table) {
            $table->string('id',300)->unique();
            $table->string('branch_id',300);
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->string('parent_id',300)->nullable();   
            $table->unsignedBigInteger('master_id')->nullable(); 
            $table->foreign('master_id')->references('id')->on('account_master_groups')->onDelete('cascade'); 
            $table->string('name',300);
            $table->string('ename',300);
            $table->string('tag',20);
            $table->string('code',20);
            $table->timestamps();
        });

        Schema::table('account_sub_groups', function (Blueprint $table)
        {
            $table->foreign('parent_id')->references('id')->on('account_sub_groups');
        });
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_sub_groups');
    }
}
