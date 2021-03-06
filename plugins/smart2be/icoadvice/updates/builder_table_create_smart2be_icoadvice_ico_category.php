<?php namespace Smart2be\IcoAdvice\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSmart2beIcoadviceIcoCategory extends Migration
{
    public function up()
    {
        Schema::create('smart2be_icoadvice_ico_category', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->boolean('published')->default(0);
            $table->integer('admin_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('smart2be_icoadvice_ico_category');
    }
}
