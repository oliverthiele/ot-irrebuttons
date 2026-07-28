<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use TYPO3\CMS\Core\Utility\GeneralUtility;

$icons = [
    'icon-ot-irrebuttons' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:ot_irrebuttons/Resources/Public/Icons/Extension.svg',
    ],
];

try {
    /** @var array<string, string> $extensionSettings */
    $extensionSettings = (array)GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('ot_irrebuttons');
} catch (ExtensionConfigurationExtensionNotConfiguredException) {
    // No extension configuration written yet, e.g. during the first install request
    return $icons;
}

$iconDirectory = trim((string)($extensionSettings['pathIcons'] ?? ''));
$iconIdentifiers = GeneralUtility::trimExplode(',', (string)($extensionSettings['icons'] ?? ''), true);

foreach ($iconIdentifiers as $iconIdentifier) {
    $source = $iconDirectory . $iconIdentifier . '.svg';

    if (file_exists(GeneralUtility::getFileAbsFileName($source))) {
        $icons['ot-irrebuttons-icon-' . $iconIdentifier] = [
            'provider' => SvgIconProvider::class,
            'source' => $source,
        ];
    }
}

return $icons;
