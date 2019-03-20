<?php

namespace Shopsys\ShopBundle\Controller\Admin;

use Shopsys\FrameworkBundle\Component\Grid\GridFactory;
use Shopsys\FrameworkBundle\Component\Grid\QueryBuilderDataSource;
use Shopsys\FrameworkBundle\Controller\Admin\AdminBaseController;
use Shopsys\ShopBundle\Form\Admin\StaticBlockFormType;
use Shopsys\ShopBundle\Model\StaticBlock\StaticBlockDataFactory;
use Shopsys\ShopBundle\Model\StaticBlock\StaticBlockFacade;
use Shopsys\ShopBundle\Model\StaticBlock\StaticBlockRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StaticBlockController extends AdminBaseController
{
    /**
     * @var \Shopsys\ShopBundle\Model\StaticBlock\StaticBlockRepository
     */
    private $staticBlockRepository;

    /**
     * @var \Shopsys\FrameworkBundle\Component\Grid\GridFactory
     */
    private $gridFactory;

    /**
     * @var \Shopsys\ShopBundle\Model\StaticBlock\StaticBlockDataFactory
     */
    private $staticBlockDataFactory;

    /**
     * @var \Shopsys\ShopBundle\Model\StaticBlock\StaticBlockFacade
     */
    private $staticBlockFacade;

    /**
     * @param \Shopsys\ShopBundle\Model\StaticBlock\StaticBlockRepository $staticBlockRepository
     */
    public function __construct(
        StaticBlockRepository $staticBlockRepository,
        GridFactory $gridFactory,
        StaticBlockDataFactory $staticBlockDataFactory,
        StaticBlockFacade $staticBlockFacade
    ) {
        $this->staticBlockRepository = $staticBlockRepository;
        $this->gridFactory = $gridFactory;
        $this->staticBlockDataFactory = $staticBlockDataFactory;
        $this->staticBlockFacade = $staticBlockFacade;
    }

    /**
     * @Route("/static-block/list/")
     */
    public function listAction()
    {
        $queryBuilder = $this->staticBlockRepository->getAllQuerBuilder();

        $dataSource = new QueryBuilderDataSource($queryBuilder, 'a.id');

        $grid = $this->gridFactory->create('staticBlockList', $dataSource);

        $grid->addColumn('code', 'sb.code', t('Code'));
        $grid->addEditActionColumn('admin_staticblock_edit', ['id' => 'sb.id']);

        return $this->render('ShopsysShopBundle:Admin/Content/StaticBlock:list.html.twig', [
            'gridView' => $grid->createView(),
        ]);
    }

    /**
     * @Route("/static-block/edit/{id}", requirements={"id" = "\d+"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param int $id
     */
    public function editAction(Request $request, $id)
    {
        $staticBlock = $this->staticBlockFacade->getById($id);
        $staticBlockData = $this->staticBlockDataFactory->createFromStaticBlock($staticBlock);

        $form = $this->createForm(StaticBlockFormType::class, $staticBlockData);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->staticBlockFacade->edit($id, $staticBlockData);

            $this->getFlashMessageSender()->addSuccessFlashTwig(
                t('Static block <strong><a href="{{ url }}">{{ code }}</a></strong> modified'),
                [
                    'code' => $staticBlockData->code,
                    'url' => $this->generateUrl('admin_staticblock_edit', ['id' => $staticBlock->getId()]),
                ]
            );
            return $this->redirectToRoute('admin_staticblock_list');
        }

        return $this->render('ShopsysShopBundle:Admin/Content/StaticBlock:edit.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
