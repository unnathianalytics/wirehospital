<?php
return [
    'models' => [
        \App\Models\Patient::class => [
            'label' => 'Patient',
            'fields' => ['op_number', 'name', 'mobile', 'address'],
            'route_name' => 'patient_edit',
            'title' => 'name',
            'subtitle' => 'op_number',
        ],
        \App\Models\Item::class => [
            'label' => 'Items',
            'fields' => ['name', 'barcode', 'hsn_sac'],
            'route' => 'item_edit',
            'title' => 'name',
            'subtitle' => 'parent.name',
        ],
        \App\Models\Account::class => [
            'label' => 'Accounts',
            'fields' => ['name', 'email', 'mobile', 'gstin'],
            'route' => 'account_edit',
            'title' => 'name',
            'subtitle' => 'parent.name',
        ],
        \App\Models\Invoice::class => [
            'label' => 'Invoice',
            'fields' => ['description', 'invoice_number', 'invoice_date'],
            'route_name' => 'invoice_edit',
            'route_params' => [
                'invoiceType' => 'invoiceType',
                'invoiceId' => 'id',
            ],
            'title' => 'invoice_number',
            'subtitle' => 'invoiceType.name',
        ],
    ],
];
