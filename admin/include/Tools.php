<?php 

class Tools{

    static public function getVersion(){
        return "1.1.0";
    }
    

  static public function downloadZip($name,$file){
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"".$name."\"");
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($file));
@ob_end_flush();
@readfile($file);

  }

    static public function getBaseDirectory(){
        return substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],'/') + 1);
    }
    
    static public function initialize($showError){
	session_start();
        error_reporting(E_ERROR | E_WARNING | E_PARSE |E_NOTICE);
        ini_set('display_errors',($showError)?1:0);                       
    }

    static public function controller(){
        
        Tools::checkPreReqs();
        
        if(!Login::getInstance()->is_authenticated()){
            require 'admin/login-controller.php';          
	}
  
        if(Login::getInstance()->is_authenticated()){
            require 'admin/sandbox-controller.php';            
        }
    }
    
    static public function view(){
        if(!Login::getInstance()->is_authenticated()){            
            require 'admin/login-view.php';
        }else{            
            require 'admin/sandbox-view.php';
        }
    }
        
    
    static public function slugify($text) {    
        $text = preg_replace('~[^\\pL\d]+~u', '', $text);     
        $text = trim($text, '-');
        if (function_exists('iconv'))
           $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        $text = strtolower($text); 
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text))    
            return 'n-a';    
        return $text;
    }
    
    static public function generatePassword($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }
    
    static public function getDBName($sandbox) {
        return SB_DB_PREFIX . Tools::slugify($sandbox);
    }
    
    static public function getDBPassword($sandbox) {
        if (SB_DB_PASSWORD == 'user') {
            return Tools::getDBName($sandbox);
        }
        if (SB_DB_PASSWORD == 'generate') {
            return Tools::generatePassword();
        }
        return '';
    }
    
    static public function checkPreReqs(){
          $messages = array();
          global $content;
          $baseDir = Tools::getBaseDirectory();
          
          if(!is_writable($baseDir))
              $messages[] = 'Directory ' . $baseDir . ' is not writable, please check permission.';
          
          if(!is_writable($baseDir . 'admin/sandbox/'))
              $messages[] = 'Directory ' . $baseDir . 'admin/sandbox is not writable, please check permission.';
          
          if (!function_exists('mysqli_connect')) {
              $messages[] = 'MySQLi extension is not installed, please check your php configuration.';
}  
          $content['prereqs'] = $messages;
    }
    
}