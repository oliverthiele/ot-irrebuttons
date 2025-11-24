<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use TYPO3\CMS\Core\Utility\GeneralUtility;

$extensionSettings = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('ot_irrebuttons');

$icons = [
    'icon-ot-irrebuttons' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:ot_irrebuttons/Resources/Public/Icons/Extension.svg',
    ],
];

$iconList = explode(',', $extensionSettings['icons']);

foreach ($iconList as $icon) {
    $iconIdentifier = trim($icon);

    $path = GeneralUtility::getFileAbsFileName($extensionSettings['pathIcons'] . $iconIdentifier . '.svg');

    if (file_exists($path)) {
        $icons['ot-irrebuttons-icon-' . $iconIdentifier] = [
            'provider' => SvgIconProvider::class,
            'source' => $extensionSettings['pathIcons'] . $iconIdentifier . '.svg',
        ];
    }
}
return $icons;
