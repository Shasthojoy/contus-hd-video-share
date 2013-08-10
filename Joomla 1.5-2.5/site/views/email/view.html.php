<?php
/**
 * @name          : Joomla HD Video Share
 * @version	      : 3.2.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
 * @abstract      : Contus HD Video Share Component Email View Page
 * @Creation Date : March 2010
 * @Modified Date : March 2013
 * */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');



class contushdvideoshareViewemail extends JView
{

	function display()
	{
        $model =& $this->getModel();
		$detail = $model->getemail();
        
	}

}
?>   
