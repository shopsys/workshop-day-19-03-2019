<?php

namespace Shopsys\ShopBundle\Model\Product\Parameter;

use Shopsys\ShopBundle\Component\Grid\InlineEdit\AbstractGridInlineEdit;
use Shopsys\ShopBundle\Form\Admin\Product\Parameter\ParameterFormType;
use Shopsys\ShopBundle\Model\Product\Parameter\ParameterData;
use Shopsys\ShopBundle\Model\Product\Parameter\ParameterFacade;
use Shopsys\ShopBundle\Model\Product\Parameter\ParameterGridFactory;
use Symfony\Component\Form\FormFactory;

class ParameterInlineEdit extends AbstractGridInlineEdit
{
    /**
     * @var \Shopsys\ShopBundle\Model\Product\Parameter\ParameterFacade
     */
    private $parameterFacade;

    /**
     * @var \Symfony\Component\Form\FormFactory
     */
    private $formFactory;

    public function __construct(
        ParameterGridFactory $parameterGridFactory,
        ParameterFacade $parameterFacade,
        FormFactory $formFactory
    ) {
        parent::__construct($parameterGridFactory);
        $this->parameterFacade = $parameterFacade;
        $this->formFactory = $formFactory;
    }
    /**
     * @param \Shopsys\ShopBundle\Model\Product\Parameter\ParameterData $parameterData
     * @return int
     */
    protected function createEntityAndGetId($parameterData)
    {
        $parameter = $this->parameterFacade->create($parameterData);

        return $parameter->getId();
    }

    /**
     * @param int $parameterId
     * @param \Shopsys\ShopBundle\Model\Product\Parameter\ParameterData $parameterData
     */
    protected function editEntity($parameterId, $parameterData)
    {
        $this->parameterFacade->edit($parameterId, $parameterData);
    }

    /**
     * @param int|null $parameterId
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getForm($parameterId)
    {
        $parameterData = new ParameterData();

        if ($parameterId !== null) {
            $parameter = $this->parameterFacade->getById((int)$parameterId);
            $parameterData->setFromEntity($parameter);
        }

        return $this->formFactory->create(ParameterFormType::class, $parameterData);
    }

    /**
     * @return string
     */
    public function getServiceName()
    {
        return 'shopsys.shop.product.parameter.parameter.parameter_inline_edit';
    }
}
