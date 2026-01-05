<?php

namespace Modules\Core\Traits;

use Illuminate\Database\Schema\Blueprint;

trait WhiteLabelColumns {
    protected function whiteLabelColumns(Blueprint $table): void {
        $table->string('external_id')->nullable();
        $table->json('meta')->nullable();
        $table->string('status')->default('active');
        $table->foreignId('created_by')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();
    }
    protected function money(Blueprint $table, string $name, bool $nullable = false): void {
        if ($nullable) {
            $table->decimal($name, 14, 4)->nullable()->default(null);
        } else {
            $table->decimal($name, 14, 4);
        }
    }
    protected function calculation(Blueprint $table, string $name, bool $nullable = false): void {
        if ($nullable) {
            $table->decimal($name, 16, 8)->nullable()->default(null);
        } else {
            $table->decimal($name, 16, 8);
        }
    }
    protected function locale(Blueprint $table, string $name, bool $required = true): void {
        if ($required) {
            $table->json($name);
        } else {
            $table->json($name)->nullable();
        }
    }
}
