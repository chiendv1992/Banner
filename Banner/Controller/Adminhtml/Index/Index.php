<?php

namespace Manager\Banner\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Manager_Banner::banner';


    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

   
    public function execute()
    {
//        SELECT * FROM banner
//        $data = $collection->getData();
//
//        SELECT * FROM banner WHERE id > 50 (gt = greater than (lớn hơn)) addFieldToFilter(bổ xung thêm điều kiện where)
//        $data = $collection->addFieldToFilter('id', ['gt' => 50])->getData();
//
//        SELECT id FROM banner WHERE id > 50 (addFieldToSelect(lựa chọn tên cột cần lấy))
//        $data = $collection->addFieldToSelect('id')
//            ->addFieldToFilter('id', ['gt' => 50])->getData();
//
//        SELECT * FROM banner WHERE image LIKE '%.png'
//        $data = $collection->addFieldToFilter('image', ['like' => '%.png'])->getData();
//        print_r(json_encode($data));
//
//        SELECT * FROM banner WHERE image LIKE '%.png' AND id > 50
//        $query = $collection->addFieldToFilter('image', ['like' => '%.png'])
//            ->addFieldToFilter('id', ['gt' => 50])
//            ->getSelect();
//
//        SELECT * FROM banner WHERE (image LIKE '%.png' OR image LIKE '%.jpg') AND id > 50
//        $query = $collection->addFieldToFilter('id', ['gt' => 50])
//            ->addFieldToFilter('image', [
//                ['like' => '%.png'],
//                ['like' => '%.jpg']
//            ])->getSelect();
//
//        SELECT * FROM banner WHERE id > 50 OR image LIKE '%.jpg'
//        $query = $collection->addFieldToFilter(['id', 'image'], [
//            ['gt' => 50],
//            ['like' => '%.png']
//        ])->getSelect();
//         echo $query;

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Manager_Banner::manager');
        $resultPage->getConfig()->getTitle()->prepend(__('Banners'));

        $dataPersistor = $this->_objectManager->get(\Magento\Framework\App\Request\DataPersistorInterface::class);
        $dataPersistor->clear('manager_banner');

        return $resultPage;
    }
}
