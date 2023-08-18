<?php

return [
    'required' => 'Ce champ est requis',
    'email' => 'Email invalide',

    'gt' => [
        'numeric' => 'La valeur de ce champ doit être supérieur à 0',
    ],

    'custom' => [
        'email' => [
            'regex' => 'Email invalide',
            'unique' => 'Cette email est déjà utilisé'
        ]
    ],
];