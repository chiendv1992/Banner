<?php
namespace Manager\Banner\Controller\Adminhtml\Index;
use Magento\Backend\App\Action;
use Manager\Banner\Model\Banner;
use Magento\Framework\App\Request\DataPersistorInterface;
class Save extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Manager_Banner::save';
    protected $dataProcessor;
    protected $dataPersistor;

    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor
    )
    {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            // Optimize data
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Banner::STATUS_ENABLED;
            }
            if (empty($data['id'])) {
                $data['id'] = null;
            }
//            xly ảnh
            if (empty($data['images'])) {
                $data['images'] = null;
            } else {
                if ($data['images'][0] && $data['images'][0]['name'])
                    $data['image'] = $data['images'][0]['name'];
                else
                    $data['image'] = null;
            }
            // Init model and load by ID if exists
            $model = $this->_objectManager->create('Manager\Banner\Model\Banner');
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
            }
            // Validate data
            if (!$this->dataProcessor->validateRequireEntry($data)) {
                // Redirect to Edit page if has error
                return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
            }
            // Update model
            $model->setData($data);
            // Save data to database
            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the Banner.'));
                $this->dataPersistor->clear('manager_banner');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Image.'));
            }
            $this->dataPersistor->set('banner', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        // Redirect to List page
        return $resultRedirect->setPath('*/*/');
    }
}