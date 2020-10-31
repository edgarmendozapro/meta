<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetasTable extends Migration
{
    public function up()
    {
        Schema::create('metas', function (Blueprint $table) {
            $table->id('id');
            $table
                ->bigInteger('media_resource_id')
                ->unsigned()
                ->nullable();
            $table->string('title');
            $table->string('description')->nullable();
            $table->boolean('index')->default(true);
            $table
                ->foreign('media_resource_id')
                ->references('id')
                ->on('media_resources');
        });
    }

    public function down()
    {
        Schema::dropIfExists('metas');
    }
}
