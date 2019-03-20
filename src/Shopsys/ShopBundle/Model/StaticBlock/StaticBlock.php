<?php

namespace Shopsys\ShopBundle\Model\StaticBlock;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Prezent\Doctrine\Translatable\Annotation as Prezent;
use Shopsys\FrameworkBundle\Model\Localization\AbstractTranslatableEntity;

/**
 * @ORM\Table(name="static_blocks")
 * @ORM\Entity
 */
class StaticBlock extends AbstractTranslatableEntity
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    protected $code;

    /**
     * @var \Shopsys\ShopBundle\Model\StaticBlock\StaticBlockTranslation[]
     *
     * @Prezent\Translations(targetEntity="Shopsys\ShopBundle\Model\StaticBlock\StaticBlockTranslation")
     */
    protected $translations;

    /**
     * @param \Shopsys\ShopBundle\Model\StaticBlock\StaticBlockData $staticBlockData
     */
    public function __construct(StaticBlockData $staticBlockData)
    {
        $this->translations = new ArrayCollection();
        $this->edit($staticBlockData);
    }

    public function edit(StaticBlockData $staticBlockData)
    {
        $this->code = $staticBlockData->code;
        $this->setTranslations($staticBlockData);
    }

    /**
     * return \Prezent\Doctrine\Translatable\TranslationInterface
     */
    protected function createTranslation()
    {
        return new StaticBlockTranslation();
    }

    /**
     * @param \Shopsys\FrameworkBundle\Model\Transport\TransportData $transportData
     */
    protected function setTranslations(StaticBlockData $staticBlockData)
    {
        foreach ($staticBlockData->texts as $locale => $text) {
            $this->translation($locale)->setText($text);
        }
    }

    /**
     * @param string|null $locale
     * @return string|null
     */
    public function getText($locale = null)
    {
        return $this->translation($locale)->getText();
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return \Shopsys\ShopBundle\Model\StaticBlock\StaticBlockTranslation[]
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

}
