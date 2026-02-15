<?php

return [
    'required' => 'Required',
    'optional' => 'Optional',
    'language' => 'Language',
    'no_role_assigned' => 'No role assigned',
    'action' => 'Action',
    'empty' => '➖',
    'active' => 'Active',
    'inactive' => 'In active',
    'all'      => 'All',
    'per_page' => 'Per page',
    'status'   => 'Status',
    'sort_by'  => 'Sort by',
    'none'     => 'None',
    'created_at' => 'Date of creation',
    'system' => 'System',
    'custom' => 'Custom',
    'alerts' => [

        // ✅ Success
        'saved' => 'Changes have been saved successfully.',
        'created' => 'Item created successfully.',
        'updated' => 'Item updated successfully.',
        'deleted' => 'Item deleted successfully.',
        'restored' => 'Item restored successfully.',
        'action_completed' => 'Action completed successfully.',

        // ⚠️ Authorization / Access
        'unauthorized' => 'You are not allowed to perform this action.',
        'forbidden' => 'Access denied.',
        'session_expired' => 'Your session has expired. Please log in again.',

        // ℹ️ State / No-op
        'no_changes' => 'No changes were made.',
        'nothing_to_update' => 'There is nothing to update.',
        'already_up_to_date' => 'Everything is already up to date.',

        // ❌ Errors (Generic)
        'something_went_wrong' => 'Something went wrong. Please try again.',
        'operation_failed' => 'The operation could not be completed.',
        'server_error' => 'A server error occurred. Please try again later.',

        // 🗑️ Destructive actions
        'confirm_delete' => 'Are you sure you want to delete this item?',
        'delete_failed' => 'Failed to delete the item.',

        // 🌐 System / Connectivity
        'network_error' => 'Network error. Please check your connection.',
        'service_unavailable' => 'Service is temporarily unavailable.',

    ],
];
