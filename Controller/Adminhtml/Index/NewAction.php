<?php

namespace Manager\Banner\Controller\Adminhtml\Index;

class NewAction extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Manager_Banner::save';


    protected $resultForwardFactory;


    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }



    public function execute()
    {
//        die('new ');
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
