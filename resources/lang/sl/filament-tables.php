<?php

return [
    'pagination' => [
        'label' => 'Navigacija po straneh',
        'overview' => 'Prikazujem :first do :last od :total rezultatov',
        'fields' => [
            'records_per_page' => [
                'label' => 'na stran',
                'options' => [
                    'all' => 'Vsi',
                ],
            ],
        ],
        'actions' => [
            'go_to_page' => [
                'label' => 'Pojdi na stran :page',
            ],
            'next' => [
                'label' => 'Naprej',
            ],
            'previous' => [
                'label' => 'Nazaj',
            ],
        ],
    ],

    'empty' => [
        'heading' => 'Ni zapisov',
        'description' => 'Ustvarite svoj prvi zapis za začetek.',
    ],

    'filters' => [
        'actions' => [
            'remove' => 'Odstrani filter',
            'remove_all' => 'Odstrani vse filtre',
            'reset' => 'Ponastavi',
        ],
        'heading' => 'Filtri',
        'indicator' => 'Aktivni filtri',
        'multi_select' => [
            'placeholder' => 'Vsi',
        ],
        'select' => [
            'placeholder' => 'Vsi',
        ],
        'trashed' => [
            'label' => 'Izbrisani zapisi',
            'only_trashed' => 'Samo izbrisani zapisi',
            'with_trashed' => 'Z izbrisanimi zapisi',
            'without_trashed' => 'Brez izbrisanih zapisov',
        ],
    ],
];
