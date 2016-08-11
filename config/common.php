<?php

return [
    'user' => [
        'role' => [
            'trainee' => 0,
            'supervisor' => 1,
        ],
    ],
    'base_repository' => [
        'filter' => [],
        'attributes' => null,
    ],
    'pagination' => [
        'per_page_subject' => 5,
        'per_page_task' => 5,
    ],
    'status' => [
        1 => 'Created',
        2 => 'In Progress',
        3 => 'Cancel',
        4 => 'Pending',
    ],
    'action_type' => [
        'create' => 0,
        'update' => 1,
        'delete' => 2,
        'join' => 3,
        'finish' => 4,
        'start' => 5,
    ],
    'paginate_document_per_page' => 5,
];
