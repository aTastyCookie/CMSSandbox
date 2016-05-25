<?php

class InstallBundle {

    public $name;
    public $installFile;

    function InstallBundle($installFile) {
        $this->installFile = $installFile;
        $this->name = str_replace('.zip', '', $installFile);
    }

    static public function getInstalls() {
        $dirs = opendir('admin/install');
        $installs = array();
        while ($entry = readdir($dirs)) {
            if (!is_dir($entry) && strpos($entry, '.zip') !== false) {
                $installs[] = new InstallBundle($entry);
            }
        }
        closedir($dirs);
        return $installs;
    }

    static public function getInstall($name) {
        $installs = InstallBundle::getInstalls();
        foreach ($installs as $install) {
            if ($install->name == $name)
                return $install;
        }
        return null;
    }

    static public function getHtmlSelectInstall($selectedInstall) {
        $installs = InstallBundle::getInstalls();

        $ret = '<select class="form-control" name="install">';

        if (empty($selectedInstall))
            $ret .= '<option value="none">Choose a package</option>';

        foreach ($installs as $install) {
            $ret .= '<option value="' . $install->name . '" ' . (($install->name == $selectedInstall) ? 'selected' : '') . ' >' . $install->name . '</option>';
        }

        $ret .= '</select>';
        return $ret;
    }

}
