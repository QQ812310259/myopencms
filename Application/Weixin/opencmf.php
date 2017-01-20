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
    'name' => 'Weixin',
    'title' => '微信',
    'icon' => 'fa fa-weixin',
    'icon_color' => '#4AB549',
    'description' => '微信公众号管理模块，适用于单帐号定制',
    'developer' => '南京科斯克网络科技有限公司',
    'website' => 'http://www.opencmf.cn',
    'version' => '1.4.0',
    'dependences' => 
    array (
      'Admin' => '1.1.0',
      'User' => '1.1.0',
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
    'appid' => 
    array (
      'title' => 'AppId',
      'type' => 'text',
      'value' => '',
    ),
    'appsecret' => 
    array (
      'title' => 'AppSecret',
      'type' => 'text',
      'value' => '',
    ),
    'token' => 
    array (
      'title' => '微信后台填写的TOKEN',
      'type' => 'text',
      'value' => '',
    ),
    'crypt' => 
    array (
      'title' => '加密密钥',
      'type' => 'text',
      'value' => '',
    ),
    'access_token' => 
    array (
      'title' => 'AccessToken',
      'type' => 'text',
      'value' => '',
    ),
    'weixin_login' => 
    array (
      'title' => '开启微信登录',
      'type' => 'radio',
      'options' => 
      array (
        1 => '开启',
        0 => '关闭',
      ),
      'value' => '0',
    ),
    'tuling_apikey' => 
    array (
      'title' => '图灵机器人ApiKey',
      'type' => 'text',
      'value' => '',
    ),
    'subscribe_msg' => 
    array (
      'title' => '关注回复信息',
      'type' => 'textarea',
      'value' => '欢迎您关注！',
    ),
    'unsubscribe_msg' => 
    array (
      'title' => '取消关注回复信息',
      'type' => 'textarea',
      'value' => '欢迎您再次关注！',
    ),
    'template_id' => 
    array (
      'title' => '通用模板消息ID',
      'type' => 'text',
      'value' => 'Dfiwm6uEPEgzyrTvd1OKmHytR1I6yKHtDdyveBoi9j0',
    ),
  ),
  'admin_menu' => 
  array (
    1 => 
    array (
      'pid' => '0',
      'title' => '微信',
      'icon' => 'fa fa-weixin',
      'url' => 'Weixin/Index/index',
      'id' => 1,
    ),
    2 => 
    array (
      'pid' => '1',
      'title' => '基本功能',
      'icon' => 'fa fa-weixin',
      'id' => 2,
    ),
    3 => 
    array (
      'pid' => '2',
      'title' => '公众号配置',
      'icon' => 'fa fa-weixin',
      'url' => 'Weixin/Mpbase/index',
      'id' => 3,
    ),
    4 => 
    array (
      'pid' => '2',
      'title' => '自定义菜单',
      'icon' => 'fa fa-bars',
      'url' => 'Weixin/CustomMenu/index',
      'id' => 4,
    ),
    5 => 
    array (
      'pid' => '4',
      'title' => '新增',
      'url' => 'Weixin/CustomMenu/add',
      'id' => 5,
    ),
    6 => 
    array (
      'pid' => '4',
      'title' => '编辑',
      'url' => 'Weixin/CustomMenu/edit',
      'id' => 6,
    ),
    7 => 
    array (
      'pid' => '4',
      'title' => '设置状态',
      'url' => 'Weixin/CustomMenu/setStatus',
      'id' => 7,
    ),
    8 => 
    array (
      'pid' => '2',
      'title' => '被关注自动回复',
      'icon' => 'fa fa-bullhorn',
      'url' => 'Weixin/Subscribe/edit',
      'id' => 8,
    ),
    12 => 
    array (
      'pid' => '2',
      'title' => '关键词自动回复',
      'sort' => '2',
      'icon' => 'fa fa-reply',
      'url' => 'Weixin/CustomReply/index',
      'id' => 12,
    ),
    13 => 
    array (
      'pid' => '12',
      'title' => '新增',
      'url' => 'Weixin/CustomReply/add',
      'id' => 13,
    ),
    14 => 
    array (
      'pid' => '12',
      'title' => '编辑',
      'url' => 'Weixin/CustomReply/edit',
      'id' => 14,
    ),
    25 => 
    array (
      'pid' => '12',
      'title' => '设置状态',
      'url' => 'Weixin/CustomReply/setStatus',
      'id' => 25,
    ),
    26 => 
    array (
      'pid' => '3',
      'title' => '绑定域名',
      'icon' => 'fa fa-weixin',
      'url' => 'weixin/mpdomain/index',
      'id' => 26,
    ),
    27 => 
    array (
      'pid' => '3',
      'title' => '新曾域名',
      'icon' => 'fa fa-weixin',
      'url' => 'weixin/mpdomain/add',
      'id' => 27,
    ),
    28 => 
    array (
      'pid' => '3',
      'title' => '接口配置',
      'icon' => 'fa fa-weixin',
      'url' => 'weixin/mpbase/mpinterface',
      'id' => 28,
    ),
    31 => 
    array (
      'pid' => '3',
      'title' => '编辑',
      'icon' => 'fa fa-weixin',
      'url' => 'weixin/mpbase/edit',
      'id' => 31,
    ),
    29 => 
    array (
      'pid' => '2',
      'title' => '素材管理',
      'icon' => 'fa fa-list',
      'url' => 'Weixin/Materialnews/index',
      'id' => 29,
    ),
    30 => 
    array (
      'pid' => '29',
      'title' => '编辑素材',
      'icon' => 'fa fa-list',
      'url' => 'Weixin/Materialnews/add',
      'id' => 30,
    ),
    32 => 
    array (
      'pid' => '3',
      'title' => '进入管理',
      'icon' => 'fa fa-weixin',
      'url' => 'weixin/mpbase/setcurrent',
      'id' => 32,
    ),
    33 => 
    array (
      'pid' => '3',
      'title' => '新增',
      'url' => 'weixin/mpbase/add',
      'icon' => '',
      'id' => 33,
    ),
    34 => 
    array (
      'id' => 34,
      'pid' => '3',
      'title' => '发送自定义菜单',
      'url' => 'weixin/custom_menu/updateMenu',
      'icon' => '',
    ),
    35 => 
    array (
      'pid' => '2',
      'title' => '用户管理',
      'url' => 'weixin/usercenter/index',
      'icon' => 'fa fa-user',
      'id' => 35,
    ),
    36 => 
    array (
      'pid' => '35',
      'title' => '编辑',
      'url' => 'weixin/usercenter/edit',
      'icon' => '',
      'id' => 36,
    ),
    37 => 
    array (
      'pid' => '35',
      'title' => '新增',
      'url' => 'weixin/usercenter/add',
      'icon' => '',
      'id' => 37,
    ),
    38 => 
    array (
      'pid' => '35',
      'title' => '一键同步公众号粉丝',
      'url' => 'weixin/usercenter/update_weichat_user',
      'icon' => '',
    ),
  ),
)
;