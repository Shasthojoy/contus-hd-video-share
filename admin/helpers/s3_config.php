<?php
##  No direct access to this file
defined('_JEXEC') or die;
$db = $this->getDBO();
$query = 'SELECT `dispenable` FROM #__hdflv_site_settings  WHERE `id` = 1';
$db->setQuery($query);
$setting_res = $db->loadResult();
$dispenable = unserialize($setting_res);
$bucket = '';
if(isset($dispenable['amazons3']) && $dispenable['amazons3'] == 1) {

if(isset($dispenable['amazons3name'])) {
  ## Bucket Name
//$bucket="Mustashed-images";  
$bucket = $dispenable['amazons3name'];  
}   

if (!class_exists('S3'))require_once('S3.php');
			
## AWS access info
if (!defined('awsAccessKey')) {
    if(isset($dispenable['amazons3accesskey'])) {
        define('awsAccessKey', $dispenable['amazons3accesskey']);
    }
//    define('awsAccessKey', 'AKIAJIZ2PP3XQ7QFB3XQ');
}
if (!defined('awsSecretKey')) { 
    if(isset($dispenable['amazons3accesssecretkey_area'])) {
        define('awsSecretKey', $dispenable['amazons3accesssecretkey_area']);
    }
//    define('awsSecretKey', 'JsxqBb7vSu1xDbHS3blvdy91Dm/nV1wS68Ge25di');
}
			
## instantiate the class
$s3 = new S3(awsAccessKey, awsSecretKey);

$s3->putBucket($bucket, S3::ACL_PUBLIC_READ);
}

?>