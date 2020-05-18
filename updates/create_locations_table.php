<?php namespace AlbrightLabs\ClientLocations\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateLocationsTable extends Migration
{
    public function up()
    {
        Schema::create('albrightlabs_clientlocations_locations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
            $table->integer('client_id')->nullable();
            $table->string('title')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->integer('is_default')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('albrightlabs_clientlocations_locations');
    }
}
