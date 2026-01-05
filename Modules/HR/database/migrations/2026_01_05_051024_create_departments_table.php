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

        Schema::create('departments', function (Blueprint $table) {
            $table->id();
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
        Schema::dropIfExists('departments');
    }
};
