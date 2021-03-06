<?php namespace Smart2be\IcoAdvice\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSmart2beIcoadviceIcoTokenPrice extends Migration
{
    public function up()
    {
        Schema::create('smart2be_icoadvice_ico_token_price', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('ico_token_id');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->integer('bonus')->default(0);
            $table->string('value')->default(0);
            $table->string('nomination')->nullable();
            $table->integer('status')->default(0);
            $table->boolean('approved')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('smart2be_icoadvice_ico_token_price');
    }
}
