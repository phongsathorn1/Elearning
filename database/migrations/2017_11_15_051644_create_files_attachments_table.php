<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('filepath');
            $table->string('type');
            $table->integer('user_id');
            $table->timestamps();
        });

        Schema::create('files_attachment_post', function (Blueprint $table) {
            $table->integer('post_id');
            $table->integer('files_attachment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files_attachments');
    }
}
