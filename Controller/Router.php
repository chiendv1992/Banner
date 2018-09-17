<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Manager\Banner\Controller;


class Router implements \Magento\Framework\App\RouterInterface
{
    protected $actionFactory;

    
    protected $_eventManager;

   
    protected $_storeManager;

    
    protected $_pageFactory;

  
    protected $_appState;

    
    protected $_url;
    
    protected $_response;

    
    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\UrlInterface $url,
        \Magento\Cms\Model\PageFactory $pageFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\ResponseInterface $response
    ) {
        $this->actionFactory = $actionFactory;
        $this->_eventManager = $eventManager;
        $this->_url = $url;
        $this->_pageFactory = $pageFactory;
        $this->_storeManager = $storeManager;
        $this->_response = $response;
    }

    /**
     * Validate and Match Cms Page and modify request
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @return \Magento\Framework\App\ActionInterface|null
     */
    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');

        $condition = new \Magento\Framework\DataObject(['identifier' => $identifier, 'continue' => true]);
        $this->_eventManager->dispatch(
            'cms_controller_router_match_before',
            ['router' => $this, 'condition' => $condition]
        );
        $identifier = $condition->getIdentifier();

        if ($condition->getRedirectUrl()) {
            $this->_response->setRedirect($condition->getRedirectUrl());
            $request->setDispatched(true);
            return $this->actionFactory->create(\Magento\Framework\App\Action\Redirect::class);
        }

        if (!$condition->getContinue()) {
            return null;
        }


        $page = $this->_pageFactory->create();
        $pageId = $page->checkIdentifier($identifier, $this->_storeManager->getStore()->getId());
        if (!$pageId) {
            return null;
        }

        $request->setModuleName('cms')->setControllerName('page')->setActionName('view')->setParam('id', $pageId);
        $request->setAlias(\Magento\Framework\Url::REWRITE_REQUEST_PATH_ALIAS, $identifier);

        return $this->actionFactory->create(\Magento\Framework\App\Action\Forward::class);
    }
}
