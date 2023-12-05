<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3') or die();

$ll = 'LLL:EXT:ot_irrebuttons/Resources/Private/Language/locallang_be.xlf:';

$extensionSettings = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('ot_irrebuttons');

$icons = [];

if (isset($extensionSettings['icons']) && trim($extensionSettings['icons']) !== '') {
    $iconArray = explode(',', $extensionSettings['icons']);
    $icons[] = ['', ''];
    foreach ($iconArray as $icon) {
        $icon = trim($icon);
        $icons[$icon] = [$ll . 'tx_otirrebuttons_domain_model_button.icons.' . $icon, $icon];
    }
}

return [
    'ctrl' => [
        'title' => $ll . 'tx_otirrebuttons_domain_model_button',
        'label' => 'text',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'sortby' => 'sorting',
        'hideTable' => true,
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
        'searchFields' => 'text',
        'iconfile' => 'EXT:ot_irrebuttons/Resources/Public/Icons/Extension.svg'
    ],
    'types' => [
        '1' => [
            'showitem' => '
            --div--;Link,
                --palette--;LLL:EXT:tx_otirrebuttons/Resources/Private/Language/locallang_be.xlf:palette.irreButtons;irreButtons,
            --div--;Sprache, sys_language_uid,l10n_parent,l10n_diffsource,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,starttime,endtime'
        ],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_otirrebuttons_domain_model_button',
                'foreign_table_where' => 'AND {#tx_otirrebuttons_domain_model_button}.{#pid}=###CURRENT_PID### AND {#tx_otirrebuttons_domain_model_button}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'text' => [
            'exclude' => true,
            'label' => $ll . 'tx_otirrebuttons_domain_model_button.text.label',
            'description' => $ll . 'tx_otirrebuttons_domain_model_button.text.description',
            'config' => [
                'type' => 'input',
                'size' => '30',
                'max' => '255',
                'eval' => 'trim'
            ]
        ],
        'link' => [
            'exclude' => true,
            'label' => $ll . 'tx_otirrebuttons_domain_model_button.link.label',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
                'size' => '50',
                'softref' => 'typolink',
                'max' => '2048',
                'eval' => 'trim',
                'fieldControl' => [
                    'linkPopup' => [
                        'options' => [
                            'title' => $ll . 'link_formlabel'
                        ]
                    ]
                ]
            ]
        ],
        'layout' => [
            'exclude' => true,
            'label' => $ll . 'tx_otirrebuttons_domain_model_button.layout.label',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', ''],
                    ['Link', 'btn btn-link'],
                    ['Bootstrap Solid', '--div--'],
                    ['Primary', 'btn btn-primary'],
                    ['Secondary', 'btn btn-secondary'],
                    ['Light', 'btn btn-light'],
                    ['Dark', 'btn btn-dark'],
                    ['Bootstrap Outline', '--div--'],
                    ['Primary Outline', 'btn btn-outline-primary'],
                    ['Secondary Outline', 'btn btn-outline-secondary'],
                    ['Light Outline', 'btn btn-outline-light'],
                    ['Dark Outline', 'btn btn-outline-dark'],
                ],
                'size' => 1,
                'maxitems' => 1,
            ]
        ],
        'position' => [
            'exclude' => true,
            'label' => $ll . 'tx_otirrebuttons_domain_model_button.position.label',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [$ll . 'tx_otirrebuttons_domain_model_button.left', 'left'],
                    [$ll . 'tx_otirrebuttons_domain_model_button.center', 'center'],
                    [$ll . 'tx_otirrebuttons_domain_model_button.right', 'right'],
                ],
                'size' => 1,
                'maxitems' => 1,
            ]
        ],
        'icon' => [
            'exclude' => true,
            'label' => $ll . 'tx_otirrebuttons_domain_model_button.icon.label',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'l10n_mode' => 'exclude',
                'items' => $icons,
                'size' => 1,
                'maxitems' => 1,
            ]
        ],
        'icon_position' => [
            'exclude' => true,
            'label' => $ll . 'tx_otirrebuttons_domain_model_button.icon_position.label',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', ''],
                    [$ll . 'tx_otirrebuttons_domain_model_button.left', 'left'],
                    [$ll . 'tx_otirrebuttons_domain_model_button.right', 'right'],
                ],
                'size' => 1,
                'maxitems' => 1,
            ]
        ],
    ],
];
