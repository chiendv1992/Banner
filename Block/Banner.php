<?php
namespace Manager\Banner\Block;
class Banner extends \Magento\Framework\View\Element\Template
{
    protected $_bannerFactory;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \ Manager\Banner\Model\BannerFactory $bannerFactory
    )
    {

        $this->_bannerFactory = $bannerFactory;
        parent::__construct($context);
    }

    public function sayHello()
    {
        return __('Hello World');
    }

    public function getBannerCollection()
    {
        $banner = $this->_bannerFactory->create();
        return $banner->getCollection();
    }
    public function getMediaUrl($type)
    {
        $urlImage = "https://http://localhost/magento/". "_{$type}.jpg";
        return $urlImage;
    }
}