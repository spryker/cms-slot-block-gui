<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsSlotBlockGui\Communication\Table;

use Orm\Zed\CmsBlock\Persistence\Map\SpyCmsBlockTableMap;
use Orm\Zed\CmsBlock\Persistence\SpyCmsBlockQuery;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\CmsSlotBlockGui\CmsSlotBlockGuiConfig;
use Spryker\Zed\CmsSlotBlockGui\Dependency\Facade\CmsSlotBlockGuiToCmsBlockFacadeInterface;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class CmsSlotBlockTable extends AbstractTable
{
    /**
     * @var string
     */
    public const TABLE_CLASS = 'js-cms-slot-block-table';

    protected const COL_ID_CMS_BLOCK = SpyCmsBlockTableMap::COL_ID_CMS_BLOCK;

    protected const COL_NAME = SpyCmsBlockTableMap::COL_NAME;

    protected const COL_VALID_FROM = SpyCmsBlockTableMap::COL_VALID_FROM;

    protected const COL_VALID_TO = SpyCmsBlockTableMap::COL_VALID_TO;

    protected const COL_IS_ACTIVE = SpyCmsBlockTableMap::COL_IS_ACTIVE;

    /**
     * @var string
     */
    protected const COL_STORE_RELATION = 'Store';

    /**
     * @var string
     */
    protected const COL_ACTIONS = 'Actions';

    /**
     * @var string
     */
    protected const BUTTON_MOVE_UP = 'Move Up';

    /**
     * @var string
     */
    protected const BUTTON_MOVE_DOWN = 'Move Down';

    /**
     * @var string
     */
    protected const BUTTON_VIEW_BLOCK = 'View Block';

    /**
     * @var string
     */
    protected const BUTTON_DELETE = 'Delete';

    /**
     * @var string
     */
    protected const URL_CMS_BLOCK_VIEW = '/cms-block-gui/view-block';

    /**
     * @var string
     */
    protected const REQUEST_ID_CMS_BLOCK = 'id-cms-block';

    /**
     * @var \Spryker\Zed\CmsSlotBlockGui\Dependency\Facade\CmsSlotBlockGuiToCmsBlockFacadeInterface
     */
    protected $cmsBlockFacade;

    /**
     * @var \Orm\Zed\CmsBlock\Persistence\SpyCmsBlockQuery
     */
    protected $cmsBlockQuery;

    /**
     * @var \Spryker\Zed\CmsSlotBlockGui\CmsSlotBlockGuiConfig
     */
    protected $cmsSlotBlockGuiConfig;

    /**
     * @var int
     */
    protected $idCmsSlotTemplate;

    /**
     * @var int
     */
    protected $idCmsSlot;

    /**
     * @param \Spryker\Zed\CmsSlotBlockGui\Dependency\Facade\CmsSlotBlockGuiToCmsBlockFacadeInterface $cmsBlockFacade
     * @param \Orm\Zed\CmsBlock\Persistence\SpyCmsBlockQuery $cmsBlockQuery
     * @param \Spryker\Zed\CmsSlotBlockGui\CmsSlotBlockGuiConfig $cmsSlotBlockGuiConfig
     * @param int $idCmsSlotTemplate
     * @param int $idCmsSlot
     */
    public function __construct(
        CmsSlotBlockGuiToCmsBlockFacadeInterface $cmsBlockFacade,
        SpyCmsBlockQuery $cmsBlockQuery,
        CmsSlotBlockGuiConfig $cmsSlotBlockGuiConfig,
        int $idCmsSlotTemplate,
        int $idCmsSlot
    ) {
        $this->cmsBlockFacade = $cmsBlockFacade;
        $this->cmsBlockQuery = $cmsBlockQuery;
        $this->cmsSlotBlockGuiConfig = $cmsSlotBlockGuiConfig;
        $this->idCmsSlotTemplate = $idCmsSlotTemplate;
        $this->idCmsSlot = $idCmsSlot;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function configure(TableConfiguration $config): TableConfiguration
    {
        $config = $this->setHeader($config);

        $config->addRawColumn(static::COL_ACTIONS);
        $config->addRawColumn(static::COL_IS_ACTIVE);
        $config->addRawColumn(static::COL_STORE_RELATION);

        $this->disableSearch();

        $config->setServerSide(false);
        $config->setPaging(false);
        $config->setOrdering(false);

        $this->setLimit($this->cmsSlotBlockGuiConfig->getMaxNumberBlocksAssignedToSlot());

        $this->tableClass = static::TABLE_CLASS;

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function setHeader(TableConfiguration $config): TableConfiguration
    {
        $header = [
            static::COL_ID_CMS_BLOCK => 'ID',
            static::COL_NAME => 'Name',
            static::COL_VALID_FROM => 'Valid From (Included)',
            static::COL_VALID_TO => 'Valid To (Excluded)',
            static::COL_IS_ACTIVE => 'Status',
            static::COL_STORE_RELATION => 'Stores',
            static::COL_ACTIONS => static::COL_ACTIONS,
        ];

        $config->setHeader($header);

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array
     */
    protected function prepareData(TableConfiguration $config): array
    {
        $this->filterCmsBlocks();
        $cmsBlockResults = $this->runQuery($this->cmsBlockQuery, $config);

        $results = [];
        foreach ($cmsBlockResults as $cmsBlock) {
            $results[] = [
                static::COL_ID_CMS_BLOCK => $this->formatInt($cmsBlock[SpyCmsBlockTableMap::COL_ID_CMS_BLOCK]),
                static::COL_NAME => $cmsBlock[SpyCmsBlockTableMap::COL_NAME],
                static::COL_VALID_FROM => $this->formatValidityDateTime($cmsBlock[SpyCmsBlockTableMap::COL_VALID_FROM]),
                static::COL_VALID_TO => $this->formatValidityDateTime($cmsBlock[SpyCmsBlockTableMap::COL_VALID_TO]),
                static::COL_IS_ACTIVE => $this->generateStatusLabels($cmsBlock),
                static::COL_STORE_RELATION => $this->getStoreNames($cmsBlock[SpyCmsBlockTableMap::COL_ID_CMS_BLOCK]),
                static::COL_ACTIONS => $this->getActionButtons($cmsBlock),
            ];
        }

        return $results;
    }

    /**
     * @return void
     */
    protected function filterCmsBlocks(): void
    {
        $this->cmsBlockQuery
            ->useSpyCmsSlotBlockQuery()
                ->filterByFkCmsSlot($this->idCmsSlot)
                ->filterByFkCmsSlotTemplate($this->idCmsSlotTemplate)
                ->orderByPosition()
            ->endUse();
    }

    /**
     * @param string|null $dateTime
     *
     * @return string
     */
    protected function formatValidityDateTime(?string $dateTime): string
    {
        if (!$dateTime) {
            return '-';
        }

        $timestamp = strtotime($dateTime);
        if ($timestamp === false) {
            return '-';
        }

        return (string)date('F d, Y H:i', $timestamp);
    }

    /**
     * @param array $cmsSlotBlock
     *
     * @return string
     */
    protected function generateStatusLabels(array $cmsSlotBlock): string
    {
        if ($cmsSlotBlock[SpyCmsBlockTableMap::COL_IS_ACTIVE]) {
            return $this->generateLabel('Active', 'label-info');
        }

        return $this->generateLabel('Inactive', 'label-danger');
    }

    /**
     * @param int $idCmsBlock
     *
     * @return string
     */
    protected function getStoreNames(int $idCmsBlock): string
    {
        $stores = $this->cmsBlockFacade->findCmsBlockById($idCmsBlock)->getStoreRelation()->getStores();

        $storeNames = [];
        foreach ($stores as $store) {
            $storeNames[] = sprintf(
                '<span class="label label-info">%s</span>',
                $store->getName(),
            );
        }

        return implode(' ', $storeNames);
    }

    /**
     * @param array $cmsBlock
     *
     * @return string
     */
    protected function getActionButtons(array $cmsBlock): string
    {
        $actionButtons = [];

        $actionButtons[] = $this->generateButton(
            '#',
            static::BUTTON_MOVE_UP,
            [
                'class' => 'btn-create',
                'data-direction' => 'up',
                'icon' => 'fa-arrow-up',
                'onclick' => 'return false;',
            ],
        );
        $actionButtons[] = $this->generateButton(
            '#',
            static::BUTTON_MOVE_DOWN,
            [
                'class' => 'btn-create',
                'data-direction' => 'down',
                'icon' => 'fa-arrow-down',
                'onclick' => 'return false;',
            ],
        );
        $actionButtons[] = $this->generateButton(
            Url::generate(static::URL_CMS_BLOCK_VIEW, [
                static::REQUEST_ID_CMS_BLOCK => $cmsBlock[SpyCmsBlockTableMap::COL_ID_CMS_BLOCK],
            ]),
            static::BUTTON_VIEW_BLOCK,
            [
                'class' => 'btn-view',
                'target' => '_blank',
            ],
        );
        $actionButtons[] = $this->generateButton(
            '#',
            static::BUTTON_DELETE,
            [
                'class' => 'btn-danger js-slot-block-remove-button',
                'icon' => 'fa-trash',
                'onclick' => 'return false;',
            ],
        );

        return implode(' ', $actionButtons);
    }
}
