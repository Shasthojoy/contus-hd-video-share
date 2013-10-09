<?php
/**
 * @name          : Joomla HVS Komento Plugin
 * @version	  : 1.0
 * @package       : Apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2013 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Joomla HVS Komento Plugin file for Contus HD Video Share
 * @Creation Date : July 2013
 * @Modified Date : July 2013
 * */

## No direct acesss
defined('_JEXEC') or die('Restricted access');
## Include Komento Library Abstract Class File
require_once( JPATH_ROOT . DS . 'components' . DIRECTORY_SEPARATOR . 'com_komento' . DS . 'komento_plugins' . DS . 'abstract.php' );
## Class to Extend Komento for Contus HD Video Share
class KomentoComcontushdvideoshare extends KomentoExtension {

    ## This property (object) stores all the required properties by Komento. (Refer to "load" method in Class methods)
    public $_item;
    /*
     * This property (array) stores all the key mappings of the required item properties to map from Komento's default key to your component's custom key.
     * List of required properties are listed below
     */
    public $_map = array(
        'id'            => 'id',
        'title'         => 'title',
        'hits'          => 'hits',
        'created_by'    => 'created_by',
        'catid'         => 'catid',
        'permalink'     => 'permalink'
    );

    ## If your component need to load extra files, do it here by calling $this->addFile( 'your_file' ).
    public function __construct($component) {
        $db = Komento::getDBO();
        parent::__construct($component);
    }

    /*
     * This method should load the article's main property. Required properties by Komento consists of 6 items:
     * Article Id
     * Article Title
     * Article Category Id
     * Article Permalink
     * Article Hits
     * Article Author
     */
    public function load($cid) {
        $db = Komento::getDBO();
        static $instances = array();

        if (!isset($instances[$cid])) {
            $query = "select a.*,u.username as created_by from #__hdflv_upload a LEFT JOIN #__hdflv_video_category e on e.vid=a.id
        				 LEFT JOIN #__hdflv_category b on e.catid=b.id LEFT JOIN #__users u on a.memberid=u.id where a.published=1 and b.published=1 and a.id=$cid order by a.ordering asc"; //Query is to select the popular videos row

            $db->setQuery($query);

            if (!$result = $db->loadObject()) {
                return $this->onLoadArticleError($cid);
            }
            $instances[$cid] = $result;
        }

        $this->_item = $instances[$cid];
        return $this;
    }

    /**
     * This method should load all the Video ids filtered by category ids
     * */
    public function getContentIds($categories = '') {
        $db = Komento::getDBO();
        $query = '';
        if (empty($categories)) {
            $query = 'SELECT `vid` FROM ' . $db->nameQuote('#__hdflv_video_category') . ' ORDER BY `vid`';
        } else {
            if (is_array($categories)) {
                $categories = implode(',', $categories);
            }

            $query = 'SELECT `vid` FROM ' . $db->nameQuote('#__hdflv_video_category') . ' WHERE `catid` IN (' . $categories . ') ORDER BY `vid`';
        }
        $db->setQuery($query);

        return $db->loadResultArray();
    }

    /**
     * This method should load all the Video Category ids of the component
     * */
    public function getCategories() {

        $db = Komento::getDBO();
        $query = "SELECT id,category AS title FROM #__hdflv_category";
        $db->setQuery($query);
        return $result = $db->loadObjectList();
    }

    /**
     *This method should return the Id of the Video Category.
     * */
    public function getCategoryId() {

       return $this->_item->playlistid ? $this->_item->playlistid : '';
    }

    /*
     * This method should return the Permalink of the Player page.
     */
    public function getContentPermalink() {
        $link = 'index.php?option=com_contushdvideoshare&view=player&catid='.$this->_item->playlistid.'&id='.$this->_item->id;
	$link = $this->prepareLink( $link );
	return $link;
    }

    /*
     * This method should return the Author's Id of the Video.
     */
    public function getAuthorId() {
        return $this->_item->created_by ? $this->_item->created_by : '';
    }

    /**
     * This method lets Komento know if this is the front page or category layout. Useful when you just want Komento to output the comment / hit count.
     * */
    public function isListingView() {
        $views = array('featured', 'category', 'categories', 'archive', 'frontpage');
        return in_array(JRequest::getCmd('view'), $views);
    }

    /**
     * This method lets Komento know if this is the page that the comment form should be displayed on.
     * */
    public function isEntryView() {
        return JRequest::getCmd('view') == 'player';
    }

    /**
     * This method is the main method that appends Komento on the Player Page.
     * */
    public function onExecute(&$article, $html, $view, $options = array()) {
        // $html is the html content generated by Komento       
        return $html;
    }
}