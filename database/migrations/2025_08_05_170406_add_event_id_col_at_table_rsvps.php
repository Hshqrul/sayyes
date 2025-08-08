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
        Schema::table('rsvps', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id')->nullable()->index();

            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rsvps', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['event_id']);

            // Drop the index (optional, Laravel usually handles this with dropColumn)
            $table->dropIndex(['event_id']);

            // Drop the column
            $table->dropColumn('event_id');
        });
    }
};
