<?php
//中間テーブルの作成
//お気に入り機能なのでテーブル名は favorites
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('micropost_id')->unsigned()->index();
            $table->timestamps();

            // 外部キー設定
            //$table->foreign(外部キーを設定するカラム名)->references(制約先のID名)->on(外部キー制約先のテーブル名);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('micropost_id')->references('id')->on('microposts')->onDelete('cascade');//on('micropost')????
            

            // user_idとmicropost_idの組み合わせの重複を許さない
            $table->unique(['user_id', 'micropost_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
