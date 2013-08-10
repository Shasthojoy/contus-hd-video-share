<?php
/*
* "ContusHDVideoShare Component" - Version 1.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');


class contushdvideoshareControllersettings extends JController
{

   function display()
	{
		
		$viewName   = JRequest::getVar( 'view', 'settings' );

		$viewLayout = JRequest::getVar( 'layout', 'settings' );

		$view = & $this->getView($viewName);
        if ($model = & $this->getModel('settings'))
        {
		$view->setModel($model, true);
		}
		$view->setLayout($viewLayout);
		$view->display();
	}

	function edit()
    {
         $this->display();
	}

	function save()
    {
      
		$detail = JRequest::get( 'POST' );
       //  print_r($detail);
		$model = & $this->getModel('settings');
        $model->saveplayersettings('save');
       $this->setRedirect('index.php?layout=settings&option='.JRequest::getVar('option'), 'Settings Saved!');
		//$this->setRedirect($redirectTo, 'Settings Saved!');
	}

    function apply()
    {
        
	   $detail = JRequest::get( 'POST' );
        //echo $detail['id'];
       $model = & $this->getModel('settings');
        $model->saveplayersettings('apply');
//$model->savecategary($detail);
//        $link='index.php?option=com_contushdvideoshare&layout=settings&task=edit&cid[]='.$detail['id'];
//       $this->setRedirect($link, 'Settings Applyed!');

	}

		function cancel()
        {
			$this->setRedirect('index.php?layout=settings&option='.JRequest::getVar('option'), 'Cancelled...');
			
		}


}

?>
