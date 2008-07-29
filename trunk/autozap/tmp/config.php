<?php
/* MAIN */
define('ROOT_DIR',            $_SERVER['DOCUMENT_ROOT']);
define('ENGINE_DIR',          ROOT_DIR.'/engine/');
define('CLASSES_DIR',         ENGINE_DIR.'/classes/');
define('METHODS_DIR',         ENGINE_DIR.'/methods/');
define('TMP_DIR',             ENGINE_DIR.'/tmp/');
define('HASHES_DIR',          TMP_DIR.'/hashes/');
define('CONTROLLERS_DIR',     ENGINE_DIR.'controllers/');
define('MODELS_DIR',          ENGINE_DIR.'models/');
define('VIEWS_DIR',           ENGINE_DIR.'views/');
define('UTILS_DIR',           ENGINE_DIR.'utils/');

/* --------- */

define('DEBUG', true);

/* IMAGES */
define('SMARTY_DIR',          UTILS_DIR.'Smarty/libs/');
define('SMARTY_TEMPLATE_DIR', TMP_DIR.'smarty_templates/');
define('SMARTY_COMPILE_DIR',  TMP_DIR.'smarty_templates_c/');
define('SMARTY_CACHE_DIR',    TMP_DIR.'smarty_cache/');
define('SMARTY_CONFIG_DIR',   TMP_DIR.'smarty_config/');
define('SMARTY_CACHE_LIFE_TIME', 60);
define('SMARTY_CACHE',        false);
/* --------- */


/* IMAGES */
define('IMAGES_DIR',          ROOT_DIR.'/images/');
define('IMAGES_URL',          '/images/');

define('BRANDS_IMAGES_DIR',   'brands/');
define('MODELS_IMAGES_DIR',   'models/');


define('IMAGES_BRANDS_MEDIUM', 100);
define('IMAGES_BRANDS_SMALL', 50);
define('IMAGES_BRANDS_ORIGINAL_NAME', '-original');
define('IMAGES_MODELS_ORIGINAL_NAME', '-original');
define('IMAGES_MODELS_MEDIUM', 100);
define('IMAGES_MODELS_SMALL', 50);
define('IMAGE_EXTS', '.gif,.jpg,.jpeg,.png');
/* --------- */

/* HASHES */
define('BRANDS_MODELS_HASH',  HASHES_DIR.'/brands_models_hash.serialize');
define('BRANDS_HASH',         HASHES_DIR.'/brands_hash.serialize');
define('ARTICLES_HASH',       HASHES_DIR.'/articles_hash.serialize');
define('BRANDS_BY_ID_HASH',   HASHES_DIR.'/brands_by_id_hash.serialize');
define('MODELS_HASH',         HASHES_DIR.'/models_hash.serialize');
/* --------- */

/* ADMIN */
define('ADMIN_DIR',                 ROOT_DIR.'/admin/');
define('ADMIN_METHODS_DIR',         ADMIN_DIR.'methods/');
define('ADMIN_TMP_DIR',             ADMIN_DIR.'tmp/');
define('ADMIN_SMARTY_TEMPLATE_DIR', ADMIN_TMP_DIR.'smarty_templates/');
define('ADMIN_SMARTY_COMPILE_DIR',  ADMIN_TMP_DIR.'smarty_templates_c/');
define('ADMIN_SMARTY_CACHE_DIR',    ADMIN_TMP_DIR.'smarty_cache/');
define('ADMIN_URL_ROOT',            '/admin/');
/* --------- */


/* DB */
define('DB_HOST', 'localhost');
define('DB_BASE', 'autozap');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_TABLE_REFIX', 'auto_');
/* --------- */

/* XLS */
define('EXCELREADER_DIR',     CLASSES_DIR.'Excel/');
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
/* --------- */

?>


