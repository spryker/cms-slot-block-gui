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

interface CmsSlotBlockGuiToCmsSlotBlockFacadeInterface
{
    public function createCmsSlotBlockRelations(CmsSlotBlockCollectionTransfer $cmsSlotBlockCollectionTransfer): void;

    public function deleteCmsSlotBlockRelationsByCriteria(CmsSlotBlockCriteriaTransfer $cmsSlotBlockCriteriaTransfer): void;

    public function getCmsSlotBlockCollection(
        CmsSlotBlockCriteriaTransfer $cmsSlotBlockCriteriaTransfer
    ): CmsSlotBlockCollectionTransfer;

    /**
     * @param string $twigPath
     *
     * @return array<string>
     */
    public function getTemplateConditionsByPath(string $twigPath): array;

    public function getPaginatedCmsBlocksWithSlotRelations(CmsBlockCriteriaTransfer $cmsBlockCriteriaTransfer): CmsBlockCollectionTransfer;
}
