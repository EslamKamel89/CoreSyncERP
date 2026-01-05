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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->foreignId('grade_id')->nullable()->constrained()->nullOnDelete();
            $this->locale($table, 'name');
            $table->boolean('is_active')->default(true);
            $this->whiteLabelColumns($table);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('positions');
    }
};
