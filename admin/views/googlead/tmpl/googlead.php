<?php 
/*
* "ContusHDVideoShare Component" - Version 1.3
* Author: Contus Support - http://www.contussupport.com
* Copyright (c) 2010 Contus Support - support@hdvideoshare.net
* License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
* Project page and Demo at http://www.hdvideoshare.net
* Creation Date: March 30 2011
*/
defined('_JEXEC') or die('Restricted access');
//print_r($this->googlead);
$rs_edit = $this->googlead;
$editor =& JFactory::getEditor();
?>
<script language="javascript">
document.getElementById('toolbar-box').style.marginTop=120+"px";
</script>
<div  style="position:absolute;top:100px;left:20px;width:97%">
   			<div class="t">
				<div class="t">
					<div class="t"></div>
				</div>
			</div>
			<div class="m">
				<div style="float:left;width:20%;padding-top:8px;"><img src="components/com_contushdvideoshare/assets/customization_contushdvideoshare.jpg" alt="" /></div><div style=" padding: 20px 0pt 0pt 50px; float: left; width: 50%;font-size:12px;font-family:Arial, Helvetica, sans-serif;line-height:18px;color:#333333;">
Do you know that HDVideo Share not just develops Extensions but also provides professional web design and custom development services. We would be glad to help you to design and customize the extension to your business needs.
</div><div style="float:right;padding:8px 0 0 50px;;text-decoration:underline;color:#0B55C4;"><div><img src="components/com_contushdvideoshare/assets/logo.jpg" alt="" /></div><div> <div style="padding: 8px 0pt 0pt 10px;float:left;"> <a href="http://www.hdvideoshare.net" target="_blank">Launch hdvideoshare.net</a></div><div style="padding: 8px 0pt 0pt 10px;float:left;"><a href="http://www.hdvideoshare.net/shop/index.php?main_page=contact_us" target="_blank">Contact us</a></div></div></div>
				<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>
  		</div>
<form action="index.php?option=com_contushdvideoshare&layout=googlead" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <fieldset class="adminform">
        <legend>Google AdSence</legend>
        <table class="admintable">
            <tr><td class="key"> Enter the Code:</td><td colspan="3"><textarea rows="10" cols="60" name="code"  id="name" ><?php echo $rs_edit->code;?></textarea></td></tr>
            <tr><td class="key">Option</td><td><input type="radio" name="showoption" value="0" checked />Always Show<input type="radio" name="showoption"  value=1  <?php if($rs_edit->showoption == '1') echo 'checked'; ?> />Close After:<input type="text" name="closeadd" value=<?= $rs_edit->closeadd; ?> />&nbsp;Sec</td></tr>
            <tr><td class="key">Reopen</td><td><input type="checkbox" name="reopenadd" value="0"  <?php if($rs_edit->reopenadd == '0') echo 'checked'; ?> />&nbsp;&nbsp;Re-open After:<input type="text" name="ropen" value=<?= $rs_edit->ropen; ?> />&nbsp;Sec</td></tr>
            <tr><td class="key">Published</td><td><input type="radio" name="publish" value="0" checked="checked" />No<input type="radio" name="publish"   value=1  <?php if($rs_edit->publish == '1') echo 'checked'; ?> />Yes</td></tr>

        </table>
    </fieldset>

    <input type="hidden" name="id" value="<?php echo $rs_edit->id; ?>" />
    <input type="hidden" name="option" value="<?php echo $option; ?>"/>
    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="submitted" value="true" id="submitted">
</form>