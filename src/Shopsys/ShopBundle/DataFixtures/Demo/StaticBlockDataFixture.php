<?php

namespace Shopsys\ShopBundle\DataFixtures\Demo;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Shopsys\ShopBundle\Model\StaticBlock\StaticBlockData;
use Shopsys\ShopBundle\Model\StaticBlock\StaticBlockFacade;

class StaticBlockDataFixture extends AbstractFixture
{
    /**
     * @var \Shopsys\ShopBundle\Model\StaticBlock\StaticBlockFacade
     */
    private $staticBlockFacade;

    public function __construct(StaticBlockFacade $staticBlockFacade)
    {
        $this->staticBlockFacade = $staticBlockFacade;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $staticBlockData = new StaticBlockData();
        $staticBlockData->code = 'test';
        $staticBlockData->texts = [
            'cs' => 'cesky ukazkovy text',
            'en' => 'english demo text',
        ];
        $this->staticBlockFacade->create($staticBlockData);
    }
}
