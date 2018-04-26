<?php namespace Smart2be\IcoAdvice\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSmart2beIcoadviceIco extends Migration
{
    public function up()
    {
        Schema::create('smart2be_icoadvice_ico', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('tiker');
            $table->string('slogan')->nullable();
            $table->integer('category_id')->default(0);
            $table->text('short')->nullable();                  // Short description of project
            $table->text('description')->nullable();;           // Long description of project
            $table->decimal('soft_cap')->nullable();            // if '0' not present
            $table->decimal('hard_cap')->nullable();            // if '0' not present
            $table->integer('cap_nomination')->default(0);      // Cap currency or Other
            $table->string('other')->nullable();                // Currency name
            $table->integer('status')->default(0);
            $table->boolean('approved')->default(false);
            $table->integer('admin_id')->nullable();
            $table->dateTime('approved_at')->nullable();;
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('smart2be_icoadvice_ico');
    }
}
