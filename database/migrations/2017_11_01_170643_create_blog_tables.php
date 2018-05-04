<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // blog_posts
        $this->createBlogPostsTable();

        // blog_categories & blog_post_categories
        $this->createBlogCategoryTables();

        // blog_tags & blog_post_tags
        $this->createBlogTagsTables();

        // blog_comments
        $this->createBlogCommentsTable();

        // blog_images
        $this->createBlogImagesTable();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("blog_post_images");
        Schema::dropIfExists("blog_post_comments");
        Schema::dropIfExists("blog_post_destinations");
        Schema::dropIfExists("blog_post_tags");
        Schema::dropIfExists("blog_tags");;
        Schema::dropIfExists("blog_post_categories");
        Schema::dropIfExists("blog_categories");
        Schema::dropIfExists("blog_posts");
    }

    private function createBlogPostsTable()
    {
        Schema::create("blog_posts", function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("site_id")->nullable();
            $table->unsignedInteger("author_id")->nullable();
            $table->string("title");
            $table->string("slug")->nullable();
            $table->text("content");
            $table->unsignedInteger("blog_image_id")->nullable();
            $table->char("status", 1)->default("D");
            $table->char("format", 1)->default("S");
            $table->boolean("is_approved");
            $table->unsignedInteger("approved_by")->nullable();
            $table->boolean("comments_enabled")->nullable();
            $table->timestamp("published_at")->default(\Illuminate\Support\Facades\DB::raw("CURRENT_TIMESTAMP"));
            $table->timestamps();
            $table->softDeletes();

            if (Schema::hasTable("users")) {
                $table->foreign("author_id")
                    ->references("id")
                    ->on("users");

                $table->foreign("approved_by")
                    ->references("id")
                    ->on("users");
            }
        });
    }

    private function createBlogCategoryTables()
    {
        Schema::create("blog_categories", function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("site_id")->nullable();
            $table->string("name");
            $table->text("description")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("blog_post_categories", function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("blog_post_id");
            $table->unsignedInteger("blog_category_id");

            $table->unique(['blog_post_id', 'blog_category_id']);

            $table->foreign("blog_post_id")
                ->references("id")
                ->on("blog_posts")
                ->onUpdate("cascade")
                ->onDelete("cascade");

            $table->foreign("blog_category_id")
                ->references("id")
                ->on("blog_categories")
                ->onUpdate("cascade")
                ->onDelete("cascade");
        });
    }

    private function createBlogTagsTables()
    {
        Schema::create("blog_tags", function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("site_id")->nullable();
            $table->string("name");
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("blog_post_tags", function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("blog_post_id");
            $table->unsignedInteger("blog_tag_id");

            $table->unique(['blog_tag_id', 'blog_post_id']);

            $table->foreign("blog_post_id")
                ->references("id")
                ->on("blog_posts")
                ->onUpdate("cascade")
                ->onDelete("cascade");

            $table->foreign("blog_tag_id")
                ->references("id")
                ->on("blog_tags")
                ->onUpdate("cascade")
                ->onDelete("cascade");
        });
    }

    private function createBlogCommentsTable()
    {
        Schema::create("blog_post_comments", function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("blog_post_id");
            $table->unsignedInteger("author_id");
            $table->unsignedInteger("parent_id")->nullable();
            $table->integer("depth")->default(1);
            $table->char("status", 1)->default("P");
            $table->text("content");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("blog_post_id")
                ->references("id")
                ->on("blog_posts");

            if (Schema::hasTable("users")) {
                $table->foreign("author_id")
                    ->references("id")
                    ->on("users");
            }

            $table->foreign("parent_id")
                ->references("id")
                ->on("blog_post_comments");
        });
    }

    public function createBlogImagesTable()
    {
        Schema::create("blog_post_images", function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("site_id")->nullable();
            $table->string("storage_location");
            $table->string("path");
            $table->string("caption")->nullable();
            $table->string("alt_text")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
