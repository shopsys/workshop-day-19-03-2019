<?php

namespace SS6\ShopBundle\Twig;

use SS6\ShopBundle\Model\Seo\SeoSettingFacade;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig_SimpleFunction;

class SeoExtension extends \Twig_Extension {

	/**
	 * @var \Symfony\Component\DependencyInjection\ContainerInterface
	 */
	private $container;

	/**
	 * @var \SS6\ShopBundle\Model\Seo\SeoSettingFacade
	 */
	private $seoSettingFacade;

	/**
	 * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
	 * @param \SS6\ShopBundle\Model\Seo\SeoSettingFacade $seoSettingFacade
	 */
	public function __construct(
		ContainerInterface $container,
		SeoSettingFacade $seoSettingFacade
	) {
		$this->container = $container;
		$this->seoSettingFacade = $seoSettingFacade;
	}

	/**
	 * @return array
	 */
	public function getFunctions() {
		return [
			new Twig_SimpleFunction('getSeoTitleAddOn', [$this, 'getSeoTitleAddOn']),
			new Twig_SimpleFunction('getSeoMetaDescription', [$this, 'getSeoMetaDescription']),
		];
	}

	/**
	 * @return \SS6\ShopBundle\Model\Domain\Domain
	 */
	private function getDomain() {
		// Twig extensions are loaded during assetic:dump command,
		// so they cannot be dependent on Domain service
		return $this->container->get('ss6.shop.domain');
	}

	/**
	 * @return string
	 */
	public function getName() {
		return 'seo';
	}

	/**
	 * @return string
	 */
	public function getSeoTitleAddOn() {
		$currentDomainId = $this->getDomain()->getId();
		return $this->seoSettingFacade->getTitleAddOn($currentDomainId);
	}

	/**
	 * @return string
	 */
	public function getSeoMetaDescription() {
		$currentDomainId = $this->getDomain()->getId();
		return $this->seoSettingFacade->getDescriptionMainPage($currentDomainId);
	}

}