<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('products')
            ->where('short_description', 'like', '%100% Natural%')
            ->update([
                'short_description' => DB::raw("REPLACE(short_description, '100% Natural', 'Premium Natural')")
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('products')
            ->where('short_description', 'like', '%Premium Natural%')
            ->update([
                'short_description' => DB::raw("REPLACE(short_description, 'Premium Natural', '100% Natural')")
            ]);
    }
};
