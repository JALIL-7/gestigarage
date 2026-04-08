<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE reparations MODIFY COLUMN statut ENUM('en attente', 'en cours', 'terminee', 'annulee') DEFAULT 'en attente'");
        } elseif (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE reparations DROP CONSTRAINT IF EXISTS reparations_statut_check");
            DB::statement("ALTER TABLE reparations ADD CONSTRAINT reparations_statut_check CHECK (statut::text = ANY (ARRAY['en attente', 'en cours', 'terminee', 'annulee']::text[]))");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE reparations MODIFY COLUMN statut ENUM('en attente', 'en cours', 'terminee') DEFAULT 'en attente'");
        } elseif (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE reparations DROP CONSTRAINT IF EXISTS reparations_statut_check");
            DB::statement("ALTER TABLE reparations ADD CONSTRAINT reparations_statut_check CHECK (statut::text = ANY (ARRAY['en attente', 'en cours', 'terminee']::text[]))");
        }
    }
};
