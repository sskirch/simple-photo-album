<?php
/* 
 * DarferWide Functions and vars
 */

/**
 
 * @author sskirch
 */
class Darfer {
    #Basic debug info to file
    function Debug($DebugStr){
        if(!is_file("debug.txt")){
            $DebugFile=fopen("debug.txt",'w');
        }else{
            $DebugFile=fopen("debug.txt",'a');
        }
        fwrite($DebugFile,$DebugStr."\n");
        fclose($DebugFile);
    }

    #constructor
    #function DarferClass{

    #}


}

?>
