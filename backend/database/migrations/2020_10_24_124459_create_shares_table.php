<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shares', function (Blueprint $table) {
            $table->id();
            
            $table->string('symbol')->unique();
            $table->string('name');
            $table->text('description');
            $table->string('exchange');
            $table->json('history');
            $table->string('currency');
            $table->string('country');
            $table->string('sector');
            $table->string('industry');
            $table->string('address');
            $table->bigInteger('full_time_employees');
            $table->bigInteger('market_capitalization');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shares');
    }
}
