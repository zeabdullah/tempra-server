<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('time_capsules', function (Blueprint $table) {
            $table->dateTime('reveal_date')->change();
        });
    }

    /**
     * Reverse the migrations.z
     */
    public function down(): void
    {
        //
    }
};
