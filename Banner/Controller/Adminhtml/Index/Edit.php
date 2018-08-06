<?php

namespace Manager\Banner\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Manager_Banner::save';

    protected $_coreRegistry;


    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }


    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $resultBanner = $this->resultPageFactory->create();
        $resultBanner->setActiveMenu('Manager_Banner::manager');
        return $resultBanner;
    }


    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
//        die('Edit ');
        // lấy id và tạo model
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create('Manager\Banner\Model\Banner');
        // kiểm tra có id k nếu có lấy data
        if ($id) {
            $model->load($id);
            // If cannot get ID of model, display error message and redirect to List page
            if (!$model->getId()) {
                $this->messageManager->addError(__('This image no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        // Registry banner
        $this->_coreRegistry->register('banner', $model);
        // Build form
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getImage() : __('Create Image'));
        return $resultPage;
    }
}
