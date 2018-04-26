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
            $table->integer('token_id');
            $table->integer('type')->default(0);
            $table->string('other_type')->nullable();
            $table->integer('reference')->default(0);
            $table->string('other_referenc')->nullable();
            $table->decimal('price', 10, 0);
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
