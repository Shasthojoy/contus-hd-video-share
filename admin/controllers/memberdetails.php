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

   /**
     * category Component Administrator Controller
     */
class contushdvideoshareControllermemberdetails extends JController
{


   function display()
	{

		$viewName   = JRequest::getVar( 'view', 'memberdetails' );

		$viewLayout = JRequest::getVar( 'layout', 'memberdetails' );
        //$viewLayout='listLayout';
		$view = & $this->getView($viewName);
        if ($model = & $this->getModel('memberdetails'))
        {
			$view->setModel($model, true);
		}
		$view->setLayout($viewLayout);
		$view->display();
	}

   
//	function remove()
//    {
//
//		$arrayIDs = JRequest::getVar('cid', null, 'default', 'array' ); //Reads cid as an array
//		if($arrayIDs === null)
//        { //Make sure the cid parameter was in the request
//			JError::raiseError(500, 'cid parameter missing from the request');
//		}
//
//		$model = & $this->getModel('memberdetails');
//		$model->deletemember($arrayIDs);
//		$this->setRedirect('index.php?layout=memberdetails&option='.JRequest::getVar('option'), 'Removed');
//    }


     function publish()
        {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('memberdetails');
        $model->pubcategary($detail);
        $this->setRedirect('index.php?layout=memberdetails&option='.JRequest::getVar('option'));
        }


       function unpublish()
        {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('memberdetails');
        $model->pubcategary($detail);
        $this->setRedirect('index.php?layout=memberdetails&option='.JRequest::getVar('option'));
        }

     function allowupload()
        {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('memberdetails');
      
        $model->pubupload($detail);
        $this->setRedirect('index.php?layout=memberdetails&option='.JRequest::getVar('option'));
        }


       function unallowupload()
        {
        $detail = JRequest::get('POST');
        $model = & $this->getModel('memberdetails');
        $model->pubupload($detail);
        $this->setRedirect('index.php?layout=memberdetails&option='.JRequest::getVar('option'));
        }
	
}








?>
