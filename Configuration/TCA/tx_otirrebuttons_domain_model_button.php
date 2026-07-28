<?php

declare(strict_types=1);

use OliverThiele\OtIrrebuttons\UserFunc\IconSelectorDisplayCondition;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3') or die();

$ll = 'LLL:EXT:ot_irrebuttons/Resources/Private/Language/locallang_be.xlf:';

/** @var array<string, string> $extensionSettings */
$extensionSettings = (array)GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('ot_irrebuttons');

$icons = [];

$linkTypeItems = [
    [
        'label' => $ll . 'tx_otirrebuttons_domain_model_button.link_type.default',
        'value' => '',
    ],
];

$availableLightboxTypes = array_intersect(
    ['lightbox', 'lightboxIframe'],
    GeneralUtility::trimExplode(',', (string)($extensionSettings['lightboxTypes'] ?? ''), true)
);

foreach ($availableLightboxTypes as $lightboxType) {
    $linkTypeItems[] = [
        'label' => $ll . 'tx_otirrebuttons_domain_model_button.link_type.' . $lightboxType,
        'value' => $lightboxType,
    ];
}

$configuredIcons = GeneralUtility::trimExplode(',', (string)($extensionSettings['icons'] ?? ''), true);

if ($configuredIcons !== []) {
    $icons[] = [
        'label' => '',
        'value' => '',
    ];
    foreach ($configuredIcons as $icon) {
        $icons[$icon] = [
            'label' => $icon,
            'value' => $icon,
            'icon' => 'ot-irrebuttons-icon-' . $icon,
        ];
    }
}

// With ot_iconselector the icon is picked from the whole icon directory instead
// of the curated list in the extension configuration. This needs a free text
// value, a select would drop identifiers that are not part of its items.
$iconSelectorLoaded = ExtensionManagementUtility::isLoaded('ot_iconselector');

$iconField = [
    'exclude' => true,
    'label' => $ll . 'tx_otirrebuttons_domain_model_button.icon.label',
    'l10n_mode' => 'exclude',
    'config' => $iconSelectorLoaded
        ? [
            'type' => 'input',
            'renderType' => 'otIconSelector',
            // Matches the SiteSet setting otIconselector.favorites.buttons
            'favoriteGroup' => 'buttons',
            'size' => 30,
            'max' => 50,
            'eval' => 'trim',
        ]
        : [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => $icons,
            'size' => 1,
            'maxitems' => 1,
        ],
];

$iconPositionField = [
    'exclude' => true,
    'label' => $ll . 'tx_otirrebuttons_domain_model_button.icon_position.label',
    'l10n_mode' => 'exclude',
    'config' => [
        'type' => 'select',
        'renderType' => 'selectSingle',
        'items' => [
            [
                'label' => '',
                'value' => '',
            ],
            [
                'label' => $ll . 'tx_otirrebuttons_domain_model_button.icon_position.left',
                'value' => 'left',
            ],
            [
                'label' => $ll . 'tx_otirrebuttons_domain_model_button.icon_position.right',
                'value' => 'right',
            ],
        ],
        'size' => 1,
        'maxitems' => 1,
    ],
];

if ($iconSelectorLoaded) {
    // The selector needs a readable icon directory from the site settings,
    // otherwise it renders a widget that can never return a result. Without an
    // icon field, the icon position has nothing to position either.
    $iconDisplayCond = 'USER:' . IconSelectorDisplayCondition::class . '->hasIconDirectory';

    $iconField['displayCond'] = $iconDisplayCond;
    $iconField['description'] = $ll . 'tx_otirrebuttons_domain_model_button.icon.description';
    $iconPositionField['displayCond'] = $iconDisplayCond;
}

return [
    'ctrl' => [
        'title' => $ll . 'tx_otirrebuttons_domain_model_button',
        'label' => 'text',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
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
        'iconfile' => 'EXT:ot_irrebuttons/Resources/Public/Icons/Extension.svg',
    ],
    'types' => [
        '1' => [
            'showitem' => '
            --div--;Link,
                --palette--;LLL:EXT:tx_otirrebuttons/Resources/Private/Language/locallang_be.xlf:palette.irreButtons;irreButtons,
            --div--;Sprache, sys_language_uid,l10n_parent,l10n_diffsource,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,hidden,starttime,endtime',
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
                    [
                        'label' => '',
                        'value' => 0,
                    ],
                ],
                'foreign_table' => 'tx_otirrebuttons_domain_model_button',
                'foreign_table_where' => 'AND {#tx_otirrebuttons_domain_model_button}.{#pid}=###CURRENT_PID### AND {#tx_otirrebuttons_domain_model_button}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
                'default' => '',
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
                        'label' => '',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'l10n_display' => 'defaultAsReadonly',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'searchable' => false,
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => 2145913200,
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
                'searchable' => false,
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
                'eval' => 'trim',
            ],
        ],
        'link' => [
            'exclude' => true,
            'label' => $ll . 'tx_otirrebuttons_domain_model_button.link.label',
            'config' => [
                'type' => 'link',
                'required' => true,
                'size' => '50',
                'softref' => 'typolink',
                'searchable' => false,
                'appearance' => [
                    'enableBrowser' => true,
                    'browserTitle' => $ll . 'link_formlabel',
                    // 'allowedFileExtensions' => ['jpg', 'png', 'pdf'],
                    // 'allowedOptions' => ['params', 'rel'],
                ],
            ],
        ],
        'layout' => [
            'exclude' => true,
            'label' => $ll . 'tx_otirrebuttons_domain_model_button.layout.label',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => '',
                        'value' => '',
                    ],
                    [
                        'label' => $ll . 'tx_otirrebuttons_domain_model_button.layout.link',
                        'value' => 'btn btn-link',
                    ],
                    [
                        'label' => $ll . 'tx_otirrebuttons_domain_model_button.layout.group.solid',
                        'value' => '--div--',
                    ],
                    [
                        'label' => $ll . 'tx_otirrebuttons_domain_model_button.layout.primary',
                        'value' => 'btn btn-primary',
                    ],
                    [
                        'label' => $ll . 'tx_otirrebuttons_domain_model_button.layout.secondary',
                        'value' => 'btn btn-secondary',
                    ],
                    [
                        'label' => $ll . 'tx_otirrebuttons_domain_model_button.layout.light',
                        'value' => 'btn btn-light',
                    ],
                    [
                        'label' => $ll . 'tx_otirrebuttons_domain_model_button.layout.dark',
                        'value' => 'btn btn-dark',
                    ],
                    [
                        'label' => $ll . 'tx_otirrebuttons_domain_model_button.layout.group.outline',
                        'value' => '--div--',
                    ],
                    [
                        'label' => $ll . 'tx_otirrebuttons_domain_model_button.layout.primary',
                        'value' => 'btn btn-outline-primary',
                    ],
                    [
                        'label' => $ll . 'tx_otirrebuttons_domain_model_button.layout.secondary',
                        'value' => 'btn btn-outline-secondary',
                    ],
                    [
                        'label' => $ll . 'tx_otirrebuttons_domain_model_button.layout.light',
                        'value' => 'btn btn-outline-light',
                    ],
                    [
                        'label' => $ll . 'tx_otirrebuttons_domain_model_button.layout.dark',
                        'value' => 'btn btn-outline-dark',
                    ],
                ],
                'size' => 1,
                'maxitems' => 1,
            ],
        ],
        'icon' => $iconField,
        'icon_position' => $iconPositionField,
        'link_type' => [
            'exclude' => true,
            'label' => $ll . 'tx_otirrebuttons_domain_model_button.link_type.label',
            'description' => $ll . 'tx_otirrebuttons_domain_model_button.link_type.description',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => $linkTypeItems,
                'size' => 1,
                'maxitems' => 1,
            ],
        ],
    ],
];
