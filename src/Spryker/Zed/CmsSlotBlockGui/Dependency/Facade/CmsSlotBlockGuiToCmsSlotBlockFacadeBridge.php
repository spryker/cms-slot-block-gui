<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsSlotBlockGui\Dependency\Facade;

use Generated\Shared\Transfer\CmsBlockCollectionTransfer;
use Generated\Shared\Transfer\CmsBlockCriteriaTransfer;
use Generated\Shared\Transfer\CmsSlotBlockCollectionTransfer;
use Generated\Shared\Transfer\CmsSlotBlockCriteriaTransfer;

class CmsSlotBlockGuiToCmsSlotBlockFacadeBridge implements CmsSlotBlockGuiToCmsSlotBlockFacadeInterface
{
    /**
     * @var \Spryker\Zed\CmsSlotBlock\Business\CmsSlotBlockFacadeInterface
     */
    protected $cmsSlotBlockFacade;

    /**
     * @param \Spryker\Zed\CmsSlotBlock\Business\CmsSlotBlockFacadeInterface $cmsSlotBlockFacade
     */
    public function __construct($cmsSlotBlockFacade)
    {
        $this->cmsSlotBlockFacade = $cmsSlotBlockFacade;
    }

    public function createCmsSlotBlockRelations(CmsSlotBlockCollectionTransfer $cmsSlotBlockCollectionTransfer): void
    {
        $this->cmsSlotBlockFacade->createCmsSlotBlockRelations($cmsSlotBlockCollectionTransfer);
    }

    public function deleteCmsSlotBlockRelationsByCriteria(CmsSlotBlockCriteriaTransfer $cmsSlotBlockCriteriaTransfer): void
    {
        $this->cmsSlotBlockFacade->deleteCmsSlotBlockRelationsByCriteria($cmsSlotBlockCriteriaTransfer);
    }

    public function getCmsSlotBlockCollection(
        CmsSlotBlockCriteriaTransfer $cmsSlotBlockCriteriaTransfer
    ): CmsSlotBlockCollectionTransfer {
        return $this->cmsSlotBlockFacade->getCmsSlotBlockCollection($cmsSlotBlockCriteriaTransfer);
    }

    /**
     * @param string $twigPath
     *
     * @return array<string>
     */
    public function getTemplateConditionsByPath(string $twigPath): array
    {
        return $this->cmsSlotBlockFacade->getTemplateConditionsByPath($twigPath);
    }

    public function getPaginatedCmsBlocksWithSlotRelations(CmsBlockCriteriaTransfer $cmsBlockCriteriaTransfer): CmsBlockCollectionTransfer
    {
        return $this->cmsSlotBlockFacade->getPaginatedCmsBlocksWithSlotRelations($cmsBlockCriteriaTransfer);
    }
}
