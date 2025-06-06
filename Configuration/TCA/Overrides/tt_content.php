<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3') or die();

$ll = 'LLL:EXT:ot_irrebuttons/Resources/Private/Language/locallang_be.xlf:';

$extensionSettings = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('ot_irrebuttons');

ExtensionManagementUtility::addFieldsToPalette(
    'tt_content',
    'irreButtons',
    'tx_otirrebuttons_button_size, tx_otirrebuttons_button_position'
);

$tempColumns = [
    'tx_otirrebuttons_domain_model_buttons' => [
        'exclude' => 1,
        'label' => $ll . 'tx_otirrebuttons_domain_model_button.label',
        'description' => $ll . 'tx_otirrebuttons_domain_model_button.description',
        'config' => [
            'type' => 'inline',
            'foreign_field' => 'parent_id',
            'foreign_table' => 'tx_otirrebuttons_domain_model_button',
            'foreign_sortby' => 'sorting',
            'foreign_table_field' => 'parent_table',
            'appearance' => [
                'collapseAll' => true,
                'showSynchronizationLink' => true,
                'showAllLocalizationLink' => true,
                'useSortable' => true,
                'showPossibleLocalizationRecords' => true,
            ]
        ]
    ],
    'tx_otirrebuttons_button_size' => [
        'exclude' => 1,
        'label' => $ll . 'tx_otirrebuttons_button_size.label',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'label' => $ll . 'tx_otirrebuttons_button_size.default',
                    'value' => ''
                ],
                [
                    'label' => $ll . 'tx_otirrebuttons_button_size.small',
                    'value' => 'btn-sm'
                ],
                [
                    'label' => $ll . 'tx_otirrebuttons_button_size.large',
                    'value' => 'btn-lg'
                ],
            ],
            'size' => 1,
            'maxitems' => 1,
        ]
    ],
    'tx_otirrebuttons_button_position' => [
        'exclude' => true,
        'label' => $ll . 'tx_otirrebuttons_button_position.label',
        'l10n_mode' => 'exclude',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [
                    'label' => '',
                    'value' => ''
                ],
                [
                    'label' => $ll . 'tx_otirrebuttons_button_position.start',
                    'value' => 'start'
                ],
                [
                    'label' => $ll . 'tx_otirrebuttons_button_position.center',
                    'value' => 'center'
                ],
                [
                    'label' => $ll . 'tx_otirrebuttons_button_position.end',
                    'value' => 'end'
                ],
            ],
            'size' => 1,
            'maxitems' => 1,
        ]
    ],
];

ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumns);

if (isset($extensionSettings['enableButtonsForCTypes']) && $extensionSettings['enableButtonsForCTypes'] !== '') {
    ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        '--palette--;' . $ll . 'tx_otirrebuttons.palette.label;irreButtons, tx_otirrebuttons_domain_model_buttons',
        $extensionSettings['enableButtonsForCTypes'],
        'after:bodytext'
    );
}
