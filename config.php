<?php 

# directory to save downloaded files  
define("FILES_DIR", "/vhosts/multidl/");

# list of your ip addresses
# you should add this ip list in your network configuration
# manual : http://code.seanodonnell.com/?id=2

$ip[]	=	'4.2.2.4';
$ip[]	=	'8.8.8.8';



# database configurations
define('DB_HOST', 'localhost');
define('DB_NAME', 'multidl');
define('DB_USER', 'root');
define('DB_PASS', 'password');

# new line
define("NL", "\n");