<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relaciones.addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned(); //no puede tener numeros negativos
            $table->string('name');
            $table->string('country');
            $table->string('password');
            $table->timestamps();

            //declarar la relacion
            //la columna 'user_id' es una clave foranea que hace referencia a la clave 'id' de la tabla 'users'
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relaciones.addresses');
    }
}
