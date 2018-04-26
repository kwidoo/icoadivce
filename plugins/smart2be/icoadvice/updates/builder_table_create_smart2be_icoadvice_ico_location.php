<?php namespace Smart2be\IcoAdvice\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSmart2beIcoadviceIcoLocation extends Migration
{
    public function up()
    {
        Schema::create('smart2be_icoadvice_ico_location', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('ico_id');
            $table->string('name')->nullable();
            $table->string('legal')->nullable();
            $table->text('address');
            $table->boolean('published')->default(0);
            $table->integer('status')->default(0);
            $table->boolean('approved')->default(0);
            $table->integer('admin_id')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('smart2be_icoadvice_ico_location');
    }
}
