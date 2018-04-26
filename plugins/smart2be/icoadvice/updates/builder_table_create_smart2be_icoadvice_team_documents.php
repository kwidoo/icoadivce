<?php namespace Smart2be\IcoAdvice\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSmart2beIcoadviceTeamDocuments extends Migration
{
    public function up()
    {
        Schema::create('smart2be_icoadvice_team_documents', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('team_id');
            $table->integer('type')->default(0);
            $table->string('other')->nullable();;
            $table->boolean('accepted')->default(false);
            $table->integer('admin_id')->nullable();
            $table->dateTime('accpeted_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('smart2be_icoadvice_team_documents');
    }
}
