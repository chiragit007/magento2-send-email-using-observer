<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ktpl\Chirag\Model;
use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\ScopeInterface;

class Observer
{
    const XML_PATH_EMAIL_SENDER = 'contact/email/sender_email_identity';

    const XML_PATH_EMAIL_RECIPIENT = 'contact/email/recipient_email';

    protected $_registry = null;

    protected $inlineTranslation;

    protected $_transportBuilder;

    protected $scopeConfig;

    public function __construct (
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation ,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->_registry = $registry;
        $this->_transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->scopeConfig = $scopeConfig;
    }

    public function catalognotify(\Magento\Framework\Event\Observer $observer)
    {
        $productID = $observer->getEvent()->getProduct()->getId();
        if($productID == null || $productID == '')
        {
        	
        	$this->inlineTranslation->suspend();
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $transport = $this->_transportBuilder
            ->setTemplateIdentifier('catalognotify')
            ->setTemplateOptions(
                [
                    'area' => \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE,
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                ]
            )
            ->setTemplateVars(['data' => $observer->getEvent()->getProduct()])
            ->setFrom($this->scopeConfig->getValue(self::XML_PATH_EMAIL_SENDER, $storeScope))
            ->addTo($this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT, $storeScope))
            ->setReplyTo($this->scopeConfig->getValue(self::XML_PATH_EMAIL_SENDER, $storeScope))
            ->getTransport();
            try{
                $transport->sendMessage();    
            }catch(Exception $e){
                
            }
            
            $this->inlineTranslation->resume();
        }
    }
}