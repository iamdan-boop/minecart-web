<?php

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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->text('buyer_name');
            $table->integer('type');
            $table->double('price');
            $table->mediumText('note');
            $table->integer('status')->default(\App\Models\Item::$ITEM_STATUS_PENDING);
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->dateTime('drop_date')->nullable();
            $table->dateTime('claimed_date')->nullable();
            $table->text('display_price');
            $table->text('shelf_location');
            $table->double('handling_fee', 8, 2);
            $table->dateTime('expiry_date');
            $table->string('display');
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
        Schema::dropIfExists('items');
    }
};
