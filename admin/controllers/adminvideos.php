<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 * @version	  	  : 3.3
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
 * @abstract      : Contus HD Video Share Component Adminvideos Controller
 * @Creation Date : March 2010
 * @Modified Date : April 2013
 * */
/*
 ***********************************************************/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * hdvideoshare component administrator adminvideos controller
 */  
class contushdvideoshareControlleradminvideos extends ContusvideoshareController {

	/**
	 * Function to set layout and model for view page
	 */ 
    function display($cachable = false, $urlparams = false) {
        $view = $this->getView('showvideos');
        if ($model = $this->getModel('showvideos')) {
            $view->setModel($model, true);
        }
        $view->setLayout('showvideoslayout');
        $view->showvideos();
    }

    /**
	 * Function to set layout and model for add action
	 */ 
    function addvideos() {
        $view = $this->getView('adminvideos');
        if ($model = $this->getModel('addvideos'))
        {
            $view->setModel($model, true);
        }
        $view->setLayout('adminvideoslayout');
        $view->adminvideos();
    }

   	/**
	 * Function to set layout and model for edit action
	 */ 
    function editvideos()
    {
        $view = $this->getView('adminvideos');
        if ($model = $this->getModel('editvideos'))
         {
            $view->setModel($model, true);
         }
        $view->setLayout('adminvideoslayout');
        $view->editvideos();
    }

    /**
	 * Function to set model for save action
	 */ 
    function savevideos()
    {
        if ($model = $this->getModel('showvideos'))
         {
            $model->savevideos(JRequest::getVar('task'));
         }
    }

    /**
	 * Function to set model for apply action
	 */ 
    function applyvideos()
    {
        if ($model = $this->getModel('showvideos'))
         {
            $model->savevideos(JRequest::getVar('task'));
         }
    }

    /**
	 * Function to set model for remove action
	 */ 
    function removevideos()
    {
        if ($model = $this->getModel('editvideos'))
         {
            $model->removevideos();
        }
    }

     /**
	 * Function to set layout for cancel action
	 */ 
    function CANCEL7()
    {
        $view =  $this->getView('showvideos');
        if ($model =  $this->getModel('showvideos'))
        {
            $view->setModel($model, true);
        }
        $view->setLayout('showvideoslayout');
        $view->showvideos();
    }
    
     /**
	 * Function to set redirect for comment page cancel action
	 */ 
    function Commentcancel()
    {
    	$option = JRequest::getCmd('option');
    	$user = JRequest::getCmd('user');
    	$userUrl = ($user == 'admin')?"&user=$user":"";
    	$redirectUrl =  'index.php?option='.$option.'&layout=adminvideos'.$userUrl;    	
    	$this->setRedirect($redirectUrl);
    }

    /**
     * Function to make videos as featured 
     */ 
    function featured()
    {
        $detail = JRequest::get('POST');
        $model = $this->getModel('showvideos');
        $model->featuredvideo($detail);        
    }

     /**
     * Function to make videos as unfeatured 
     */
    function unfeatured()
    {
        $this->featured();
    }

    /**
     * Function to publish videos
     */ 
    function publish()
    {
        $detail = JRequest::get('POST');
        $model = $this->getModel('showvideos');
        $model->changevideostatus($detail);        
    }

    /**
     * Function to unpublish videos
     */ 
    function unpublish()
    {
        $detail = JRequest::get('POST');
        $model = $this->getModel('showvideos');
        $model->changevideostatus($detail);        
    }
    
    /**
     * function to upload file processing
     */
    function uploadfile(){    	
        $model = $this->getModel('uploadvideo');
        $model->fileupload();
    }
    
	/**
     * Function to trash videos
     */ 
    function trash()
    {
        $detail = JRequest::get('POST');
        $model = $this->getModel('showvideos');
        $model->changevideostatus($detail);        
    }
}