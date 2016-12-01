<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <title>
            Darfer's Photo's
        </title><link href="style.css" rel="stylesheet" type="text/css"/>
        
    </head>
    <body>
        <?php



        if($_REQUEST['folder']) {
            $path=$_REQUEST['folder'];
        }else {
            $path="Photos";
        }

        if($_REQUEST['pnumber']) {
            $pNumber=$_REQUEST['pnumber'];
        }else {
            $pNumber=0;
        }

        

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
        		echo "<h2 class='title'>Image: $path/$PhotoArray[$pNumber]</h2><br>";
            sort($PhotoArray);
            echo "<center><table width=100% >";
            if($pNumber!=0){
                echo "<td><a href='photoviewersingle.php?folder=$path&pnumber=".($pNumber-1)."'><img src='ArrowLeftMid.gif'></a></td>";
            }else{
                echo "<td>&nbsp;</td>";
            }

            echo "<td><center><a href='$path/$PhotoArray[$pNumber]'><img src='$path/MidSize/$PhotoArray[$pNumber]' title='$PhotoArray[$pNumber]'></a></center></td>";

             if($pNumber!=sizeof($PhotoArray)-1){
                echo "<td><a href='photoviewersingle.php?folder=$path&pnumber=".($pNumber+1)."'><img src='ArrowRightMid.gif'></a></td>";
            }else{
                echo "<td>&nbsp;</td>";
            }
            echo "</tr>";
            

            echo "</table></center>";

        }


        $dir_handle = @opendir($path) or die("Unable to open $path");
        #find Dirs
        while ($dirItem = readdir($dir_handle)) {
            if(is_dir($path."/".$dirItem) && $dirItem != "." && $dirItem!=".." && $dirItem!="Thumbs"  && $dirItem!="MidSize") {	#Find Dirs
                echo "<a href='photoviewer.php?folder=$path$dirItem'>$dirItem</a><br/>";

            }

        }
        closedir($dir_handle);

        echo "<br><br><a href='photoviewer.php?folder=$path'>Album Index</a>";




        ?>
    </body>
</html>
