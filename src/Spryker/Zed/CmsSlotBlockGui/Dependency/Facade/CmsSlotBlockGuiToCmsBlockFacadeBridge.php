<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsSlotBlockGui\Dependency\Facade;

use Generated\Shared\Transfer\CmsBlockTransfer;

class CmsSlotBlockGuiToCmsBlockFacadeBridge implements CmsSlotBlockGuiToCmsBlockFacadeInterface
{
    /**
     * @var \Spryker\Zed\CmsBlock\Business\CmsBlockFacadeInterface
     */
    protected $cmsBlockFacade;

    /**
     * @param \Spryker\Zed\CmsBlock\Business\CmsBlockFacadeInterface $cmsBlockFacade
     */
    public function __construct($cmsBlockFacade)
    {
        $this->cmsBlockFacade = $cmsBlockFacade;
    }

    /**
     * @param int $idCmsBlock
     *
     * @return \Generated\Shared\Transfer\CmsBlockTransfer|null
     */
    public function findCmsBlockById(int $idCmsBlock): ?CmsBlockTransfer
    {
        return $this->cmsBlockFacade->findCmsBlockById($idCmsBlock);
    }
}
