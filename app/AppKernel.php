<?php

use SS6\Environment;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel {

	public function registerBundles() {
		$bundles = array(
			new Bmatzner\JQueryBundle\BmatznerJQueryBundle(),
			new Bmatzner\JQueryUIBundle\BmatznerJQueryUIBundle(),
			new Craue\FormFlowBundle\CraueFormFlowBundle(),
			new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
			new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
			new FM\ElfinderBundle\FMElfinderBundle(),
			new Fp\JsFormValidatorBundle\FpJsFormValidatorBundle(),
			new JMS\TranslationBundle\JMSTranslationBundle(),
			new Prezent\Doctrine\TranslatableBundle\PrezentDoctrineTranslatableBundle(),
			new RaulFraile\Bundle\LadybugBundle\RaulFraileLadybugBundle(),
			new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
			new SS6\AutoServicesBundle\SS6AutoServicesBundle(),
			new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
			new Symfony\Bundle\AsseticBundle\AsseticBundle(),
			new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
			new Symfony\Bundle\MonologBundle\MonologBundle(),
			new Symfony\Bundle\SecurityBundle\SecurityBundle(),
			new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
			new Symfony\Bundle\TwigBundle\TwigBundle(),
			new Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle(),
			new Ivory\CKEditorBundle\IvoryCKEditorBundle(), // has to be loaded after FrameworkBundle and TwigBundle
			new SS6\ShopBundle\SS6ShopBundle(), // must be loaded as last, because translations must overwrite other bundles
		);

		if (in_array($this->getEnvironment(), array('dev', 'test'))) {
			$bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
			$bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
			$bundles[] = new SS6\GeneratorBundle\SS6GeneratorBundle();
			$bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
		}

		return $bundles;
	}

	public function registerContainerConfiguration(LoaderInterface $loader) {
		foreach ($this->getConfigs() as $filename) {
			if (file_exists($filename) && is_readable($filename)) {
				$loader->load($filename);
			}
		}
	}

	/**
	 * @return string[]
	 */
	private function getConfigs() {
		$configs = [
			__DIR__ . '/config/parameters_common.yml',
			__DIR__ . '/config/parameters.yml',
			__DIR__ . '/config/config.yml',
			__DIR__ . '/config/security.yml',
		];
		switch ($this->environment) {
			case Environment::ENVIRONMENT_DEVELOPMENT:
				$configs[] = __DIR__ . '/config/config_dev.yml';
				break;
			case Environment::ENVIRONMENT_PRODUCTION:
				$configs[] = __DIR__ . '/config/config_prod.yml';
				break;
			case Environment::ENVIRONMENT_TEST:
				$configs[] = __DIR__ . '/config/parameters_test.yml';
				$configs[] = __DIR__ . '/config/config_test.yml';
				break;
		}

		return $configs;
	}
}
