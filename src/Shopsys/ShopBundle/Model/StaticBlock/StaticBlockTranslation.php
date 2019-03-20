<?php

namespace Shopsys\ShopBundle\Model\StaticBlock;

use Doctrine\ORM\Mapping as ORM;
use Prezent\Doctrine\Translatable\Entity\AbstractTranslation;
use Prezent\Doctrine\Translatable\Annotation as Prezent;

/**
 * @ORM\Table(name="static_blocks_translations")
 * @ORM\Entity
 */
class StaticBlockTranslation extends AbstractTranslation
{
    /**
     * @Prezent\Translatable(targetEntity="\Shopsys\ShopBundle\Model\StaticBlock\StaticBlock")
     */
    protected $translatable;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $text;

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }
}
