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
        'utils'         => ROOT_DIR.'utils/',
        'download'      => ROOT_DIR.'/media/',
        
    ),
    
    'cache' => array(
        'lists_all_name'    => 'lists.all',
        'lifetime'          => array(
            'default'       => 3600,
            'opml'          => 99999999,
            'xml'           => 3600,
            'lists'         => 3600,
            
        ),
        'prefix'            => array(
            'opml'          => 'opml',
            'xml'           => 'xml',
            'lists'         => 'lists'
        )
    ),
    
    'flags' => array(
        'deleted'       => false,
        'downloaded'    => false,
        'errors'        => false
    ),
    
    'plugins' => array(
        'rss_default'   => 'Default',
        'store_default' => 'File'
    ),
    
    'download' => array(
    
        'interval'          => 3600,
        'count'             => 3,
        
        'templateNoTags'    => '%channelTitle%/%author%/%itemTitle%',
        'templateTags'      => '%channelTitle%/%author%/%album%/%filename%',
    )
);

/*
    %channelTitle%  - имя рсс канала
    %author%        - автор композиции из рсс (если есть) или из тега (если включён плагин
    %album%         - альбом композиции из тега
    %itemTitle%     - название песни из рсс или из тега
    %filename%      - название файла
*/

?>