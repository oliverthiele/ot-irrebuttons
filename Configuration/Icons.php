<?php
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

$extensionSettings = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('ot_irrebuttons');

$icons = [
    'icon-ot-irrebuttons' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:ot_irrebuttons/Resources/Public/Icons/Extension.svg',
    ],
];

$iconList = explode(',' , $extensionSettings['icons']);

foreach ($iconList as $icon) {
    $iconIdentifier = trim($icon);

    $icons['ot-irrebuttons-icon-' . $iconIdentifier] = [
        'provider' => SvgIconProvider::class,
        'source' => $extensionSettings['pathIcons'] . $iconIdentifier . '.svg',
    ];
}

return $icons;
