<?php

declare(strict_types=1);

namespace OliverThiele\OtIrrebuttons\DataProcessing;

use Doctrine\DBAL\ParameterType;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

/**
 * Loads IRRE button records for a content element by its UID only,
 * without any page (pid) restriction — required for correct Slide behaviour.
 *
 * Usage in TypoScript:
 *   dataProcessing {
 *     1701706720 = OliverThiele\OtIrrebuttons\DataProcessing\IrreButtonsProcessor
 *     1701706720 {
 *       if.isTrue.field = tx_otirrebuttons_domain_model_buttons
 *       as = irreButtons
 *     }
 *   }
 */
final class IrreButtonsProcessor implements DataProcessorInterface
{
    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {
    }

    /**
     * @param array<string, mixed> $contentObjectConfiguration
     * @param array<string, mixed> $processorConfiguration
     * @param array<string, mixed> $processedData
     * @return array<string, mixed>
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData,
    ): array {
        if (isset($processorConfiguration['if.']) && is_array($processorConfiguration['if.']) && !$cObj->checkIf($processorConfiguration['if.'])) {
            return $processedData;
        }

        // Respect versioning overlay: _ORIG_uid holds the live UID when in workspace
        /** @var array<string, mixed> $contentElementData */
        $contentElementData = $processedData['data'];
        $origUid = is_int($contentElementData['_ORIG_uid']) ? $contentElementData['_ORIG_uid'] : 0;
        $uid = is_int($contentElementData['uid']) ? $contentElementData['uid'] : 0;
        $contentElementUid = $origUid !== 0 ? $origUid : $uid;

        if ($contentElementUid === 0) {
            return $processedData;
        }

        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tx_otirrebuttons_domain_model_button');

        $rows = $queryBuilder
            ->select('*')
            ->from('tx_otirrebuttons_domain_model_button')
            ->where(
                $queryBuilder->expr()->eq(
                    'parent_id',
                    $queryBuilder->createNamedParameter($contentElementUid, ParameterType::INTEGER),
                )
            )
            ->orderBy('sorting', 'ASC')
            ->executeQuery()
            ->fetchAllAssociative();

        // Wrap each row in ['data' => $row] to match the structure expected by the Fluid partial
        // (same convention as TYPO3's DatabaseQueryProcessor)
        $buttons = array_map(static fn(array $row): array => ['data' => $row], $rows);

        $targetVariableName = (string)$cObj->stdWrapValue('as', $processorConfiguration, 'irreButtons');
        $processedData[$targetVariableName] = $buttons;

        return $processedData;
    }
}
