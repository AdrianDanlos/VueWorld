<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceAndAddressToBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedInteger('price');

            $table->unsignedBigInteger('address_id')->index()->nullable(); //We make it nullable for development purposes, since the bookings in our database don't have an adress.
            $table->foreign('address_id')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('price');

            $table->dropForeign(['address_id']); //We use square brackets to specify the fk name because laravel changes the fk name on the background, so we would need to find the name laravel has given to it if we would like to pass it as a string.
            $table->dropColumn('address_id');
        });
    }
}
