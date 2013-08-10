/*
 ***********************************************************/
/**
 * @name          : Joomla HD Video Share
 * @version	  : 3.4
 * @package       : apptha
 * @since         : Joomla 1.5
 * @author        : Apptha - http://www.apptha.com
 * @copyright     : Copyright (C) 2011 Powered by Apptha
 * @license       : http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @abstract      : Contus HD Video Share Component adslayout.js file for admin section
 * @Creation Date : March 2010
 * @Modified Date : May 2013
 * */

/*
 ***********************************************************/

/**
 * function to hide Preroll/Post Roll onload page
 */

if (document.getElementById('selectadd01').checked == true) {

	document.getElementById('typeofadd').value = 'prepost';

	if (document.getElementById('filepath01').checked == true) {
		adsflashdisable();

	} else if (document.getElementById('filepath02').checked == true) {
		urlenable();
	}

} else if (document.getElementById('selectadd02').checked == true) {
	document.getElementById('typeofadd').value = 'mid';
	adsflashdisable();
}

/**
 * function to hide Preroll/Post Roll
 */
function urlenable() {
	document.getElementById('postrollnf').style.display = 'none';
	document.getElementById('postrollurl').style.display = '';
}

/**
 * function to hide Upload Preroll/Post Roll
 */

function adsflashdisable() {
	document.getElementById('postrollnf').style.display = '';
	document.getElementById('postrollurl').style.display = 'none';
}

/**
 * function to hide Preroll/Post Roll and Upload Preroll/Post Roll on Onclick
 */

function fileads(filepath) {
	if (filepath == "File") {
		adsflashdisable();
		document.getElementById('fileoption').value = 'File';
	}
	if (filepath == "Url") {
		urlenable();
		document.getElementById('fileoption').value = 'Url';
	}
}

/**
 * function to select ad type on Onclick
 */

function checkadd(recadd)
{
    if(recadd=="prepost")
    {
        addsetenable();
        document.getElementById('typeofadd').value='prepost';
    }
    if(recadd=="mid")
    {
        addsetdisable();
        document.getElementById('typeofadd').value='mid';
        document.getElementById('fileoption').value='';
    }
}
 function addsetenable()
{
    document.getElementById('videodet').style.display='';
}
function addsetdisable()
{

    document.getElementById('videodet').style.display='none';
}
