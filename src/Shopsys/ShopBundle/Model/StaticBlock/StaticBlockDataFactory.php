<?php

namespace Shopsys\ShopBundle\Model\StaticBlock;

class StaticBlockDataFactory
{
    /**
     * @param \Shopsys\ShopBundle\Model\StaticBlock\StaticBlock $staticBlock
     * @return \Shopsys\ShopBundle\Model\StaticBlock\StaticBlockData
     */
    public function createFromStaticBlock(StaticBlock $staticBlock)
    {
        $staticBlockData = new StaticBlockData();
        $staticBlockData->code = $staticBlock->getCode();
        foreach ($staticBlock->getTranslations() as $staticBlockTranslation) {
            $staticBlockData->texts[$staticBlockTranslation->getLocale()] = $staticBlockTranslation->getText();
        }

        return $staticBlockData;
    }
}
