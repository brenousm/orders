<?php

use App\Models\Status;
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
        Schema::create('orders', function (Blueprint $table) {

            //columns
            $table->bigIncrements('id');
            $table->string('requester_name');
            $table->string('destination');
            $table->date('departure');
            $table->date('arrival');
            $table->foreignId('user_id');
            $table->foreignId('status_id');
            $table->timestamps();
            
            //constraints
            $table->foreign('status_id')
                ->references('id')
                ->on('status')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
