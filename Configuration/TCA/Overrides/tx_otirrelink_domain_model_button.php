<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addFieldsToPalette(
    'tx_otirrebuttons_domain_model_button',
    'irreButtons',
    '--linebreak--, link, text, --linebreak--, layout, position, icon, icon_position'
);
