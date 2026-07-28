<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/** @var array<string, string> $extensionSettings */
$extensionSettings = (array)GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('ot_irrebuttons');

$availableLightboxTypes = array_intersect(
    ['lightbox', 'lightboxIframe'],
    GeneralUtility::trimExplode(',', (string)($extensionSettings['lightboxTypes'] ?? ''), true)
);

$linkTypeField = $availableLightboxTypes !== [] ? ', link_type' : '';

ExtensionManagementUtility::addFieldsToPalette(
    'tx_otirrebuttons_domain_model_button',
    'irreButtons',
    '--linebreak--, link' . $linkTypeField . ', text, --linebreak--, layout, icon, icon_position'
);
