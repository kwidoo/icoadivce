<?php namespace Smart2be\IcoAdvice\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSmart2beIcoadviceIcoDates extends Migration
{
    public function up()
    {
        Schema::create('smart2be_icoadvice_ico_dates', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('ico_id');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('type');
            $table->string('other')->nullable();
            $table->text('description');
            $table->integer('status')->default(0);
            $table->boolean('approved')->default(0);
            $table->integer('admin_id')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('smart2be_icoadvice_ico_dates');
    }
}
