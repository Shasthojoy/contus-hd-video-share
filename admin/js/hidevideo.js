/*
 ***********************************************************/
/**
 * @name          : Joomla Hdvideoshare
 * @version	  	  : 3.0
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contushdvideoshare Component Hidevideo
 * @Creation Date : March 2010
 * @Modified Date : June 2012
 * */

/*
 ***********************************************************/
function addQueue(whichForm)
{
    uploadqueue.push(whichForm);
    if (uploadqueue.length == 1)
        processQueue();
    else
        holdQueue();
}
