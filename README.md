#CMS_Sandbox


##Requirements

In order to use sandbox, your server or hosting plan needs to comply with the following requirements :

- php 5.3 support
- dedicated mysql database with database and user creation permissions (e.g: dedicated servers, mutualized hosting plans with private database)
- php mysqli library
- read write permissions on the root sandbox installation and all subdirectories

If some of these pre-requisites are not met, you could see an alert box telling you what to check and change prior to being able to use sandbox

##Installation

In order to install and run sandbox, follow these easy steps :

- clone rep
- transfer the files from the sandbox directory on the location of your choice via FTP on your server or hosting plan
- open & edit the config.php file (found in /admin/include/) with the following information :
```
define('DB_HOST','your_hostname');
define('DB_USER','your_DB_username');
define('DB_PASSWORD','your_DB_password');
define('SB_DB_PREFIX','DB_prefix_of_your_choice');
define('SB_DB_PASSWORD','generate');
define('ADMIN_LOGIN','login_of_your_choice');
define('ADMIN_PASSWORD','password_of_your_choice');
define('SB_MAX','max number of possible sandboxes creation');
define('SB_MAX','warning message in case of sandbox limit reached');
```
- save the config.php file
- download the zip packages of the CMS/Shops/Webtools you want to develop projects with (e.g: Wordpress, Drupal, Joomla, PrestaShop, ...) *
- transfer these zip packages to: /admin/install directory via FTP (keep them zipped!)
- you're done! log on and create your first sandbox, read next chapter.

* Some distribution packages need manual repackaging, see "Special cases" chapter.


##Special Cases

Some distributions packages (eg. Opencart) need you to rename files and only transfer portion of the package via your FTP to be able to configure it and finish a proper installation.

In order to benefit from the automatic sandbox deploy/installation, you ofcourse need to:

- Unzip the distribution package on your computer
- Follow the installation instructions (rename files, delete files, only select portion of file)
- ReZip all these files
- Upload it on your sandbox install directory
