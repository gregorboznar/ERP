<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Table Columns
    |--------------------------------------------------------------------------
    */

    'column.name' => 'Ime',
    'column.guard_name' => 'Ime Vloge',
    'column.roles' => 'Vloge',
    'column.permissions' => 'Dovoljenja',
    'column.updated_at' => 'Posodobljeno',

    /*
    |--------------------------------------------------------------------------
    | Form Fields
    |--------------------------------------------------------------------------
    */

    'field.name' => 'Ime',
    'field.guard_name' => 'Ime vloge',
    'field.permissions' => 'Dovoljenja',
    'field.select_all.name' => 'Izberi vse',
    'field.select_all.message' => 'Omogoči vsa dovoljenja, ki so <span class="text-primary font-medium">na voljo</span> za to vlogo',

    /*
    |--------------------------------------------------------------------------
    | Navigation & Resource
    |--------------------------------------------------------------------------
    */

    'nav.group' => 'Filament Shield',
    'nav.role.label' => 'Vloge',
    'nav.role.icon' => 'heroicon-o-shield-check',
    'resource.label.role' => 'Vloga',
    'resource.label.roles' => 'Vloge',

    /*
    |--------------------------------------------------------------------------
    | Section & Tabs
    |--------------------------------------------------------------------------
    */

    'section' => 'Entitete',
    'resources' => 'Moduli',
    'widgets' => 'Gradniki',
    'pages' => 'Strani',
    'custom' => 'Dovoljenja po meri',

    /*
    |--------------------------------------------------------------------------
    | Messages
    |--------------------------------------------------------------------------
    */

    'forbidden' => 'Nimate dostopa',

    /*
    |--------------------------------------------------------------------------
    | Resource Permissions' Labels
    |--------------------------------------------------------------------------
    */

    'resource_permission_prefixes_labels' => [
        'view' => 'Ogled',
        'view_any' => 'Ogled kateregakoli',
        'create' => 'Ustvari',
        'update' => 'Posodobi',
        'delete' => 'Izbriši',
        'delete_any' => 'Izbriši kateregakoli',
        'force_delete' => 'Trajno izbriši',
        'force_delete_any' => 'Trajno izbriši kateregakoli',
        'restore' => 'Obnovi',
        'reorder' => 'Spremeni vrstni red',
        'restore_any' => 'Obnovi kateregakoli',
        'replicate' => 'Podvoji',
    ],
];
