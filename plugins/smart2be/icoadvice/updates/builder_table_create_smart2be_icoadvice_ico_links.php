<?php namespace Smart2be\IcoAdvice\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSmart2beIcoadviceLinks extends Migration
{
    public function up()
    {
        Schema::create('smart2be_icoadvice_ico_links', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('ico_id');
            $table->string('type')->default(0);
            $table->string('other')->nullable();
            $table->string('url');
            $table->string('description');
            $table->integer('status')->default(0);
            $table->boolean('approved')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('smart2be_icoadvice_ico_links');
    }
}
