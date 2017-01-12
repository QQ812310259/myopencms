<?php
/**
 * Created by PhpStorm.
 * User: Jess
 * Github: https://github.com/jessppp
 */

return array(
	// 模板相关配置
	'TMPL_PARSE_STRING'  => array(
			'__PUBLIC__'     => __ROOT__.'/Public',
			'__CUI__'        => __ROOT__.'/Public/libs/cui',
			'__ADMIN_IMG__'  => __ROOT__.'/'.APP_PATH.'Admin/View/Public/img',
			'__ADMIN_CSS__'  => __ROOT__.'/'.APP_PATH.'Admin/View/Public/css',
			'__ADMIN_JS__'   => __ROOT__.'/'.APP_PATH.'Admin/View/Public/js',
			'__ADMIN_LIBS__' => __ROOT__.'/'.APP_PATH.'Admin/View/Public/libs',
			'__HOME_IMG__'   => __ROOT__.'/'.APP_PATH.'Home/View/Public/img',
			'__HOME_CSS__'   => __ROOT__.'/'.APP_PATH.'Home/View/Public/css',
			'__HOME_JS__'    => __ROOT__.'/'.APP_PATH.'Home/View/Public/js',
			'__HOME_LIBS__'  => __ROOT__.'/'.APP_PATH.'Home/View/Public/libs',
			'__SHOP_IMG__'   => __ROOT__.'/'.APP_PATH.'Shop/View/Public/img',
			'__SHOP_CSS__'   => __ROOT__.'/'.APP_PATH.'Shop/View/Public/css',
			'__SHOP_JS__'    => __ROOT__.'/'.APP_PATH.'Shop/View/Public/js',
			'__SHOP_SLICK__'  => __ROOT__.'/'.APP_PATH.'Shop/View/Public/slick',
			'__SHOP_UPLOAD__'  => __ROOT__.'/'.APP_PATH.'Shop/View/Public/upload',
	),

    // 路由配置
    'URL_ROUTER_ON'     => true,
    'URL_MAP_RULES'     => array(
    ),
    'URL_ROUTE_RULES'   => array(
    	':id\d'       => 'product/index',
    ),
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

);
