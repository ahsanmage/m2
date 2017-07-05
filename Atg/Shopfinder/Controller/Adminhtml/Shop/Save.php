<?php
namespace Atg\Shopfinder\Controller\Adminhtml\Shop;

use Magento\Backend\App\Action;

class Save extends \Magento\Backend\App\Action
{

    /**
* @var \Magento\Framework\Image\AdapterFactory
*/
protected $adapterFactory;
/**
* @var \Magento\MediaStorage\Model\File\UploaderFactory
*/
protected $uploader;
/**
* @var \Magento\Framework\Filesystem
*/
protected $filesystem;
    
    /**
     * @param Action\Context $context
     */
    public function __construct(Action\Context $context,
            \Magento\Framework\Image\AdapterFactory $adapterFactory,
            \Magento\MediaStorage\Model\File\UploaderFactory $uploader,
            \Magento\Framework\Filesystem $filesystem)
    {
        $this->adapterFactory = $adapterFactory;
        $this->uploader = $uploader;
        $this->filesystem = $filesystem;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $model = $this->_objectManager->create('Atg\Shopfinder\Model\ShopDetails');

            $id = $this->getRequest()->getParam('shopdetail_id');
            if ($id) {
                $model->load($id);
            }
            if (isset($_FILES['image']) && isset($_FILES['image']['name']) && strlen($_FILES['image']['name'])) {
                try {
                    $base_media_path = 'shopfinder/shop/images';
                    $uploader = $this->uploader->create(
                        ['fileId' => 'image']
                    );
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                    $imageAdapter = $this->adapterFactory->create();
                    $uploader->addValidateCallback('image', $imageAdapter, 'validateUploadFile');
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(true);
                    $mediaDirectory = $this->filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
                    $result = $uploader->save($mediaDirectory->getAbsolutePath($base_media_path)
                    );
                    $data['image'] = $base_media_path.$result['file'];
                } 
                catch (\Exception $e) {
                    if ($e->getCode() == 0) {
                        $this->messageManager->addError($e->getMessage());
                    }
                }
            } 
            else{
                if (isset($data['image']) && isset($data['image']['value'])) {
                    if (isset($data['image']['delete'])) {
                        $data['image'] = null;
                        $data['delete_image'] = true;
                    } 
                    elseif (isset($data['image']['value'])) {
                        $data['image'] = $data['image']['value'];
                    } 
                    else {
                        $data['image'] = null;
                    }
                }
            }
            
            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccess(__('The shop detail has been saved.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['shopdetail_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the shop detail.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['shopdetail_id' => $this->getRequest()->getParam('shopdetail_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
