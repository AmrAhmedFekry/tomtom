<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cats', function (Blueprint $table) {
            // this is very important to create a unique index for the id
            $table->unique('id');
            // Index of createdBy id
            $table->index('createdBy.id');
            // the auto increment is just dummy pass, it is auto generated for every single model 
            $table->int('id');
            $table->increments('id');

            // all of it are just dummy pass, it can be changed from the model class            
            $table->string('createdAt');
            $table->string('createdBy');
            $table->string('updatedAt ');
            $table->string('updatedBy');
            $table->string('deletedAt');
            $table->string('deletedBy');
            
			$table->string('name');
			$table->integer('order');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cats');
    }
}
