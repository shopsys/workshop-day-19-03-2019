<?php

namespace Shopsys\ShopBundle\Model\Product\LastVisitedProduct;

use Shopsys\ShopBundle\Model\Product\ProductOnCurrentDomainFacade;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class LastVisitedProductFacade
{
    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    private $requestStack;

    /**
     * @var \Shopsys\ShopBundle\Model\Product\ProductOnCurrentDomainFacade
     */
    private $productOnCurrentDomainFacade;

    /**
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param \Shopsys\ShopBundle\Model\Product\ProductOnCurrentDomainFacade $productOnCurrentDomainFacade
     */
    public function __construct(
        RequestStack $requestStack,
        ProductOnCurrentDomainFacade $productOnCurrentDomainFacade
    ) {
        $this->requestStack = $requestStack;
        $this->productOnCurrentDomainFacade = $productOnCurrentDomainFacade;
    }

    /**
     * @param $productId
     * @param \Symfony\Component\HttpFoundation\Response $response
     */
    public function updateLastVisitedProductsIds($productId, Response $response)
    {
        $lastVisitedProductsIds = $this->getLastVisitedProductsIdsFromCookie();

        $keyOfLastVisitedProductIfAlreadyVisited = array_search($productId, $lastVisitedProductsIds, true);
        if ($keyOfLastVisitedProductIfAlreadyVisited !== false) {
            unset($lastVisitedProductsIds[$keyOfLastVisitedProductIfAlreadyVisited]);
        }

        array_unshift($lastVisitedProductsIds, $productId);

        $cookie = new Cookie(
            'lastVisitedProductsIds',
            implode(',', $lastVisitedProductsIds)
        );

        $response->headers->setCookie($cookie);
    }

    /**
     * @return array
     */
    private function getLastVisitedProductsIdsFromCookie()
    {
        $lastVisitedProductsIdsString = $this->requestStack->getMasterRequest()->cookies->get(
            'lastVisitedProductsIds',
            ''
        );

        if ($lastVisitedProductsIdsString !== '') {
            $lastVisitedProductsIds = explode(',', $lastVisitedProductsIdsString);
            $lastVisitedProductsIds = array_map('intval', $lastVisitedProductsIds);
        } else {
            $lastVisitedProductsIds = [];
        }

        return $lastVisitedProductsIds;
    }

    public function getLastVisitedProducts()
    {
        $lastVisitedProductsIds = $this->getLastVisitedProductsIdsFromCookie();
        return $this->productOnCurrentDomainFacade->getVisibleProductsByIds($lastVisitedProductsIds);
    }
}
