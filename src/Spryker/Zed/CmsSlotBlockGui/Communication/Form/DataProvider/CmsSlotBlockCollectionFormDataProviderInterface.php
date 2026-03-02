<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsSlotBlockGui\Communication\Form\DataProvider;

use Generated\Shared\Transfer\CmsSlotBlockCollectionTransfer;

interface CmsSlotBlockCollectionFormDataProviderInterface
{
    public function getData(int $idCmsSlotTemplate, int $idCmsSlot): CmsSlotBlockCollectionTransfer;

    /**
     * @param int $idCmsSlotTemplate
     *
     * @return array<string, mixed>
     */
    public function getOptions(int $idCmsSlotTemplate): array;
}
