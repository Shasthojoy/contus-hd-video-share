<?php
/*
 * ********************************************************* */
/**
 * @name          : Joomla HD Video Share
 * @version	      : 3.3
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
 * @abstract      : Contus HD Video Share Component Hdvideoshare Adsxml View
 * @Creation Date : March 2010
 * @Modified Date : April 2013
 * */
/*
 * ********************************************************* */
//No direct acesss


defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class contushdvideoshareViewadsxml extends ContushdvideoshareView
{

	function display($cachable = false, $urlparams = false)
	{
        $model =& $this->getModel();
		$detail = $model->getads();
        print_r($detail);
        exit();
	}

}
?>   
