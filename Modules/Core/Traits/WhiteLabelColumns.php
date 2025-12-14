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
}
