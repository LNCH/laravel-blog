<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("post_id");
            $table->unsignedInteger("user_id")->nullable();
            $table->string("name")->nullable();
            $table->string("email")->nullable();
            $table->text("body");
            $table->char("status", 1);
            $table->unsignedInteger("moderated_by")->nullable();
            $table->datetime("moderated_at")->nullable();
            $table->timestamps();

            $table->foreign("post_id")
                ->references("id")
                ->on("blog_posts")
                ->onUpdate("cascade")
                ->onDelete("no action");

            $table->foreign("user_id")
                ->references("id")
                ->on("users")
                ->onUpdate("cascade")
                ->onDelete("no action");

            $table->foreign("moderated_by")
                ->references("id")
                ->on("users")
                ->onUpdate("cascade")
                ->onDelete("no action");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_comments');
    }
}
