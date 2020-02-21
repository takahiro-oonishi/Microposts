<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFollowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_follow', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
                /*
                follow_id という名前にしていますが、保存する内容はユーザID で
                しかし、 user_id というカラム名が被ってしまうので、 follow_id にしています。
                */
            $table->integer('follow_id')->unsigned()->index();
            $table->timestamps();
            
                // 外部キー設定
                /*
                onDelete は参照先のデータが削除されたときにこのテーブルの行をどのように扱うかを指定します
                onDelete('cascade') で、ユーザーテーブルのユーザーデータが削除されたら、
                それにひもづくフォローテーブルのフォロー、フォロワーのレコードも削除されるようにしました。
                */
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('follow_id')->references('id')->on('users')->onDelete('cascade');

                // user_idとfollow_idの組み合わせの重複を許さない
                //これは一度保存したフォロー関係を何度も保存しようとしないようにテーブルの制約として入れています
            $table->unique(['user_id', 'follow_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_follow');
    }
}
