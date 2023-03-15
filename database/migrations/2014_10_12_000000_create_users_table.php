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
            $table->uuid('id')->primary();
            $table->string('fullname');
            $table->string('username')->unique();
            $table->string('bvn')->unique();
            $table->string('account_number')->unique();
            $table->string('passcode')->nullable();
            $table->string('transaction_pin')->nullable();
            $table->string('duress_pin')->nullable();
            $table->integer('completed_profile')->default(1);
            $table->float('wallet_balance', 11, 2)->default(0);
            $table->float('safe_balance', 11, 2)->default(0);
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
        Schema::dropIfExists('users');
    }
}
