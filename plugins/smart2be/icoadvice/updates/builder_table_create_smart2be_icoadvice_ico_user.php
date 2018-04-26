<?php namespace Smart2be\IcoAdvice\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSmart2beIcoadviceIcoUser extends Migration
{
    public function up()
    {
        Schema::create('smart2be_icoadvice_ico_user', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('ico_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();       
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('smart2be_icoadvice_ico_user');
    }
}
