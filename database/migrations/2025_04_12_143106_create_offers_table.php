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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name')->nullable();
            $table->foreignIdFor(App\Models\Item::class, 'item_id')->constrained('items');
            $table->foreignIdFor(App\Models\Item::class, 'offered_item_id')->constrained('items');
            $table->foreignIdFor(App\Models\User::class, 'user_id')->constrained('users');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
