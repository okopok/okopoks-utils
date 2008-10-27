<?php

define("ROOT_DIR",          dirname(__FILE__).'/');
define("PLUGINS_DIR",       ROOT_DIR.'plugins/');
define("PLUGINS_RSS_DIR",       PLUGINS_DIR.'rss/');
define("PLUGINS_STORE_DIR",     PLUGINS_DIR.'store/');

define("CLASSES_DIR",       ROOT_DIR.'classes/');
define('TMP_DIR',           ROOT_DIR.'tmp/');
define("UPLOAD_DIR",            TMP_DIR.'upload/');
define('CACHE_DIR',             TMP_DIR.'cache/');

set_include_path(ROOT_DIR);

define('PLUGINS_RSS_DEFAULT', 'Default');
define('PLUGINS_STORE_DEFAULT', 'File');

define('FLAG_DELETED',      'deleted');
define('FLAG_DOWNLOADED',   'downloaded');
define('FLAG_ERRORS',       'errors');


?>