<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publication_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('publication_id')->unsigned();
            $table->integer('tag_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('publication_id')->references('id')->on('publications');
            $table->foreign('tag_id')->references('id')->on('tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publication_tag');
    }
}
