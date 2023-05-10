<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('telecaller_id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone');
            $table->enum('status', ['pending', 'in progress','on hold','converted'])->default('pending');
            $table->foreign('campaign_id')->references('id')->on('campaigns');
            $table->foreign('telecaller_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
}
