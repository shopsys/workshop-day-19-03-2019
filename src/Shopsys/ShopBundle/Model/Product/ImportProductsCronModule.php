<?php

namespace Shopsys\ShopBundle\Model\Product;

use Shopsys\FrameworkBundle\Component\Money\Money;
use Shopsys\FrameworkBundle\Model\Pricing\Group\PricingGroupSettingFacade;
use Shopsys\FrameworkBundle\Model\Product\Brand\BrandFacade;
use Shopsys\Plugin\Cron\SimpleCronModuleInterface;
use Shopsys\ShopBundle\Model\Pricing\Vat\VatFacade;
use Symfony\Bridge\Monolog\Logger;

class ImportProductsCronModule implements SimpleCronModuleInterface
{
    const API_URL = 'http://private-53864-ssfwbasicdataimportdemo.apiary-mock.com/products';

    /**
     * @var \Shopsys\ShopBundle\Model\Product\ProductFacade
     */
    protected $productFacade;

    /**
     * @var \Shopsys\ShopBundle\Model\Product\ProductDataFactory
     */
    protected $productDataFactory;

    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    protected $logger;

    /**
     * @var \Shopsys\ShopBundle\Model\Pricing\Vat\VatFacade
     */
    protected $vatFacade;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Pricing\Group\PricingGroupSettingFacade
     */
    protected $pricingGroupSettingFacade;

    /**
     * @var \Shopsys\FrameworkBundle\Model\Product\Brand\BrandFacade
     */
    protected $brandFacade;

    /**
     * @param \Shopsys\ShopBundle\Model\Product\ProductFacade $productFacade
     */
    public function __construct(
        ProductFacade $productFacade,
        ProductDataFactory $productDataFactory,
        VatFacade $vatFacade,
        PricingGroupSettingFacade $pricingGroupSettingFacade,
        BrandFacade $brandFacade
    ) {
        $this->productFacade = $productFacade;
        $this->productDataFactory = $productDataFactory;
        $this->vatFacade = $vatFacade;
        $this->pricingGroupSettingFacade = $pricingGroupSettingFacade;
        $this->brandFacade = $brandFacade;
    }

    /**
     * @param \Symfony\Bridge\Monolog\Logger $logger
     */
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * This method is called to run the CRON module.
     */
    public function run()
    {
        $this->logger->info('Downloading data...');
        $externalDataJson = file_get_contents(self::API_URL);
        $this->logger->info('Decoding data...');
        $externalData = json_decode($externalDataJson, true);
        foreach ($externalData as $externalProductData) {
            $extId = $externalProductData['id'];
            $product = $this->productFacade->findByExternalId($extId);
            if ($product === null) {
                $productData = $this->productDataFactory->create();
                $this->mapExternalDataToProductData($externalProductData, $productData);
                $this->productFacade->create($productData);
                $this->logger->info(sprintf('Product with ext ID %s created', $extId));
            } else {
                $productData = $this->productDataFactory->createFromProduct($product);
                $this->mapExternalDataToProductData($externalProductData, $productData);
                $this->productFacade->edit($product->getId(), $productData);
                $this->logger->info(sprintf('Product with ext ID %s edited', $extId));
            }
        }
    }

    private function mapExternalDataToProductData($externalData, ProductData $productData)
    {
        $productData->extId = $externalData['id'];
        $productData->name['en'] = $externalData['name'];
        $productData->vat = $this->vatFacade->findByVatPercent($externalData['vat_percent']);
        $firstDomainDefaultPricingGroupId = $this->pricingGroupSettingFacade->getDefaultPricingGroupByDomainId(1)->getId();
        $productData->manualInputPricesByPricingGroupId[$firstDomainDefaultPricingGroupId] = Money::create($externalData['price_without_vat']);
        $productData->ean = $externalData['ean'];
        $productData->descriptions[1] = $externalData['description'];
        $productData->stockQuantity = $externalData['stock_quantity'];
        $productData->usingStock = true;
        $productData->brand = $this->brandFacade->getById($externalData['brand_id']);
    }
}
