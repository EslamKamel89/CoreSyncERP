<?php

namespace Modules\Core\Traits;
/*

 [
    'headers' => [...],
    'rows' => [
        [
            'cells' => [...],
            'actions' => [...],
        ],
    ],
    'emptyLabel' => '...',
]

 */

trait BuildsListData {
    public function makeListData(
        array $headers,
        array $rows,
        string $emptyLabel
    ): array {
        return [
            'headers' => array_values($headers),
            'rows' => array_map(function (array $row) {
                if (!isset($row['cells']) || !isset($row['actions'])) {
                    throw new \Exception('each row in rows must contain keys cells and actions');
                }
                return [
                    'cells' => array_values($row['cells'] ?? []),
                    'actions' => $row['actions'] ?? [],
                ];
            }, $rows),
            'emptyLabel' => $emptyLabel,
        ];
    }
}
