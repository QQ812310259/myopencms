# CoreThink

## 项目介绍

## CoreThink是一套基于统一核心的通用互联网+信息化服务解决方案，追求简单、高效、卓越。可轻松实现支持多终端的WEB产品快速搭建、部署、上线。

## 系统功能采用模块化、组件化、插件化等开放化低耦合设计，应用商城拥有丰富的功能模块、插件、主题，便于用户灵活扩展和二次开发。

## 本项目是基于CoreThink框架搭建的，感想原作者分享！

## 目录结构
```
├─index.php 入口文件
│
├─Addons 插件目录
├─Application 应用模块目录
│  ├─Admin 后台模块
│  │  ├─Conf 后台配置文件目录
│  │  ├─Common 后台函数目录
│  │  ├─Controller 后台控制器目录
│  │  ├─Model 后台模型目录
│  │  └─View 后台视图文件目录
│  │
│  ├─Common 公共模块目录（不能直接访问）
│  │  ├─Behavior 行为扩展目录
│  │  ├─Builder Builder目录
│  │  ├─Common 公共函数文件目录
│  │  ├─Conf 公共配置文件目录
│  │  ├─Controller 公共控制器目录
│  │  ├─Model 公共模型目录
│  │  └─Util 第三方类库目录
│  │
│  ├─Home 前台模块
│  │  ├─Conf 前台配置文件目录
│  │  ├─Common 前台函数目录
│  │  ├─Controller 前台控制器目录
│  │  ├─Model 前台模型目录
│  │  ├─TagLib 前台标签库目录
│  │  └─View 模块视图文件目录
│  │
│  ├─Install 安装模块
│  │  ├─Conf 配置文件目录
│  │  ├─Common 函数目录
│  │  ├─Controller 控制器目录
│  │  ├─Model 模型目录
│  │  └─View 模块视图文件目录
│  │
│  └─... 扩展的可装卸功能模块
│
├─Public 应用资源文件目录
│  ├─libs 第三方插件类库目录
│  ├─css gulp编译样式结果存放目录
│  └─js gulp编译脚本结果存放目录
│
├─Runtime 应用运行时目录
├─ThinkPHP 框架目录
└─Uploads 上传根目录
