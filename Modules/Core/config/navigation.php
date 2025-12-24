<?php


/**
 * Navigation Configuration Schema
 * ================================
 *
 * This file returns an array of NavigationItem definitions.
 *
 * Each item MUST follow the structure described below.
 *
 * ------------------------------------------------------------------
 * NavigationItem
 * ------------------------------------------------------------------
 *
 * @type array{
 *   key: string,
 *   label: string,
 *   icon?: string,
 *   route?: string,
 *   permission?: string,
 *   children?: NavigationItem[]
 * }
 *
 * ------------------------------------------------------------------
 * Field Definitions
 * ------------------------------------------------------------------
 *
 * @property string key
 *   A unique identifier for the navigation item.
 *   - Must be unique across the entire navigation tree
 *   - Used for active state, lookups, and extensions
 *
 * @property string label
 *   The display label shown in the navigation UI.
 *   - Should be a human-readable string
 *   - Recommended to be replaced with translation keys
 *
 * @property string|null icon
 *   Optional icon identifier.
 *   - Interpretation is left to the UI layer
 *   - Example values: "home", "cog", "users"
 *
 * @property string|null route
 *   Optional named route.
 *   - Required if the item is clickable
 *   - Must correspond to a registered Laravel route name
 *
 * @property string|null permission
 *   Optional permission required to display the item.
 *   - Uses Spatie Laravel Permission
 *   - If defined, item SHOULD be hidden when permission is missing
 *
 * @property NavigationItem[]|null children
 *   Optional list of child navigation items.
 *   - Presence of children indicates a grouping item
 *   - Parent items with children SHOULD NOT define a route
 *
 * ------------------------------------------------------------------
 * Structural Rules (Contract)
 * ------------------------------------------------------------------
 *
 * 1. An item MAY define either:
 *    - route
 *    - OR children
 *
 * 2. An item MUST NOT define both route and children.
 *
 * 3. Children items MUST follow the same NavigationItem schema.
 *
 * 4. Permission checks are additive:
 *    - Child permissions do NOT inherit automatically
 *
 * This file MUST return:
 *
 * @return NavigationItem[]
 */


return [
    [
        'key'   => 'dashboard',
        'label' => 'core::navigation.dashboard',
        'route' => 'dashboard',
        'icon'  => 'home',
    ],
    [
        'key'   => 'settings',
        'label' => 'core::navigation.settings',
        'icon'  => 'cog',
        'children' => [
            [
                'key'   => 'company-profile',
                'label' => 'core::navigation.company',
                'route' => 'core.settings.company',
                'permission' => 'core.manage_settings',
            ],
        ],
    ],
];
