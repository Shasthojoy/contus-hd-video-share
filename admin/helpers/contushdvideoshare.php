<?php
/**
 * @name          : Contus HD Video Share
 * @version       : 3.5
 * @package       : apptha
 * @since         : Joomla 1.5
 * @subpackage    : Contus HD Video Share.
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2012 Powered by Apptha
 * @license       : GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @abstract      : Contus HD Video Share.
 * @Creation Date : December 26 2013
 **/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class ContushdvideoshareHelper {

    /**
         * Get the actions
         */
        public static function getActions($messageId = 0)
        {
                jimport('joomla.access.access');
                $user   = JFactory::getUser();
                $result = new JObject;

                if (empty($messageId)) {
                        $assetName = 'com_contushdvideoshare';
                }
                else {
                        $assetName = 'com_contushdvideoshare.message.'.(int) $messageId;
                }

                $actions = JAccess::getActions('com_contushdvideoshare', 'component');

                foreach ($actions as $action) {
                        $result->set($action->name, $user->authorise($action->name, $assetName));
                }
                return $result;
        }
        
   
}