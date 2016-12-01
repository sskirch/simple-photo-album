
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <title>
            Darfer's Photo's
        </title><link href="style.css" rel="stylesheet" type="text/css"/>
        
    </head>
    <body>
        <?php

        ini_set("memory_limit","100M");
        include('imagesfunc.php');
        
        if($_REQUEST['folder']) {
            $path=$_REQUEST['folder'];
        }else {
            $path="Photos";
        }

        echo "<h2 class='title'>Folder: $path</h2><br>";

        #find Images
        $dir_handle = @opendir($path) or die("Unable to open $path");

        while ($dirItem = readdir($dir_handle)) {

            $ext = substr($dirItem, strrpos($dirItem, '.') + 1);
            if((strtolower($ext)=="jpg" || strtolower($ext)=="jpeg") && !is_dir($path."/".$dirItem) && $dirItem != "." && $dirItem!="..") {
                $PhotoArray[]=$dirItem;
            }
        }
       

        closedir($dir_handle);

        if($PhotoArray) {
            sort($PhotoArray);
            echo "<center><table>";
            $countPhotosCol = 1;
            $countPhotos = 0;
            foreach($PhotoArray as $Photo) {

                if($countPhotosCol==1) {
                    echo "<tr>";
                }

                 if(!file_exists($path."/MidSize/".$Photo)){
                     if(!file_exists($path."/MidSize")){
                        mkdir($path."/MidSize",0777);
                    }

                    $image = new SimpleImage();
                    $image->load($path."/".$Photo);
                    $image->resizeToHeight(700);
                    $image->save($path."/MidSize/".$Photo);
                    }

                 if(!file_exists($path."/Thumbs/".$Photo)){

                    if(!file_exists($path."/Thumbs")){
                        mkdir($path."/Thumbs",0777);
                    }
                    $image = new SimpleImage();
                    $image->load($path."/".$Photo);
                    $image->resizeToHeight(150);
                    $image->save($path."/Thumbs/".$Photo);
                }    


                echo "<td><center><a href='photoviewersingle.php?folder=$path&pnumber=".($countPhotos)."'><img src='$path/Thumbs/$Photo' title='$Photo'></a></center?><br/></td>";
                if($countPhotosCol==5) {
                    $countPhotosCol=0;
                    echo "</tr>";
                    
                }


                $countPhotos++;
                $countPhotosCol++;
            }

            echo "</table></center>";

        }


        $dir_handle = @opendir($path) or die("Unable to open $path");
        #find Dirs
        while ($dirItem = readdir($dir_handle)) {
            if(is_dir($path."/".$dirItem) && $dirItem != "." && $dirItem!=".." && $dirItem!="Thumbs"  && $dirItem!="MidSize") {	#Find Dirs
		#echo "<a href='photoviewer.php?folder=$path/$dirItem'>$dirItem</a><br/>";
		$dirNames[] = $dirItem;

            }

        }
        closedir($dir_handle);
	if($dirNames){
		sort($dirNames);
		foreach($dirNames as $dirN){
			echo "<a href='photoviewer.php?folder=$path/$dirN'>$dirN</a><br/>";
		}
	}
	
	

        #get previous folder
        $fArray=explode('/',$path);
        for($f=0;$f<=sizeof($fArray)-2;$f++){
            $backPath.=$fArray[$f]."/";
        }

        #get rid of last /
        $backPath=substr($backPath,0,strlen($backPath)-1);
        
         echo "<br><br><a href='photoviewer.php?folder=$backPath'>Back</a>";

        ?>
    </body>

</html>
