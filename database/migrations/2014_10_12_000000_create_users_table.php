<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // id	name	email	phone	country_code address  role[admin,telecaller]
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->string('phone');
            $table->String('country_code')->nullable()->default(NULL);
            $table->String('address')->nullable()->default(NULL);
            $table->enum('role', ['admin', 'telecaller'])->default('telecaller');
            $table->string('remember_token')->nullable()->default(NULL);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['email','deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
