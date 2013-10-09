<?php
/**
 * @name          : Joomla HVS Komento Plugin
 * @version	  : 1.0
 * @package       : Apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2013 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : HVS Komento Plugin Installation file
 * @Creation Date : July 2013
 * @Modified Date : July 2013
 * */

## No direct acesss
defined('_JEXEC') or die('Restricted access');
## Class for HVS Komento Plugin Installation file
class plgSystemHVSkomentoInstallerScript {

    function install($parent) {
        
    }

    function uninstall($parent) {
        
    }

    function update($parent) {
        
    }

    function preflight($type, $parent) {
        
    }

    ## After installing the plugin trigger this function to perform some actions
    function postflight($type, $parent) {

        $db = JFactory::getDBO();
        $query = 'UPDATE  #__extensions ' .
                'SET enabled=1 ' .
                'WHERE element = "HVSkomento"';
        $db->setQuery($query);
        $db->query();
        if (!defined('DS')) {
            define('DS', DIRECTORY_SEPARATOR);
        }
        ## komento_plugin.php file's source and detination paths
        $srcfile = JPATH_SITE . DS . "plugins" . DS . "system" . DS . "HVSkomento" . DS . "komento" . DS . "komento_plugin.php";
        $destfile = JPATH_SITE . DS . "components" . DS . "com_contushdvideoshare" . DS . "komento_plugin.php";
        
        ## com_contushdvideoshare.png image file's source and detination paths
        $srcadmin_image = JPATH_SITE . DS . "plugins" . DS . "system" . DS . "HVSkomento" . DS . "komento" . DS . "com_contushdvideoshare.png";
        $destadmin_image = JPATH_SITE . DS . "administrator" . DS . "components" . DS . "com_komento" . DS . "assets" . DS . "images" . DS . "components" . DS . "com_contushdvideoshare.png";
        
        copy($srcfile, $destfile);                      ## Copy komento_plugin.php file to the destination
        copy($srcadmin_image, $destadmin_image);        ## Copy com_contushdvideoshare.png file to the destination
        if (file_exists($srcfile))
            unlink($srcfile);                           ## Delete the moved komento_plugin.php file if it exist inside the plugin folder
        if (file_exists($srcadmin_image))
            unlink($srcadmin_image);                    ## Delete the moved com_contushdvideoshare.png file if it exist inside the plugin folder
?>
        <!-- Display Installation Status -->
        <style  type="text/css">
            .row-fluid .span10{width: 84%;}
            table{width: 100%;}
            table.adminlist {
                width: 100%;
                border-spacing: 1px;
                background-color: #f3f3f3;
                color: #666;
            }

            table.adminlist td {
                padding: 4px;
            }

            table.adminlist td {padding-left: 8px;}

            table.adminlist tbody tr {
                background-color: #fff;
                text-align: left;
            }

            table.adminlist tbody tr.row0:hover td,
            table.adminlist tbody tr.row1:hover td	{
                background-color: #e8f6fe;
            }

            table.adminlist tbody tr td {
                background: #fff;
                border: 1px solid #fff;
            }

            table.adminlist tbody tr.row1 td {
                background: #f0f0f0;
                border-top: 1px solid #FFF;
            }

            table.adminlist tfoot tr,
            table.adminlist thead tr {
                text-align: center;
                color: #333;
            }

            table.adminlist tfoot,
            table.adminlist thead td {
                background-color: #f7f7f7;
                border-top: 1px solid #999;
                text-align: center;
            }

            table.adminlist td.order {
                text-align: center;
                white-space: nowrap;
                width: 200px;
            }

            table.adminlist td.order span {
                float: left;
                width: 20px;
                text-align: center;
                background-repeat: no-repeat;
                height: 13px;
            }

            table.adminlist .pagination {
                display: inline-block;
                padding: 0;
                margin: 0 auto;
            }
        </style>
        <div style="float: left;">
            <a href="http://www.apptha.com/category/extension/Joomla/HD-Video-Share" target="_blank">
                <img src="components/com_contushdvideoshare/assets/contushdvideoshare-logo.png" alt="Joomla! HDVideoShare" align="left" />
            </a>
        </div>
        <div style="float:right;">
            <a href="http://www.apptha.com/" target="_blank">
                <img src="components/com_contushdvideoshare/assets/contus.jpg" alt="contus products" align="right" />
            </a>
        </div>
        <br><br>

        <h2 align="center">HVS Komento Plugin Installation Status</h2>
        <table class="adminlist">
            <thead>
                <tr>
                    <td colspan="3"></td>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
            <tbody>
                <tr class="row1">
                    <td class="key" colspan="2" style="text-align:center;"><b>Configuration Steps for HVS Komento Plugin:</b></td>
                </tr>
                <tr class="row1">
                    <td class="key" colspan="2">
                        1. To use this plugin, you should have pre-installed Komento and Contus HD Video Share extensions in your joomla website
<br/>
                        2. Go to Components -> Contus HD Video Share -> Site settings -> And select "Commenting System" as "None" and save.<br/>
                        3. Go to Components -> Komento -> Integration -> Select HD Video Share -> select "Yes" for "Enable Comments" under "General" and click "save" <br/>
                        4. Go to Components -> Komento -> ACL ->  Choose HD Video Share -> Select "Public" and click "Save" button.<br/>
                        5. That's it! You're done.</td>
                </tr>
            </tbody>
        </table>
<?php
    }
}
?>