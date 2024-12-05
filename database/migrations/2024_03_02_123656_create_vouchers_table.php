<?php

use App\Models\User;
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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->string('voucher_id')->primary();
            $table->string('name');
            $table->string('description');
            $table->double('discount');
            $table->string('type');
            $table->integer('quantity');
            $table->integer('used')->default(0);
            $table->boolean('status')->default(true);
            
            $table->datetime('start_time');
            $table->dateTime('end_time');
            $table->timestamps();

            $table->foreignIdFor(User::class)->nullable()->constrained()->cascadeOnDelete();
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
