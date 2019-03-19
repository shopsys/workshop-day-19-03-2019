<?php

namespace Shopsys\ShopBundle\Model\Pricing\Vat;

use Shopsys\FrameworkBundle\Model\Pricing\Vat\VatRepository as BaseVatRepository;

class VatRepository extends BaseVatRepository
{
    /**
     * @param $vatPercent
     * @return \Shopsys\FrameworkBundle\Model\Pricing\Vat\Vat|null
     */
    public function findByVatPercent($vatPercent)
    {
        return $this->getVatRepository()->findOneBy(['percent' => $vatPercent]);
    }
}
