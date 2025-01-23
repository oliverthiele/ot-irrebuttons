<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addFieldsToPalette(
    'tx_otirrebuttons_domain_model_button',
    'irreButtons',
    '--linebreak--, link, link_type, text, --linebreak--, layout, icon, icon_position'
);
