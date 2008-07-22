<?php
/**
* раздел дирректорий
*/
define('ROOT_DIR',            $_SERVER['DOCUMENT_ROOT']);
define('CLASSES_DIR',         ROOT_DIR.'/classes/');
define('METHODS_DIR',         ROOT_DIR.'/methods/');
define('TMP_DIR',             ROOT_DIR.'/tmp/');

define('SMARTY_DIR',          CLASSES_DIR.'Smarty/libs/');
define('SMARTY_TEMPLATE_DIR', TMP_DIR.'smarty_templates/');
define('SMARTY_COMPILE_DIR',  TMP_DIR.'smarty_templates_c/');
define('SMARTY_CACHE_DIR',    TMP_DIR.'smarty_cache/');
define('SMARTY_CONFIG_DIR',   TMP_DIR.'smarty_config/');
define('SMARTY_CACHE_LIFE_TIME', 60);
define('SMARTY_CACHE',        false);


define('EXCELREADER_DIR',     CLASSES_DIR.'Excel/');

define('IMAGES_DIR',          ROOT_DIR.'/images/');
define('IMAGES_URL',          '/images/');
define('BRANDS_IMAGES_DIR',   'brands/');
define('MODELS_IMAGES_DIR',   'models/');

define('HASHES_DIR',          TMP_DIR.'/hashes/');


define('BRANDS_MODELS_HASH',  HASHES_DIR.'/brands_models_hash.serialize');
define('BRANDS_HASH',         HASHES_DIR.'/brands_hash.serialize');
define('ARTICLES_HASH',       HASHES_DIR.'/articles_hash.serialize');
define('BRANDS_BY_ID_HASH',   HASHES_DIR.'/brands_by_id_hash.serialize');
define('MODELS_HASH',         HASHES_DIR.'/models_hash.serialize');


define('ADMIN_DIR',                 ROOT_DIR.'/admin/');
define('ADMIN_METHODS_DIR',         ADMIN_DIR.'methods/');
define('ADMIN_TMP_DIR',             ADMIN_DIR.'tmp/');
define('ADMIN_SMARTY_TEMPLATE_DIR', ADMIN_TMP_DIR.'smarty_templates/');
define('ADMIN_SMARTY_COMPILE_DIR',  ADMIN_TMP_DIR.'smarty_templates_c/');
define('ADMIN_SMARTY_CACHE_DIR',    ADMIN_TMP_DIR.'smarty_cache/');
define('ADMIN_URL_ROOT',            '/admin/');

/**
 * MYSQL BASE
 *
 */
define('DB_HOST', 'localhost');
define('DB_BASE', 'autozap');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_TABLE_REFIX', 'auto_');


define('XLS_PARTS_START_ROW', 2);
define('XLS_PARTS_NAME', 1);
define('XLS_PARTS_UID', 2);
define('XLS_PARTS_COST', 3);
define('XLS_PARTS_NUMBER', 4);
define('XLS_PARTS_COST_OLD', 5);
define('XLS_PARTS_NUMBER_OLD', 6);

define('XLS_REPARE_START_ROW', 1);
define('XLS_REPARE_NAME', 1);
define('XLS_REPARE_HOURS', 2);
define('XLS_REPARE_COST', 3);


define('XLS_WATING_START_ROW', 2);
define('XLS_WATING_NAME', 1);


?>


