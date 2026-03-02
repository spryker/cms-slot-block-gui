<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsSlotBlockGui\Dependency\Facade;

use Generated\Shared\Transfer\CmsSlotTemplateTransfer;
use Generated\Shared\Transfer\CmsSlotTransfer;

interface CmsSlotBlockGuiToCmsSlotFacadeInterface
{
    public function getCmsSlotById(int $idCmsSlot): CmsSlotTransfer;

    public function getCmsSlotTemplateById(int $idCmsSlotTemplate): CmsSlotTemplateTransfer;
}
