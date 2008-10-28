<?php
define("ROOT_DIR",          dirname(__FILE__).'/');
set_include_path(ROOT_DIR);

return array(
    'dirs' => array(
        'root'          => ROOT_DIR,
        'plugins'       => ROOT_DIR.'plugins/',
        'plugins_rss'   => ROOT_DIR.'plugins/rss/',
        'plugins_store' => ROOT_DIR.'plugins/store/',
        'classes'       => ROOT_DIR.'classes/',
        'tmp'           => ROOT_DIR.'tmp/',
        'upload'        => ROOT_DIR.'tmp/upload/',
        'cache'         => ROOT_DIR.'tmp/cache/',
        'utils'         => ROOT_DIR.'utils/'
    ),
    'cache' => array(
        'lists_all_name'    => 'lists.all',
        'lifetime'          => 3600
    ),
    'flags' => array(
        'deleted'       => false,
        'downloaded'    => false,
        'errors'        => false
    ),
    'plugins' => array(
        'rss_default'   => 'Default',
        'store_default' => 'File'
    )
);
?>