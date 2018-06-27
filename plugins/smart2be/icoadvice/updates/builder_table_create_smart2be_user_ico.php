<?php namespace Smart2be\IcoAdvice\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateIcoUser extends Migration
{
    public function up()
    {
        Schema::create('ico_user', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('user_id');
            $table->integer('ico_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('ico_user');
    }
}
