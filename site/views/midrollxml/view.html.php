<?php
/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	      : 3.1
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contushdvideoshare Component Hdvideoshare Midrollxml View
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */
/*
 ***********************************************************/
//No direct acesss
defined('_JEXEC') or die('Restricted access');

//importing Default Component Model
jimport('joomla.application.component.view');

/*
 * Description : getads()
 *  This Function Call To UserDefined Ads Function
 */

class contushdvideoshareViewmidrollxml extends JView {

    function display($cachable = false, $urlparams = false) {
        $model = & $this->getModel();
        $detail = $model->getads();
        print_r($detail);
        exit();
    }

}
?>   
