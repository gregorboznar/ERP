<?php

return [

  'label' => 'Navigacija po straneh',

  'overview' => '{1} Prikazujem 1 rezultat|[2,*] Prikazujem :first do :last od :total rezultatov',

  'fields' => [

    'records_per_page' => [

      'label' => 'Na stran',

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

];
