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
jimport( 'joomla.application.component.model' );
//define ('DIRECTORY_SEPARATOR', "/");
//define( 'DS', DIRECTORY_SEPARATOR );
class Modelcontushdvideosharevideoupload extends JModel {
    /* Following function is to display the category in the upload page */
    function getupload() {
        $user =& JFactory::getUser();
$editvideo1="";
        if (JRequest::getVar('type','','get','string') == 'edit') {
             $editvideo="select a.*,b.*,c.* from #__hdflv_upload a left join #__hdflv_video_category b on a.id=b.vid left join #__hdflv_category c on c.id=b.catid where a.id=".JRequest::getVar('id','','get','int');

            $db = $this->getDBO();
            $db->setQuery($editvideo);
            $editvideo1 = $db->loadObjectList();
        }
//$user->get('username');

        $session =& JFactory::getSession();
        $url="";
        $success="";
        $query = 'SELECT * FROM #__hdflv_category where published=1 order by Category ASC'; //Query is to get the category list
        $db = $this->getDBO();
        $db->setQuery($query);
        $category1 = $db->loadObjectList();
        if ($category1 === null)
            JError::raiseError(500, 'Category was empty.');

        $flv="";
        $hd="";
        $img="components/com_contushdvideoshare/images/default_thumb.jpg";
        $hq="";
        if(isset($_POST['uploadbtn'])) {
            if($user->get('id')) {
                $memberid=$user->get('id'); //Setting the loginid into session
            }

            if(JRequest::getVar('videourl','','post','string')=="1") // Checking for normal file type of videos
            {
                if(strlen(JRequest::getVar('normalvideoformval','','post','string'))>0) {

                    $flv = substr(JRequest::getVar('normalvideoformval','','post','string'),16,strlen(JRequest::getVar('normalvideoformval','','post','string'))); // Getting the normal video name
                    $flv = substr($flv,strrpos($flv, "/")+1,strlen($flv)) ;
                    $ftype="File";
                    $url= $flv;


                }
                elseif(strlen(JRequest::getVar('ffmpeg','','post','string'))>0) {


                    $VPATH1=JPATH_COMPONENT.'/videos/';

                    $EZFFMPEG_BIN_PATH='/usr/bin/ffmpeg';
//$EZFFMPEG_BIN_PATH=JPATH_COMPONENT.'/ffmpeg5/ffmpeg';
                    $path = substr(JRequest::getVar('ffmpeg','','post','string'),16,strlen(JRequest::getVar('ffmpeg','','post','string'))); // Getting the normal video name

                    $filename = explode ('.', $path);
                    $vpath=$VPATH1;
//echo $filename[1];
//exit;
                    $target_path_img=$vpath.$filename[0].".jpg";
                    $destFile=$vpath.$path;
                    $jpg_resolution="320x240";

                    $target_path1=$VPATH1.$path;
                    $target_path2=$VPATH1.$filename[0].".flv";



                    if($filename[1]!="flv") {
//exec($EZFFMPEG_BIN_PATH. ' ' ."-i". ' ' .$destFile. ' ' ."-sameq". ' '.$target_path1.'  2>&1');
                        exec($EZFFMPEG_BIN_PATH. ' ' ."-i". ' ' .$destFile. ' ' ."-sameq". ' '.$target_path2.'  2>&1');
                    }
//print_r($this->ezffmpeg_vdofile_infos($target_path2));
                    /*************************/

                    $videofile=$destFile;
                    ob_start();
                    passthru("/usr/bin/ffmpeg -i \"{$videofile}\" 2>&1");
//passthru($EZFFMPEG_BIN_PATH." -i \"{$videofile}\" 2>&1");
                    $duration = ob_get_contents();
                    ob_end_clean();

                    $search='/Duration: (.*?),/';
//                    $duration=preg_match($search, $duration, $matches, PREG_OFFSET_CAPTURE, 3);
////TEST ECHO
//                    $duration=$matches[1][0];



                    /***********************************/
                    $data1 = $this->ezffmpeg_vdofile_infos($target_path2);
                    $data=$this->ezffmpeg_vdofile_capture_jpg($destFile, $target_path_img, "3",$jpg_resolution);


                    $url=$filename[0].".flv";
                    $flv=$filename[0].".flv";
                    $hd=" "; // Getting Hd path
                    $hq=" "; // Getting Hq path
                    $img=$filename[0].".jpg"; // Getting thumb path
                    $ftype="FFmpeg";
                    //echo $duration=$data1['vdo_duration_format']."Ssdfsd"; // Getting the duration

                    $dur=explode(":",$duration);
                    $sec=explode(".",$dur[2]);
                  //  $duration=$dur[1].":".$sec[0];
//exit;

                }


             $hd = substr(JRequest::getVar('hdvideoformval','','post','string'),16,strlen(JRequest::getVar('hdvideoformval','','post','string'))); // Getting the hd video name
            $hd = substr($hd,strrpos($hd, "/")+1,strlen($hd)) ;
             $img = substr(JRequest::getVar('thumbimageformval','','post','string'),16,strlen(JRequest::getVar('thumbimageformval','','post','string'))); // Getting the thumb image name
              $img = substr($img,strrpos($img, "/")+1,strlen($img)) ;
            $previewurl = substr(JRequest::getVar('previewimageformval','','post','string'),16,strlen(JRequest::getVar('previewimageformval','','post','string'))); // Getting the preview image name
             // $duration=JRequest::getVar('duration1','','post','string'); // Getting the duration
             $previewurl = substr($previewurl,strrpos($previewurl, "/")+1,strlen($previewurl)) ;

            }
            else // checking condition for urls
            {

              $flv=JRequest::getVar('Youtubeurl','','post','string'); // Getting Flv path
                $url=  $flv;
                $ftype="Youtube";
                $hd=JRequest::getVar('hd','','post','string'); // Getting Hd path
                $hq=JRequest::getVar('hq','','post','string'); // Getting Hq path
               $img=JRequest::getVar('thumburl','','post','string'); // Getting Image path

               if($_FILES["thumburl"]["name"]!="")
               {
                $img="components/com_contushdvideoshare/videos/".$_FILES["thumburl"]["name"];

               if ((($_FILES["thumburl"]["type"] == "image/gif") || ($_FILES["thumburl"]["type"] == "image/jpeg") || ($_FILES["thumburl"]["type"] == "image/png")) )
                 {
                move_uploaded_file($_FILES["thumburl"]["tmp_name"],"components/com_contushdvideoshare/videos/".$_FILES["thumburl"]["name"]);
                 }
                 else
                 {
                     $img="components/com_contushdvideoshare/images/default_thumb.jpg";
                 }
               }


                 if($img=="")
                 {
                if(preg_match('/http:\/\/www\.youtube\.com\/watch\?v=[^&]+/', $url, $vresult)) {

                    $imgstr = explode("v=", $url);
                    $imgval= explode("&",$imgstr[1]);
                    $previewurl="http://img.youtube.com/vi/".$imgval[0]."/0.jpg";
                  $img="http://img.youtube.com/vi/".$imgval[0]."/1.jpg";

                }
                else {
                    $img=$this->imgURL($url);
                    $url1=$this->catchURL($url);
                    $url=$url1[0];

                }}
               // $duration=JRequest::getVar('duration1','','post','string'); // Getting the duration
            }


            $title=JRequest::getVar('title','','post','string'); // Getting the title
            $description=JRequest::getVar('description','','post','string');
            $tagname=JRequest::getVar('tagname','','post','string'); // Getting teh category , tag name
            $type=JRequest::getVar('type','','post','string'); // Getting the type whether private or public
            //$description=JRequest::getVar('descr','','post','string'); // Getting the description

//        $duration=JRequest::getVar('duration1','','post','string'); // Getting the duration
            $db =& JFactory::getDBO();

            $tagname1=$tagname; // Getting the tagname
//exit;
            $tagname=explode(',',$tagname1); //Splitting it using ,
            $tagname=implode("','",$tagname);
            $categoryquery="select id from #__hdflv_category where category in('$tagname')"; // Query is to check whether the given category is exists in the category table or not
            $db->setQuery($categoryquery);
            $result=$db->LoadObjectList();
            foreach($result as $category) {
                $cid=$category->id;
            }


            $cdate=date("Y-m-d h:m:s");
            $value='';
            $updateform = "";

            // Code for seo option
        $seoTitle = preg_replace('/[&:\s]+/i', '-', $title);
        $seoTitle = preg_replace('/[\"\']+/i', '', $seoTitle);



           if( JRequest::getVar('videotype','','post','string') == 'edit') {
                if($previewurl!= '')
               $updateform .= ",previewurl='$previewurl'";
                if($hd!= '')
               $updateform .= ",hdurl='$hd'";
                if($url !='')
                $updateform .= ",videourl='$url'";
                if($img !='')
                $updateform .= ",thumburl='$img'";
                $query=' update #__hdflv_upload SET title="'.$title.'",seotitle="'.$seoTitle.'",type="'.$type.'",description="'.$description.'"'. $updateform.' where id='.JRequest::getVar('videoid','','post','int');
                $db->setQuery($query);
                $db->query();
                $deletecategory =" delete from #__hdflv_video_category where vid='".JRequest::getVar('videoid','','post','int')."'";
                $db->setQuery($deletecategory);
                $db->query();
                $value = JRequest::getVar('videoid','','post','int');
            }else {
                if($previewurl=="")
                $previewurl=$img;
                $query='insert into #__hdflv_upload(title,seotitle,filepath,videourl,thumburl,previewurl,published,type,memberid,description,created_date,addedon,playlistid,hdurl) values ("'.$title.'","'.$seoTitle.'","'.$ftype.'","'.$url.'","'.$img.'","'.$previewurl.'","1","'.$type.'","'.$memberid.'","'.$description.'","'.$cdate.'","'.$cdate.'","'.$cid.'","'.$hd.'")';
                $db->setQuery($query);
                $db->query();
                $db_insert_id=$db->insertid();
                $value=$db_insert_id;
            }    // Query is to insert the urls type of videos



            $categoryquery="select id from #__hdflv_category where category in('$tagname')"; // Query is to check whether the given category is exists in the category table or not
            $db->setQuery($categoryquery);
            $result=$db->LoadObjectList();

            foreach($result as $category) {
                $cid=$category->id; // Getting the category id
                $insertquery="insert into #__hdflv_video_category(vid,catid) values ('$value','$cid')"; // Query is to insert the category id and video id into hdflv_video_category table
                $db->setQuery($insertquery);
                $db->query();

            }
            if(count($result)>0){
            if( JRequest::getVar('videotype','','post','string') == 'edit') {
                $insertquery="update #__hdflv_upload SET playlistid='".$result[0]->id."' where id='".JRequest::getVar('videoid','','post','int')."'"; // Query is to insert the category id and video id into hdflv_video_category table
                $db->setQuery($insertquery);
                $db->query();
            }}
            $success="Your video Uploaded Successfully";

             $url= JRoute::_($baseurl.'index.php?option=com_contushdvideoshare&view=myvideos');
            header("Location: $url");

        }
        return array($category1,$success,$editvideo1);
    }

    function ezffmpeg_vdofile_infos( $src_filepath ) {
        $FLVTOOL_BIN_PATH='/usr/bin/ffmpeg';
//$FLVTOOL_BIN_PATH=JPATH_COMPONENT.'/ffmpeg5/flvtool2';
        $commandline = $FLVTOOL_BIN_PATH." -i ".$src_filepath;
        $exec_return          = $this->ezffmpeg_exec($commandline);

        $exec_return_content  = explode ("\n" , $exec_return);
        //  print_r($exec_return_content);
        if( $error_line_id = $this->ezffmpeg_array_search('error', $exec_return_content) ) {
            $error_line = trim($exec_return_content[$error_line_id]);
            $return_array['status'] 		= -1;
            $return_array['error_msg'] = $error_line;
        }
        else {
            //OK, decode le resultat et renvoie status = 1 + datas
            $return_array['status'] = 1;
//print_r($exec_return_content);
            //Decodage des infos duree / bitrate
            if($infos_line_id = $this->ezffmpeg_array_search('Duration:', $exec_return_content)) {

                $infos_line	   = trim($exec_return_content[$infos_line_id]);
                $infos_cleaning = explode (': ', $infos_line);

                //Duree
                $infos_datas		 = explode (',', $infos_cleaning[1]);
                $return_array['vdo_duration_format']  = trim($infos_datas[0]);
                $return_array['vdo_duration_seconds'] = $this->ezffmpeg_common_time_to_seconds($return_array['vdo_duration_format']);

                //Bitrate
                $return_array['vdo_bitrate']  = trim($infos_cleaning[3]);

            }

            //Decodage des infos codec video
            if($infos_line_id = $this->ezffmpeg_array_search('Video:', $exec_return_content)) {

                $infos_line	   = trim($exec_return_content[$infos_line_id]);
                $infos_cleaning = explode (': ', $infos_line);

            }

            //Decodage des infos codec video
            if($infos_line_id = $this->ezffmpeg_array_search('Audio:', $exec_return_content)) {

                $infos_line	   = trim($exec_return_content[$infos_line_id]);
                $infos_cleaning = explode (': ', $infos_line);
                $infos_datas		 = explode (',', $infos_cleaning[2]);

            }
        }

        return $return_array;

    }

//Creation d'une capture jpg d'une video
    function ezffmpeg_vdofile_capture_jpg ($src_filepath, $output_filepath, $seconds_position, $jpg_resolution="320x240" ) {

        $EZFFMPEG_BIN_PATH='/usr/bin/ffmpeg';
//$EZFFMPEG_BIN_PATH=JPATH_COMPONENT.'/ffmpeg5/ffmpeg';
//    $ffmpetool="d://xampp/htdocs/tamilclips/ffmpeg5/ffmpeg";
        $commandline = $EZFFMPEG_BIN_PATH." -i ".$src_filepath." -y -f mjpeg -t 0.001 -s ".$jpg_resolution." -ss ".$seconds_position." ".$output_filepath;
        $exec_return          = $this->ezffmpeg_exec($commandline);
        $exec_return_content  = explode ("\n" , $exec_return);

        if((!file_exists($output_filepath)) || (filesize($output_filepath) <= 0)) {
            return(1);//Conversion OK (1)
        }
        else {
            return(-1);//Echec, pas de conversion
        }

    }

//Formatage d'une timestamp HH:MM:SS en secondes
    function ezffmpeg_common_time_to_seconds($timestamp) {
        $timestamp_datas = explode (':', $timestamp);
        $nb_seconds			= $timestamp_datas[2];
        $nb_minutes			= $timestamp_datas[1];
        $nb_hours				= $timestamp_datas[0];
        $return_val			= ($nb_hours*3600)+($nb_minutes*60)+$nb_seconds;
        return($return_val);
    }

//Execution propre de FFMpeg avec recuperation des datas
    function ezffmpeg_exec ($commandline) {
        $read = '';
        $handle = popen($commandline.' 2>&1', 'r');
        while(!feof($handle)) {
            $read .= fread($handle, 2096);
        }
        pclose($handle);
        return($read);
    }

//Recherche data dans un array
    function ezffmpeg_array_search($needle, $array_lines) {

        $return_val = false;
        reset ($array_lines);
        foreach( $array_lines as $num_line => $line_content ) {
            if( strpos($line_content, $needle) !== false ) {

                return $num_line;
            }

        }
        return $return_val;
    }
    function getVideoType($location, $add = 0) {


        if(preg_match('/http:\/\/www\.youtube\.com\/watch\?v=[^&]+/', $location, $vresult)) {

            $type= 'youtube';

        } elseif(preg_match('/http:\/\/(.*?)blip\.tv\/file\/[0-9]+/', $location, $vresult)) {


            $type= 'bliptv';

        } elseif(preg_match('/http:\/\/(.*?)break\.com\/(.*?)\/(.*?)\.html/', $location, $vresult)) {

            $type= 'break';

        } elseif(preg_match('/http:\/\/www\.metacafe\.com\/watch\/(.*?)\/(.*?)\//', $location, $vresult)) {

            $type= 'metacafe';

        } elseif(preg_match('/http:\/\/video\.google\.com\/videoplay\?docid=[^&]+/', $location, $vresult)) {

            $type= 'google';

        } elseif(preg_match('/http:\/\/www\.dailymotion\.com\/video\/+/', $location, $vresult)) {

            $type= 'dailymotion';
            $vresult[0]=$location;
        }


        return $type;

    }
    function imgURL($url) {
        $type = $this->getVideoType($url);

        switch ($type) {
            case "youtube":
                $location_img_url = str_replace('http://www.youtube.com/watch?v=', '', $this->url);
                $img = 'http://img.youtube.com/vi/'.$location_img_url.'/1.jpg';
                break;
            case "bliptv":
                $contents = trim($this->file_get_contents_curl($url));
                preg_match('/rel=\"image_src\" href=\"http:\/\/[^\"]+/', $contents, $result_img);
                preg_match('/http:\/\/[^\"]+/', $result_img[0], $result_img);
                $img = $result_img[0];
                break;
            case "break":
                $contents = trim($this->file_get_contents_curl($url));
                preg_match('/meta name=\"embed_video_thumb_url\" content=\"http:\/\/[^\"]+/', $contents, $result_img);
                preg_match('/http:\/\/[^\"]+/', $result_img[0], $result_img);
                $img = $result_img[0];
                break;
            case "metacafe":
                $contents = trim($this->file_get_contents_curl($url));
                preg_match('/thumb_image_src=http%3A%2F%2F(.*?)%2Fthumb%2F[0-9]+%2F[0-9]+%2F[0-9]+%2F(.*?)%2F[0-9]+%2F[0-9]+%2F(.*?)\.jpg/', $contents, $result_img);
                preg_match('/http%3A%2F%2F(.*?)%2Fthumb%2F[0-9]+%2F[0-9]+%2F[0-9]+%2F(.*?)%2F[0-9]+%2F[0-9]+%2F(.*?)\.jpg/', $result_img[0], $result_img);
                $img = urldecode($result_img[0]);
                break;
            case "google":
                $contents = trim($this->file_get_contents_curl($url));
                preg_match('/http:\/\/[0-9]\.(.*?)\.com\/ThumbnailServer2%3Fapp%3D(.*?)%26contentid%3D(.*?)%26offsetms%3D(.*?)%26itag%3D(.*?)%26hl%3D(.*?)%26sigh%3D[^\\\\]+/', $contents, $result);
                $img = urldecode($result[0]);
                break;
            case "dailymotion":
                $contents = trim($this->file_get_contents_curl($url));
                $img=str_replace('www.dailymotion.com','www.dailymotion.com/thumbnail',$this->url);
                break;
        }


        return $img;



    }

    function file_get_contents_curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    function catchURL($url) {
        $type = $this->getVideoType($url);
        $vid_location=array();
        $vid_location[0]=$url;

        switch ($type) {



            case "bliptv":
                $newInfo = trim($this->file_get_contents_curl($url));
                preg_match('/http:\/\/(.*?)blip\.tv\/file\/get\/(.*?)\.flv/', $newInfo, $result);





                $vid_location[0] = urldecode($result[0]);



                break;

            case "break":
                $newInfo = trim($this->file_get_contents_curl($url));
                preg_match('/sGlobalFileName=\'[^\']+/', $newInfo, $resulta);

                $resulta = str_replace('sGlobalFileName=\'', '', $resulta[0]);

                preg_match('/sGlobalContentFilePath=\'[^\']+/', $newInfo, $resultb);

                $resultb = str_replace('sGlobalContentFilePath=\'', '', $resultb[0]);



                $vid_location[0] = 'http://media1.break.com/dnet/media/'.$resultb.'/'.$resulta.'.flv';




                break;

            case "metacafe":
                $newInfo = trim($this->file_get_contents_curl($url));
                preg_match('/mediaURL=http%3A%2F%2F(.*?)%2FItemFiles%2F%255BFrom%2520www.metacafe.com%255D%25(.*?)\.flv+/', $newInfo, $result);
                preg_match('/http%3A%2F%2F(.*?)%2FItemFiles%2F%255BFrom%2520www.metacafe.com%255D%25(.*?)\.flv+/', $result[0], $result);

                $vid_location[0] = urldecode(str_replace('&gdaKey', '?__gda__', $result[0]));



                break;

            case "google":
                $newInfo = trim($this->file_get_contents_curl($url));


                preg_match('/http:\/\/(.*?)googlevideo.com\/videoplayback%3F[^\\\\]+/', $newInfo, $result);



                $vid_location[0] = urldecode($result[0]);



                break;
            case "dailymotion":
                $newInfo = trim($this->file_get_contents_curl($url));
                preg_match('/"video", "(.*?)"/', $newInfo, $result);

                $flv = preg_split('/@@(.*?)\|\|/', urldecode($result[1]));

                $vid_location[0]       = $flv[0];

                break;


        }


        return $vid_location;



    } // END catchURL() FUNCTION
}




?>