<?php namespace Smart2be\IcoAdvice\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSmart2beIcoadviceIcoToken extends Migration
{
    public function up()
    {
        Schema::create('smart2be_icoadvice_ico_token', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('ico_id');
            $table->integer('type')->default(0);
            $table->integer('status')->default(0);
            $table->boolean('approved')->default(0);
            $table->string('other')->nullable();
            $table->string('name');
            $table->integer('decimal')->nullable();
            $table->text('tracker')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('smart2be_icoadvice_ico_token');
    }
}
 