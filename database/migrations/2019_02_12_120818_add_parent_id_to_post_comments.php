<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParentIdToPostComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("blog_comments", function (Blueprint $table) {
            $table->unsignedInteger("parent_id")->after("post_id")->nullable();
            $table->timestamp("deleted_at")->nullable();

            $table->foreign("parent_id")->references("id")->on("blog_comments")
                ->onUpdate("cascade")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("blog_comments", function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'deleted_at']);
        });
    }
}
