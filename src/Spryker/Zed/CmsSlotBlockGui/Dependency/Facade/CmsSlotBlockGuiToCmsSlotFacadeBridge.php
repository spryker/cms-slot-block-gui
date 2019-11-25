<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsSlotBlockGui\Dependency\Facade;

use Generated\Shared\Transfer\CmsSlotTemplateTransfer;
use Generated\Shared\Transfer\CmsSlotTransfer;

class CmsSlotBlockGuiToCmsSlotFacadeBridge implements CmsSlotBlockGuiToCmsSlotFacadeInterface
{
    /**
     * @var \Spryker\Zed\CmsSlot\Business\CmsSlotFacadeInterface
     */
    protected $cmsSlotFacade;

    /**
     * @param \Spryker\Zed\CmsSlot\Business\CmsSlotFacadeInterface $cmsSlotFacade
     */
    public function __construct($cmsSlotFacade)
    {
        $this->cmsSlotFacade = $cmsSlotFacade;
    }

    /**
     * @param int $idCmsSlot
     *
     * @return \Generated\Shared\Transfer\CmsSlotTransfer
     */
    public function getCmsSlotById(int $idCmsSlot): CmsSlotTransfer
    {
        return $this->cmsSlotFacade->getCmsSlotById($idCmsSlot);
    }

    /**
     * @param int $idCmsSlotTemplate
     *
     * @return \Generated\Shared\Transfer\CmsSlotTemplateTransfer
     */
    public function getCmsSlotTemplateById(int $idCmsSlotTemplate): CmsSlotTemplateTransfer
    {
        return $this->cmsSlotFacade->getCmsSlotTemplateById($idCmsSlotTemplate);
    }
}
