<?php

namespace Shopsys\ShopBundle\Model\StaticBlock;

use Doctrine\ORM\EntityManagerInterface;

class StaticBlockRepository
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $em;

    /**
     * @param \Doctrine\ORM\EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getStaticBlockRepository()
    {
        return $this->em->getRepository(StaticBlock::class);
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAllQuerBuilder()
    {
        return $this->getStaticBlockRepository()->createQueryBuilder('sb');
    }

    /**
     * @param $id
     * @return \Shopsys\ShopBundle\Model\StaticBlock\StaticBlock
     */
    public function getById($id)
    {
        return $this->getStaticBlockRepository()->find($id);
    }
}
