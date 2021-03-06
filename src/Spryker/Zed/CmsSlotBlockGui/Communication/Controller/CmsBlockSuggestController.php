<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsSlotBlockGui\Communication\Controller;

use Generated\Shared\Transfer\CmsBlockCriteriaTransfer;
use Generated\Shared\Transfer\CmsSlotBlockCriteriaTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Zed\CmsSlotBlockGui\Business\CmsSlotBlockGuiFacadeInterface getFacade()
 * @method \Spryker\Zed\CmsSlotBlockGui\Communication\CmsSlotBlockGuiCommunicationFactory getFactory()
 */
class CmsBlockSuggestController extends AbstractController
{
    protected const PARAM_SEARCH_TEXT = 'q';
    protected const PARAM_PAGE = 'page';
    protected const PARAM_ID_CMS_SLOT = 'id-cms-slot';
    protected const PARAM_ID_CMS_SLOT_TEMPLATE = 'id-cms-slot-template';
    protected const DEFAULT_MAX_PER_PAGE = 10;
    protected const DEFAULT_PAGE = 1;

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function indexAction(Request $request)
    {
        $searchTerm = (string)$request->query->get(static::PARAM_SEARCH_TEXT);
        $page = $request->query->getInt(static::PARAM_PAGE, static::DEFAULT_PAGE);
        $idCmsSlotTemplate = $request->query->getInt(static::PARAM_ID_CMS_SLOT_TEMPLATE);
        $idCmsSlot = $request->query->getInt(static::PARAM_ID_CMS_SLOT);

        $paginationTransfer = (new PaginationTransfer())
            ->setPage($page)
            ->setMaxPerPage(static::DEFAULT_MAX_PER_PAGE);

        $cmsBlockCriteriaTransfer = (new CmsBlockCriteriaTransfer())
            ->setNamePattern($searchTerm)
            ->setPagination($paginationTransfer);

        $cmsSlotBlockCriteriaTransfer = (new CmsSlotBlockCriteriaTransfer())
            ->setIdCmsSlotTemplate($idCmsSlotTemplate)
            ->setIdCmsSlot($idCmsSlot);

        return $this->jsonResponse(
            $this->getFactory()
                ->createCmsBlockSuggestionFinder()
                ->getCmsBlockSuggestions($cmsBlockCriteriaTransfer, $cmsSlotBlockCriteriaTransfer)
        );
    }
}
