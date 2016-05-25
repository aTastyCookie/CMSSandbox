<?php
define('DB_HOST','your-DB-hostname');
define('DB_USER','your-DB-username');
define('DB_PASSWORD','your-DB-password');
define('SB_DB_PREFIX','your-chosen-DB-prefix');
define('SB_DB_PASSWORD','generate');
define('ADMIN_LOGIN','your-chosen-sandbox-username');
define('ADMIN_PASSWORD','your-chosen-sandbox-password');
define('SB_MAX',99); 
define('SB_MAX_MESSAGE','Our demo has a limit of 99 sandboxes installations, please delete some first and try again. Thanks!');


/*
 * DB_HOST,DB_USER and DB_PASSWORD is the admin account to create user and database for the sandbox 
 * SB_DB_PREFIX Add a prefix to the sandbox database name
 * SB_DB_PASSWORD: must be 'generate' or 'user' 'generate' generate a random password and user use the username as password
 * 
 * ADMIN_LOGIN and ADMIN_PASSWORD is the admin access to use the sandbox config page.
 * 
 * SB_MAX & SB_MAX_MESSAGE are limit number and warning message if you want to limit the sandboxes number
 * when a sandbox is created, a directory on the root page is created and a mysql user and database is created.
 * to add a new installation Package like drupal, wordpress, joomla or others, you must copy the zip file in the admin/install directory
 * 
 */