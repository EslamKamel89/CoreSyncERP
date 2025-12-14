<?php

namespace Modules\Core\Enums;

enum CoreTag: string {
    case URGENT = 'Urgent';
    case HIGH_PRIORITY = 'High Priority';
    case LOW_PRIORITY = 'Low Priority';

    case DRAFT = 'Draft';
    case PENDING_REVIEW = 'Pending Review';
    case APPROVED = 'Approved';
    case ARCHIVED = 'Archived';

    case INTERNAL = 'Internal';
    case EXTERNAL = 'External';
    case CONFIDENTIAL = 'Confidential';

    case HR = 'HR';
    case FINANCE = 'Finance';
    case INVENTORY = 'Inventory';

    case REQUIRES_ATTENTION = 'Requires Attention';
    case VERIFIED = 'Verified';
    public static function values(): array {
        return array_map(
            fn(self $tag) => $tag->value,
            self::cases()
        );
    }
    public function slug(): string {
        return str($this->value)->slug();
    }
}
