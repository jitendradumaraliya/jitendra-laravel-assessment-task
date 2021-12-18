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
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email',255)->unique();
            $table->string('password');
            $table->string('dob',200);
            $table->enum('gender',['Male','Female']);
            $table->decimal('annual_income',50,2);
            $table->string('occupation')->nullable();
            $table->string('family_type')->nullable();
            $table->enum('manglik',['Yes','No']);
            $table->integer('partner_expected_income_min')->default(0);
            $table->integer('partner_expected_income_max')->default(0);
            $table->string('partner_occupation')->nullable();
            $table->string('partner_family_type')->nullable();
            $table->string('partner_manglik')->nullable();
            $table->string('google_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
