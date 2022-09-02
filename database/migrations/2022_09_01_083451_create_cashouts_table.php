<?php

use App\Models\Cashout;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('cashouts', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->double('amount');
            $table->integer('status')->default(Cashout::$CASHOUT_STATUS_PENDING);
            $table->dateTime('request_date')->nullable();
            $table->dateTime('approved_date')->nullable();
            $table->dateTime('release_date')->nullable();
            $table->dateTime('received_date')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('cashouts');
    }
};
