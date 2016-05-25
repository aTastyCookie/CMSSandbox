<?php

class DirTools {

    static function zip($zipfile,$directory){
        $zip = new ZipArchive;
        $zip->open($zipfile, ZipArchive::CREATE);        

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
        foreach ($files as $name => $file) { 
		if(!is_dir($file)){
            $localname = str_replace($directory . '/','', $file);
            $zip->addFile($file,$localname);    
		}
        }
        
        $zip->close();
    }
    
    function is_dir_empty($dir) {
        if (!is_readable($dir)) {
            return NULL;
        }
        $handle = opendir($dir);
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                return FALSE;
            }
        }
        return TRUE;
    }

    static function rchmod($path, $filemode, $dirmode) {
        if (is_dir($path)) {
            if (!chmod($path, $dirmode)) {
                $dirmode_str = decoct($dirmode);
                return;
            }
            $dh = opendir($path);
            while (($file = readdir($dh)) !== false) {
                if ($file != '.' && $file != '..') {  // skip self and parent pointing directories
                    $fullpath = $path . '/' . $file;
                    DirTools::rchmod($fullpath, $filemode, $dirmode);
                }
            }
            closedir($dh);
        } else {
            if (is_link($path)) {                
                return;
            }
            if (!chmod($path, $filemode)) {
                $filemode_str = decoct($filemode);                
                return;
            }
        }
    }

    static function rcopy($src, $dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ( $file = readdir($dir))) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if (is_dir($src . '/' . $file)) {
                    DirTools::rcopy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    static function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir")
                        DirTools::rrmdir($dir . "/" . $object);
                    else
                        unlink($dir . "/" . $object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    static function findUniqueDir($dir){
    $dh = opendir($dir);    
    $ret = '';
    $i=0;
    while($entry = readdir($dh)) {          
        if(is_dir($dir . '/' . $entry) && $entry != '.' && $entry != '..') {            
            $ret = $entry;
            $i++;
        }
    }    
    if($i == 1)
        return $ret;    
    return '';
}
}