<?php
// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
// 模块信息配置
return array (
  'info' => 
  array (
    'name' => 'Admin',
    'title' => '系统',
    'icon' => 'fa fa-cog',
    'icon_color' => '#3CA6F1',
    'description' => '核心系统',
    'developer' => '南京科斯克网络科技有限公司',
    'website' => 'http://www.opencmf.cn',
    'version' => '1.3.0',
  ),
  'admin_menu' => 
  array (
    1 => 
    array (
      'pid' => '0',
      'title' => '系统',
      'icon' => 'fa fa-cog',
      'level' => 'system',
      'id' => 1,
    ),
    2 => 
    array (
      'pid' => '1',
      'title' => '系统功能',
      'icon' => 'fa fa-folder-open-o',
      'id' => 2,
    ),
    3 => 
    array (
      'pid' => '2',
      'title' => '系统设置',
      'icon' => 'fa fa-wrench',
      'url' => 'Admin/Config/group',
      'id' => 3,
    ),
    4 => 
    array (
      'pid' => '3',
      'title' => '修改设置',
      'url' => 'Admin/Config/groupSave',
      'id' => 4,
    ),
    5 => 
    array (
      'pid' => '2',
      'title' => '导航管理',
      'icon' => 'fa fa-map-signs',
      'url' => 'Admin/Nav/index',
      'id' => 5,
    ),
    6 => 
    array (
      'pid' => '5',
      'title' => '新增',
      'url' => 'Admin/Nav/add',
      'id' => 6,
    ),
    7 => 
    array (
      'pid' => '5',
      'title' => '编辑',
      'url' => 'Admin/Nav/edit',
      'id' => 7,
    ),
    8 => 
    array (
      'pid' => '5',
      'title' => '设置状态',
      'url' => 'Admin/Nav/setStatus',
      'id' => 8,
    ),
    9 => 
    array (
      'pid' => '2',
      'title' => '幻灯管理',
      'icon' => 'fa fa-image',
      'url' => 'Admin/Slider/index',
      'id' => 9,
    ),
    10 => 
    array (
      'pid' => '9',
      'title' => '新增',
      'url' => 'Admin/Slider/add',
      'id' => 10,
    ),
    11 => 
    array (
      'id' => 11,
      'pid' => '9',
      'title' => '编辑',
      'url' => 'Admin/Slider/edit',
      'icon' => '',
    ),
    12 => 
    array (
      'pid' => '9',
      'title' => '设置状态',
      'url' => 'Admin/Slider/setStatus',
      'id' => 12,
    ),
    13 => 
    array (
      'pid' => '2',
      'title' => '配置管理',
      'icon' => 'fa fa-cogs',
      'url' => 'Admin/Config/index',
      'id' => 13,
    ),
    14 => 
    array (
      'pid' => '13',
      'title' => '新增',
      'url' => 'Admin/Config/add',
      'id' => 14,
    ),
    15 => 
    array (
      'pid' => '13',
      'title' => '编辑',
      'url' => 'Admin/Config/edit',
      'id' => 15,
    ),
    16 => 
    array (
      'pid' => '13',
      'title' => '设置状态',
      'url' => 'Admin/Config/setStatus',
      'id' => 16,
    ),
    17 => 
    array (
      'pid' => '2',
      'title' => '上传管理',
      'icon' => 'fa fa-upload',
      'url' => 'Admin/Upload/index',
      'id' => 17,
    ),
    18 => 
    array (
      'pid' => '17',
      'title' => '上传文件',
      'url' => 'Admin/Upload/upload',
      'id' => 18,
    ),
    19 => 
    array (
      'pid' => '17',
      'title' => '删除文件',
      'url' => 'Admin/Upload/delete',
      'id' => 19,
    ),
    20 => 
    array (
      'pid' => '17',
      'title' => '设置状态',
      'url' => 'Admin/Upload/setStatus',
      'id' => 20,
    ),
    21 => 
    array (
      'pid' => '17',
      'title' => '下载远程图片',
      'url' => 'Admin/Upload/downremoteimg',
      'id' => 21,
    ),
    22 => 
    array (
      'pid' => '17',
      'title' => '文件浏览',
      'url' => 'Admin/Upload/fileManager',
      'id' => 22,
    ),
    23 => 
    array (
      'pid' => '1',
      'title' => '系统权限',
      'icon' => 'fa fa-folder-open-o',
      'id' => 23,
    ),
    24 => 
    array (
      'pid' => '23',
      'title' => '用户管理',
      'icon' => 'fa fa-user',
      'url' => 'Admin/User/index',
      'id' => 24,
    ),
    25 => 
    array (
      'id' => '25',
      'pid' => '24',
      'title' => '新增',
      'url' => 'Admin/User/add',
      'icon' => '',
    ),
    26 => 
    array (
      'pid' => '24',
      'title' => '编辑',
      'url' => 'Admin/User/edit',
      'id' => 26,
    ),
    27 => 
    array (
      'pid' => '24',
      'title' => '设置状态',
      'url' => 'Admin/User/setStatus',
      'id' => 27,
    ),
    28 => 
    array (
      'pid' => '23',
      'title' => '管理员管理',
      'icon' => 'fa fa-lock',
      'url' => 'Admin/Access/index',
      'id' => 28,
    ),
    29 => 
    array (
      'pid' => '28',
      'title' => '新增',
      'url' => 'Admin/Access/add',
      'id' => 29,
    ),
    30 => 
    array (
      'pid' => '28',
      'title' => '编辑',
      'url' => 'Admin/Access/edit',
      'id' => 30,
    ),
    31 => 
    array (
      'pid' => '28',
      'title' => '设置状态',
      'url' => 'Admin/Access/setStatus',
      'id' => 31,
    ),
    32 => 
    array (
      'pid' => '23',
      'title' => '用户组管理',
      'icon' => 'fa fa-sitemap',
      'url' => 'Admin/Group/index',
      'id' => 32,
    ),
    33 => 
    array (
      'pid' => '32',
      'title' => '新增',
      'url' => 'Admin/Group/add',
      'id' => 33,
    ),
    34 => 
    array (
      'pid' => '32',
      'title' => '编辑',
      'url' => 'Admin/Group/edit',
      'id' => 34,
    ),
    35 => 
    array (
      'pid' => '32',
      'title' => '设置状态',
      'url' => 'Admin/Group/setStatus',
      'id' => 35,
    ),
    36 => 
    array (
      'pid' => '1',
      'title' => '扩展中心',
      'icon' => 'fa fa-folder-open-o',
      'id' => 36,
    ),
    37 => 
    array (
      'pid' => '36',
      'title' => '前台主题',
      'icon' => 'fa fa-adjust',
      'url' => 'Admin/Theme/index',
      'id' => 37,
    ),
    38 => 
    array (
      'pid' => '37',
      'title' => '安装',
      'url' => 'Admin/Theme/install',
      'id' => 38,
    ),
    39 => 
    array (
      'pid' => '37',
      'title' => '卸载',
      'url' => 'Admin/Theme/uninstall',
      'id' => 39,
    ),
    40 => 
    array (
      'pid' => '37',
      'title' => '更新信息',
      'url' => 'Admin/Theme/updateInfo',
      'id' => 40,
    ),
    41 => 
    array (
      'pid' => '37',
      'title' => '设置状态',
      'url' => 'Admin/Theme/setStatus',
      'id' => 41,
    ),
    42 => 
    array (
      'pid' => '37',
      'title' => '切换主题',
      'url' => 'Admin/Theme/setCurrent',
      'id' => 42,
    ),
    43 => 
    array (
      'pid' => '37',
      'title' => '取消主题',
      'url' => 'Admin/Theme/cancel',
      'id' => 43,
    ),
    44 => 
    array (
      'pid' => '36',
      'title' => '功能模块',
      'icon' => 'fa fa-th-large',
      'url' => 'Admin/Module/index',
      'id' => 44,
    ),
    45 => 
    array (
      'pid' => '44',
      'title' => '安装',
      'url' => 'Admin/Module/install',
      'id' => 45,
    ),
    46 => 
    array (
      'pid' => '44',
      'title' => '卸载',
      'url' => 'Admin/Module/uninstall',
      'id' => 46,
    ),
    47 => 
    array (
      'pid' => '44',
      'title' => '更新信息',
      'url' => 'Admin/Module/updateInfo',
      'id' => 47,
    ),
    48 => 
    array (
      'pid' => '44',
      'title' => '设置状态',
      'url' => 'Admin/Module/setStatus',
      'id' => 48,
    ),
    49 => 
    array (
      'pid' => '36',
      'title' => '插件管理',
      'icon' => 'fa fa-th',
      'url' => 'Admin/Addon/index',
      'id' => 49,
    ),
    50 => 
    array (
      'pid' => '49',
      'title' => '安装',
      'url' => 'Admin/Addon/install',
      'id' => 50,
    ),
    51 => 
    array (
      'pid' => '49',
      'title' => '卸载',
      'url' => 'Admin/Addon/uninstall',
      'id' => 51,
    ),
    52 => 
    array (
      'pid' => '49',
      'title' => '运行',
      'url' => 'Admin/Addon/execute',
      'id' => 52,
    ),
    53 => 
    array (
      'pid' => '49',
      'title' => '设置',
      'url' => 'Admin/Addon/config',
      'id' => 53,
    ),
    54 => 
    array (
      'pid' => '49',
      'title' => '后台管理',
      'url' => 'Admin/Addon/adminList',
      'id' => 54,
    ),
    55 => 
    array (
      'pid' => '54',
      'title' => '新增数据',
      'url' => 'Admin/Addon/adminAdd',
      'id' => 55,
    ),
    56 => 
    array (
      'pid' => '54',
      'title' => '编辑数据',
      'url' => 'Admin/Addon/adminEdit',
      'id' => 56,
    ),
    57 => 
    array (
      'pid' => '54',
      'title' => '设置状态',
      'url' => 'Admin/Addon/setStatus',
      'id' => 57,
    ),
    58 => 
    array (
      'id' => 58,
      'pid' => '2',
      'title' => '后台导航管理',
      'url' => 'Admin/ModelConfig/index',
      'icon' => 'fa-cog',
    ),
    59 => 
    array (
      'pid' => '58',
      'title' => '编辑菜单',
      'url' => 'Admin/ModelConfig/menus',
      'icon' => '',
      'id' => 59,
    ),
    60 => 
    array (
      'id' => 60,
      'pid' => '58',
      'title' => '新增菜单',
      'url' => 'Admin/ModelConfig/add',
      'icon' => '',
    ),
    61 => 
    array (
      'pid' => '58',
      'title' => '编辑菜单',
      'url' => 'Admin/ModelConfig/edit',
      'icon' => '',
      'id' => 61,
    ),
  ),
)
;