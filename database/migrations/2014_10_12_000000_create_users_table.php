<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('role_id')->unsigned()->nullable();
            $table->integer('organization_id')->unsigned()->nullable();
            $table->integer('location_id')->unsigned()->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            [
                'first_name' => 'Fullstack',
                'last_name'  => 'HQ',
                'role_id'    => 1,
                'full_name'  => 'Fullstack HQ',
                'email'      => 'kovrlijaivan@gmail.com',
                'password'   => bcrypt('fullstack')
            ]
        ]);
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