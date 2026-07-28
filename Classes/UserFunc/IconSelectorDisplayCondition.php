<?php

declare(strict_types=1);

namespace OliverThiele\OtIrrebuttons\UserFunc;

use TYPO3\CMS\Core\Exception\SiteNotFoundException;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Display condition for the button icon field while ot_iconselector renders it.
 *
 * The selector resolves its icons from the site setting otIcons.iconDirectory.
 * Without a readable directory it would render an empty widget that never
 * returns a search result, so the field is hidden instead.
 */
final class IconSelectorDisplayCondition
{
    /**
     * @param array<string, mixed> $parameters
     */
    public function hasIconDirectory(array $parameters): bool
    {
        $record = $parameters['record'] ?? [];
        // A new record carries a "NEW..." placeholder instead of a numeric pid
        $pid = is_array($record) ? ($record['pid'] ?? 0) : 0;
        $pageId = is_numeric($pid) ? (int)$pid : 0;

        if ($pageId <= 0) {
            // No site to inspect, e.g. for a record that has not been saved yet.
            // Stay permissive here — hiding the field would be the worse guess.
            return true;
        }

        try {
            $site = GeneralUtility::makeInstance(SiteFinder::class)->getSiteByPageId($pageId);
        } catch (SiteNotFoundException) {
            return true;
        }

        $setting = $site->getSettings()->get('otIcons.iconDirectory', '');
        $iconDirectory = is_string($setting) ? trim($setting) : '';

        if ($iconDirectory === '') {
            return false;
        }

        $absolutePath = GeneralUtility::getFileAbsFileName($iconDirectory);

        return $absolutePath !== '' && is_dir($absolutePath);
    }
}
