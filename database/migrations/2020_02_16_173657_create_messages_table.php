<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('to_id')->unsigned()->index();
            $table->integer('from_id')->unsigned()->index();
            $table->string('content');
            $table->timestamps();
            
            // 外部キー設定
            $table->foreign('to_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('from_id')->references('id')->on('users')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
