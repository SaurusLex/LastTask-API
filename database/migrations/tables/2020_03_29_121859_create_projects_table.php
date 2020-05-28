<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("description");
            $table->integer("client_id")->nullable(true);
            $table->integer("user_id");
            $table->timestamp("start_date")->useCurrent();
            $table->timestamp("finish_date")->nullable(true);
            $table->string("img_src");
            $table->double("cost_per_hour")->default(0);
            $table->string("status");
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
        Schema::dropIfExists('projects');
    }
}
