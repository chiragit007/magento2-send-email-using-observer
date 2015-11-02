<?php
/**
 * Copyright © 2015 KTPL All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ktpl\Chirag\Block;

use Magento\Framework\View\Element\Template;

class Mylist extends \Magento\Framework\View\Element\Template
{
	
	
	protected $_employeeFactory;
	
	protected $_employeeCollectionFactory;
	
	protected $employee;
 
	public function __construct(\Magento\Framework\View\Element\Template\Context $context,\Ktpl\Chirag\Model\Resource\Employee\CollectionFactory $employeeCollectionFactory,\Ktpl\Chirag\Model\EmployeeFactory $employeeFactory,array $data = [])
    {	        
	     $this->_employeeCollectionFactory = $employeeCollectionFactory;
		 $this->_employeeFactory = $employeeFactory;
		 parent::__construct($context,$data);
    }
	
	public function loadCollection()
	{ 
		if (!$this->employee) {
			$this->employee=$this->_employeeCollectionFactory->create();
		}		
		return $this->employee;
	}
	/**
     * Prepare news collection to set in pager   
     * @return $this
     */
	public function _prepareLayout()
	{
		parent::_prepareLayout();
		if ($this->loadCollection()) 
		{
			$pager = $this->getLayout()->createBlock('Magento\Theme\Block\Html\Pager','ktpl.chirag.record.pager')->setCollection($this->loadCollection());
			$this->setChild('pager', $pager);
			$this->loadCollection()->load();
		}
		return $this;	    
	}
	/**
     * call pager block   
     * @return pager html
     */
	public function getPagerHtml()
	{
		return $this->getChildHtml('pager');
	}
	/**
     * Load news Data   
     * @return News Record
     */
	public function getEmployeeData()
	{
		$employee_id= $this->getRequest()->getParam('id');
		$employeeModel = $this->_employeeFactory->create();
		$employee = $employeeModel->load($employee_id);
		return $employee;
	}
}