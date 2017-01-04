<?php
// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yeyuz1 <812310259@qq.com>
// +----------------------------------------------------------------------
// 模块信息配置
return array (
  'info' => 
  array (
    'name' => 'Shop',
    'title' => '标题',
    'icon' => 'fa fa-flask',
    'icon_color' => '#F9B440',
    'description' => '描述',
    'developer' => 'yeyuz1',
    'website' => 'http://jesuspan.sinaapp.com',
    'version' => '1.0.0',
    'dependences' => 
    array (
      'Admin' => '1.0.0',
    ),
  ),
  'user_nav' => 
  array (
    'center' => 
    array (
      0 => 
      array (
        'title' => '导航1',
        'icon' => 'fa fa-flask',
        'url' => 'Shop/Index/index',
      ),
    ),
    'main' => 
    array (
      0 => 
      array (
        'title' => '导航2',
        'icon' => 'fa fa-flask',
        'url' => 'Shop/Index/index',
      ),
    ),
  ),
  'config' => 
  array (
    'status' => 
    array (
      'title' => '是否开启',
      'type' => 'radio',
      'options' => 
      array (
        1 => '开启',
        0 => '关闭',
      ),
      'value' => '1',
    ),
    'group_list' => 
    array (
      'title' => '栏目分组',
      'type' => 'array',
      'value' => '1:默认',
    ),
    'sell_list' => 
    array (
      'title' => '出售方式',
      'type' => 'array',
      'value' => '1:默认',
    ),
    'place_list' => 
    array (
      'title' => '地区分类',
      'type' => 'array',
      'value' => '1:默认',
    ),
    'taglib' => 
    array (
      'title' => '加载标签库',
      'type' => 'checkbox',
      'options' => 
      array (
        'Shop' => 'Shop',
      ),
      'value' => 
      array (
        0 => 'Shop',
      ),
    ),
    'behavior' => 
    array (
      'title' => '行为扩展',
      'type' => 'checkbox',
      'options' => 
      array (
        'Shop' => 'Shop',
      ),
    ),
  ),
  'admin_menu' => 
  array (
    1 => 
    array (
      'id' => 1,
      'pid' => '0',
      'title' => '一吨',
      'url' => '',
      'icon' => 'fa fa-gift',
    ),
    2 => 
    array (
      'id' => 2,
      'pid' => '1',
      'title' => '系统配置',
      'url' => '',
      'icon' => 'fa fa-folder-open-o',
    ),
    3 => 
    array (
      'id' => 3,
      'pid' => '2',
      'title' => '基本配置',
      'url' => 'shop/index/module_config',
      'icon' => 'fa fa-cog',
    ),
    4 => 
    array (
      'pid' => '1',
      'title' => '内容管理',
      'url' => '',
      'icon' => 'fa fa-folder-open-o',
      'id' => 4,
    ),
    5 => 
    array (
      'id' => 5,
      'pid' => '4',
      'title' => '产品分类',
      'url' => 'Shop/type/index',
      'icon' => 'fa fa-th-list',
    ),
    6 => 
    array (
      'pid' => '5',
      'title' => '新增分类',
      'url' => 'shop/type/add',
      'icon' => '',
      'id' => 6,
    ),
    7 => 
    array (
      'pid' => '5',
      'title' => '编辑分类',
      'url' => 'shop/type/edit',
      'icon' => '',
      'id' => 7,
    ),
    8 => 
    array (
      'id' => 8,
      'pid' => '4',
      'title' => '产品管理',
      'url' => 'shop/product/index',
      'icon' => 'fa fa-stethoscope',
    ),
    9 => 
    array (
      'pid' => '8',
      'title' => '新增产品',
      'url' => 'shop/product/add',
      'icon' => '',
      'id' => 9,
    ),
    10 => 
    array (
      'pid' => '8',
      'title' => '产品编辑',
      'url' => 'shop/product/edit',
      'icon' => '',
      'id' => 10,
    ),
    11 => 
    array (
      'id' => 11,
      'pid' => '4',
      'title' => '地区管理',
      'url' => 'shop/place/index',
      'icon' => 'fa fa-hdd-o',
    ),
    12 => 
    array (
      'id' => 12,
      'pid' => '11',
      'title' => '新增地区',
      'url' => 'shop/place/add',
      'icon' => '',
    ),
    13 => 
    array (
      'id' => '13',
      'pid' => '11',
      'title' => '编辑地区',
      'url' => 'shop/place/edit',
      'icon' => '',
    ),
  ),
)
;