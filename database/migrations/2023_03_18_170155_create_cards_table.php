<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')
                    ->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->string('card_number')->unique();
            $table->string('cvv');
            $table->string('expiry_date');
            $table->string('card_pin')->nullable();
            $table->string('duress_pin')->nullable();
            $table->enum('card_type', ['visa', 'verve', 'mastercard'])->nullable();
            $table->enum('status', ['active', 'blocked', 'suspended'])->nullable();
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
        Schema::dropIfExists('cards');
    }
}
