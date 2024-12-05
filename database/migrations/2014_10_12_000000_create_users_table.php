<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->index('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('gender') ->nullable() ;
            $table->date('birthofday')->default(date('Y-m-d'));
            $table->string('phone')->nullable();
            $table->integer('address_defaultid')->nullable();
            $table->string('avatar')->default("https://firebasestorage.googleapis.com/v0/b/clothingstore-741c3.appspot.com/o/avatars%2Foneways.jpg?alt=media&token=7426420c-a514-456e-8673-89772540b70f");
            $table->tinyInteger('is_active')->default(1);
            $table->float('coin')->default(0);
            $table->date('createdat')->default(date('Y-m-d'));
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
