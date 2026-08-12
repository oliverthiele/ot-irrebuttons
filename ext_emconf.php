<?php

$EM_CONF['ot_irrebuttons'] = [
    'title' => 'IRRE Buttons',
    'description' => 'Adds buttons to content elements with IRRE',
    'category' => 'fe',
    'author' => 'Oliver Thiele',
    'author_email' => 'mail@oliver-thiele.de',
    'author_company' => 'Web Development Oliver Thiele',
    'state' => 'stable',
    'version' => '5.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '14.3.0-14.99.99',
            'php' => '8.4.0-8.99.99',
        ],
        'conflicts' => [],
        'suggests' => [
            'ot_icons' => '',
            'ot_iconselector' => '',
        ],
    ],
];
