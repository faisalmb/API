<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountMasterGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_master_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('parent_id')->nullable(); 
            $table->string('name',300);
            $table->string('ename',300);
            $table->string('tag',20);
            $table->string('code',20);
            $table->timestamps();
        });

        Schema::table('account_master_groups', function (Blueprint $table)
        {
            $table->foreign('parent_id')->references('id')->on('account_master_groups')->onUpdate('cascade')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_master_groups');
    }
}
