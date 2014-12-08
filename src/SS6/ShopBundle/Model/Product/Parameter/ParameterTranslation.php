<?php

namespace SS6\ShopBundle\Model\Product\Parameter;

use Doctrine\ORM\Mapping as ORM;
use Prezent\Doctrine\Translatable\Annotation as Prezent;
use Prezent\Doctrine\Translatable\Entity\AbstractTranslation;

/**
 * @ORM\Table(name="parameter_titles_translations")
 * @ORM\Entity
 */
class ParameterTranslation extends AbstractTranslation {

	/**
	 * @Prezent\Translatable(targetEntity="SS6\ShopBundle\Model\Product\Parameter\Parameter")
	 */
	protected $translatable;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	private $name;

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

}