<?php
ini_set("memory_limit","100M");
include('imagesfunc.php');
#include('DarferClass.php');

function BuildImages($path){
    #$Darf= new Darfer;
    $dir_handle = @opendir($path) or die("Unable to open $path");
    while ($dirItem = readdir($dir_handle))
    {
       if(is_dir($path."/".$dirItem) && $dirItem != "." && $dirItem!=".." && $dirItem!="MidSize" && $dirItem!="Thumbs"){	#Find Dirs
            #$Darf->Debug($dirItem);
            echo "Dir Found:$dirItem\n";
            BuildImages($path."/".$dirItem);
       }
        
        $ext = substr($dirItem, strrpos($dirItem, '.') + 1);
        
        if((strtolower($ext)=="jpg" || strtolower($ext)=="jpeg") && !is_dir($path."/".$dirItem) && $dirItem != "." && $dirItem!=".."){
            $fullpath = $path."/".$dirItem;

                echo "Image Found: $fullpath\n";

                if(!file_exists($path."/MidSize/".$dirItem)){
                     if(!file_exists($path."/MidSize")){
                        mkdir($path."/MidSize",0777);
                    }

                    $image = new SimpleImage();
                    $image->load($fullpath);
                    $image->resizeToHeight(700);
                    $image->save($path."/MidSize/".$dirItem);
                    }
                if(!file_exists($path."/Thumbs/".$dirItem)){

                    if(!file_exists($path."/Thumbs")){
                        mkdir($path."/Thumbs",0777);
                    }
                    $image = new SimpleImage();
                    $image->load($fullpath);
                    $image->resizeToHeight(150);
                    $image->save($path."/Thumbs/".$dirItem);
                }
            }
        }

    


}

BuildImages("Photos")

?>
