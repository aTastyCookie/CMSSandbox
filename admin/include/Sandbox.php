<?php

class Sandbox {

    public $name;
    public $dbname;
    public $dbpassword;
    public $installedVersion;

    public function getPath() {       
        return substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],'/')) . '/' . $this->name;
        
    }

    public function getUrl() {
        return $this->name;
    }

    public function getSluggedName() {
        return Tools::slugify($this->name);
    }

    static public function getSandboxes() {
        $dirs = opendir('admin/sandbox/');
        $sandboxes = array();
        while ($entry = readdir($dirs)) {
            if (is_file('admin/sandbox/' . $entry)) {
                include 'admin/sandbox/' . $entry;
                $sandbox = new Sandbox();
                $sandbox->name = $sb_name;
                $sandbox->dbname = $sb_dbname;
                $sandbox->dbuser = $sb_dbuser;
                $sandbox->dbpassword = $sb_dbpassword;
                $sandbox->installedVersion = $sb_installedVersion;
                $sandboxes[] = $sandbox;
            }
        }
        closedir($dirs);
        return $sandboxes;
    }

    static public function getSandbox($name) {

        $file = 'admin/sandbox/' . Tools::slugify($name) . '.php';
        if (is_file($file)) {
            include $file;
            $sandbox = new Sandbox();
            $sandbox->name = $sb_name;
            $sandbox->dbname = $sb_dbname;
            $sandbox->dbuser = $sb_dbuser;
            $sandbox->dbpassword = $sb_dbpassword;
            $sandbox->installedVersion = $sb_installedVersion;
            return $sandbox;
        }
        return null;
    }

    function saveInstalledVersion($installName) {
        $fp = fopen('admin/sandbox/' . $this->getSluggedName() . '.php', 'a');
        fwrite($fp, '$sb_installedVersion="' . $installName . '";' . "\n");
        fclose($fp);
    }

    public function download(){
        
        if(!extension_loaded('zlib')){
            throw new Exception("Zlib extension must be installed.");
        }        
        
        $basename=$this->name . '-' . date("Ymd-His");
        $dir = 'admin/tmp/' . $basename;  
        mkdir($dir,0777);
        DirTools::rcopy($this->name,$dir);        
        exec('mysqldump --force --opt --user=' . $this->dbname . ' --password=' . $this->dbpassword . ' ' . $this->dbname . ' > ' . $dir .'/sandbox.sql');        
        
        DirTools::zip($dir . '.zip',$dir);
        DirTools::rrmdir($dir);
        Tools::downloadZip($basename . '.zip',$dir . '.zip');
        unlink($dir . '.zip');

    }

    static function checkSandbox($name){
	
	if (!preg_match("#^[a-z0-9]+$#i" , $name))
	{
		throw new Exception("Sandbox name cannot contain special char.");
	}
	if($name == "admin"){
            throw new Exception("Sandbox name cannot be admin.");
        }
    }


    static function create($sandbox) {    
        
	Sandbox::checkSandbox($sandbox);

        if(SB_MAX > 0){
            if(count(Sandbox::getSandboxes()) >= SB_MAX){                
                throw new Exception(SB_MAX_MESSAGE);
            }
        }
                    
        if(!is_dir($sandbox))
            mkdir($sandbox, 0777);
        
        chmod($sandbox, 0777);
        $dbname = DBTools::sanitizeString(Tools::getDBName($sandbox));
        $dbpassword = DBTools::sanitizeString(Tools::getDBPassword($sandbox));
        $conn = DBTools::getInstance()->getConnection();
        $conn->query("CREATE DATABASE $dbname") or die("Error mysql: " . $conn->error);
        $conn->query("CREATE USER $dbname@localhost identified by '$dbpassword'")or die("Error mysql: " . $conn->error);
        $conn->query("GRANT ALL ON $dbname.* to $dbname@localhost")or die("Error mysql: " . $conn->error);
        $fp = fopen('admin/sandbox/' . Tools::slugify($sandbox) . '.php', 'w');
        fwrite($fp, '<?php ' . "\n");
        fwrite($fp, '$sb_name="' . $sandbox . '";' . "\n");
        fwrite($fp, '$sb_dbuser="' . $dbname . '";' . "\n");
        fwrite($fp, '$sb_dbname="' . $dbname . '";' . "\n");        
        fwrite($fp, '$sb_dbpassword="' . $dbpassword . '";' . "\n");
        fwrite($fp, '$sb_installedVersion="";' . "\n");
    }

    function delete() {
        $conn = DBTools::getInstance()->getConnection();
        DirTools::rchmod($this->name, 0666, 0777);
        DirTools::rrmdir($this->name);
        $dbname = DBTools::sanitizeString($this->dbname);
        $conn->query("DROP DATABASE $dbname");
        $conn->query("DROP USER $dbname@localhost");
        unlink('admin/sandbox/' . Tools::slugify($this->name) . '.php');
    }

    function unzipInstall($sandbox, $installFile, $tmpdir) {
        $zip = new ZipArchive;
        $res = $zip->open('admin/install/' . $installFile);
        if ($res === TRUE) {
            $zip->extractTo($tmpdir);
            $zip->close();
        }
    }

    function prepareInstall($sandbox, $installFile, $findUniqueDir) {
        $tmpdir = 'admin/tmp/' . date("YmdHis");
        if (strpos($installFile, 'zip') !== false) {
            $this->unzipInstall($sandbox, $installFile, $tmpdir);
        }else{
            return;
        }
        
        if ($findUniqueDir) {
            DirTools::rcopy($tmpdir . '/' . DirTools::findUniqueDir($tmpdir), $sandbox . '/');
        } else {
            DirTools::rcopy($tmpdir . '/', $sandbox . '/');
        }
        DirTools::rchmod($sandbox, 0666, 0777);
        DirTools::rrmdir($tmpdir);
    }

    function install($installName) {
        $conn = DBTools::getInstance()->getConnection();
        $dbname = DBTools::sanitizeString($this->dbname);        
        $conn->query("DROP DATABASE $dbname")or die("Error mysql: " . $conn->error);
        $conn->query("CREATE DATABASE $dbname")or die("Error mysql: " . $conn->error);       
        
        DirTools::rrmdir($this->name);
        mkdir($this->name, 0777);
        chmod($this->name, 0777);
        $this->prepareInstall($this->name, InstallBundle::getInstall($installName)->installFile, true);
        $this->saveInstalledVersion($installName);
        
        if(file_exists($this->name . '/sandbox.sql')){
            exec('mysql --user=' . $this->dbname . ' --password=' . $this->dbpassword . ' ' . $this->dbname . ' < ' . $this->name . '/sandbox.sql');        
            rename($this->name . '/sandbox.sql',$this->name . '/sandbox.sql.loaded');
        }
        
    }

}