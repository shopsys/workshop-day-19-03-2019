<?php

namespace SS6\ShopBundle\Controller\Front;

use SS6\ShopBundle\Model\Seo\SeoSettingFacade;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

	public function indexAction() {
		$sliderItemFacade = $this->get('ss6.shop.slider.slider_item_facade');
		/* @var $sliderItemFacade \SS6\ShopBundle\Model\Slider\SliderItemFacade */
		$domain = $this->get('ss6.shop.domain');
		/* @var $domain \SS6\ShopBundle\Model\Domain\Domain */
		$topProductsFacade = $this->get('ss6.shop.product.top_product.top_product_facade');
		/* @var $topProductsFacade \SS6\ShopBundle\Model\Product\TopProduct\TopProductFacade */
		$seoSettingFacade = $this->get(SeoSettingFacade::class);
		/* @var $seoSettingFacade \SS6\ShopBundle\Model\Seo\SeoSettingFacade */

		$sliderItems = $sliderItemFacade->getAllOnCurrentDomain();
		$topProductsDetails = $topProductsFacade->getAllProductDetailsByDomainId($domain->getId());

		return $this->render('@SS6Shop/Front/Content/Default/index.html.twig', [
			'sliderItems' => $sliderItems,
			'topProductsDetails' => $topProductsDetails,
			'title' => $seoSettingFacade->getTitleMainPage($domain->getId()),
			'metaDescription' => $seoSettingFacade->getDescriptionMainPage($domain->getId()),
		]);
	}

}
