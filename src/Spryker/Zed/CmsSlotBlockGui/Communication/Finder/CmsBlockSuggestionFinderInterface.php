<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsSlotBlockGui\Communication\Finder;

use Generated\Shared\Transfer\CmsBlockCriteriaTransfer;
use Generated\Shared\Transfer\CmsSlotBlockCriteriaTransfer;

interface CmsBlockSuggestionFinderInterface
{
    public function getCmsBlockSuggestions(
        CmsBlockCriteriaTransfer $cmsBlockCriteriaTransfer,
        CmsSlotBlockCriteriaTransfer $cmsSlotBlockCriteriaTransfer
    ): array;
}
