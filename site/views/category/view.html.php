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
jimport('joomla.application.component.view');
class contushdvideoshareViewcategory extends JView
{
function display()
	{
	    $model = $this->getModel();
            $getcategoryview = $model->getcategory();// calling the function in models categoryview.php
            $this->assignRef('categoryview', $getcategoryview); // assigning reference for the results
            $categorrowcol = $model->getcategoryrowcol();
            $this->assignRef('categoryrowcol', $categorrowcol);
            parent::display();
	}
}
?>