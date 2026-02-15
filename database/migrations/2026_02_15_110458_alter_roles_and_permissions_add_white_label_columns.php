<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Core\Traits\WhiteLabelColumns;

return new class extends Migration {
    use WhiteLabelColumns;
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('roles', function (Blueprint $table) {
            $this->whiteLabelColumns($table);
        });

        Schema::table('permissions', function (Blueprint $table) {
            $this->whiteLabelColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn([
                'external_id',
                'meta',
                'status',
                'created_by',
            ]);
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn([
                'external_id',
                'meta',
                'status',
                'created_by',
            ]);
        });
    }
};
