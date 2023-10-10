<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id'); // bigIncrements = 主キーを作成に使う
            $table->unsignedBigInteger('user_id'); // unsignedBigInteger = 外部キーのデータ型によく使う
            $table->string('is_deleted', 4)->default('0');
            $table->date('date'); // 年月日
            $table->string('title');
            $table->string('author');
            $table->string('publication');
            $table->integer('price');
            $table->text('remarks')->nullable();  // nullable = nullを許容する;
            $table->text('image')->nullable(); // nullable = nullを許容する
            $table->timestamps();

            // 外部キー制約 (存在するuserのidしか登録できなくなるので整合性が保てる)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // usersが消されたときに紐付くpostsも消える
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
