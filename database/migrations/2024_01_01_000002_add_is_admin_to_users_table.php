<?php

use Illuminate\Database\Migrations\Migration;

// File ini dikosongkan karena kolom is_admin sudah ada di migration users utama
// (2024_01_01_000001_create_users_sessions_table.php)
return new class extends Migration
{
    public function up(): void
    {
        // is_admin sudah dibuat di migration create_users_sessions_table
    }

    public function down(): void
    {
        //
    }
};
