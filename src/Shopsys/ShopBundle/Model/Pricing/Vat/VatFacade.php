<?php

namespace Shopsys\ShopBundle\Model\Pricing\Vat;

use Shopsys\FrameworkBundle\Model\Pricing\Vat\VatFacade as BaseVatFacade;

class VatFacade extends BaseVatFacade
{
    /**
     * @param $vatPercent
     * @return \Shopsys\FrameworkBundle\Model\Pricing\Vat\Vat|null
     */
    public function findByVatPercent($vatPercent)
    {
        return $this->vatRepository->findByVatPercent($vatPercent);
    }
}
