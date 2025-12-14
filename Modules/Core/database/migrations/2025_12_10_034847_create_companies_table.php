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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('legal_name')->nullable();
            $table->string('tax_number')->nullable()->index();
            $table->string('base_currency', 3)->default('USD');
            $table->string('timezone')->default('UTC');
            $table->string('locale')->default('en');
            $table->string('fiscal_year_start')->nullable();
            $this->whiteLabelColumns($table);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('companies');
    }
};
