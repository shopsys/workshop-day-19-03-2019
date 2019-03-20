<?php

namespace Shopsys\ShopBundle\Model\StaticBlock;

use Doctrine\ORM\EntityManagerInterface;

class StaticBlockFacade
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var \Shopsys\ShopBundle\Model\StaticBlock\StaticBlockRepository
     */
    private $staticBlockRepository;

    /**
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, StaticBlockRepository $staticBlockRepository)
    {
        $this->entityManager = $entityManager;
        $this->staticBlockRepository = $staticBlockRepository;
    }

    /**
     * @param \Shopsys\ShopBundle\Model\StaticBlock\StaticBlockData $staticBlockData
     */
    public function create(StaticBlockData $staticBlockData)
    {
        $staticBlock = new StaticBlock($staticBlockData);
        $this->entityManager->persist($staticBlock);
        $this->entityManager->flush();
    }

    public function edit($staticBlockStaticid, StaticBlockData $staticBlockData)
    {
        d($staticBlockData);
        $staticBlock = $this->getById($staticBlockStaticid);
        $staticBlock->edit($staticBlockData);

        $this->entityManager->persist($staticBlock);
        $this->entityManager->flush();
    }

    public function getById($id)
    {
        return $this->staticBlockRepository->getById($id);
    }
}
