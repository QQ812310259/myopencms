<?php

// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------

namespace Weixin\Controller;

use Home\Controller\HomeController;

require_once dirname(dirname(__FILE__)) . '/Util/Wechat/wechat.class.php';

/**
 * 默认控制器
 * @author jry <598821125@qq.com>
 */
class IndexController extends HomeController {

    /**
     * 默认方法
     * @author jry <598821125@qq.com>
     */
    public function index() {
        // 判断判断是微信浏览器自动跳转登录页面
        if (\Common\Util\Device::isWeixin() && !(is_login())) {
            $this->redirect('Weixin/UserBind/index');
        } else {
            $this->display();
        }
    }

    /**
     * 微信消息接口入口
     * 所有发送到微信的消息都会推送到该操作
     * 所以，微信公众平台后台填写的api地址则为该操作的访问地址
     * @author jry <598821125@qq.com>
     */
    public function api($id) {
        //调试
        try {
            //$id = I("id");
            get_token($id);
            $mpinfo = get_token_appinfo($id);

            //加载微信SDK
            $options = array(
                'token' => "wei51", //填写你设定的key
                'encodingaeskey' => $mpinfo["encodingaeskey"], //填写加密用的EncodingAESKey
                'appid' => $mpinfo["appid"], //填写高级调用功能的app id, 请在微信开发模式后台查询
                'appsecret' => $mpinfo["secret"]        //填写高级调用功能的密钥
            );

            $weObj = new \Wechat($options);
            //dump($options);
            // 接口验证
            $weObj->valid();

            //获取微信服务器发来的信息
            $weObj->getRev();
            // 获取请求类型
            $type = $weObj->getRev()->getRevType();
            $ToUserName = $weObj->getRevTo();
            $FromUserName = $weObj->getRevFrom();
            $params['weObj'] = &$weObj;
            $params['mpid'] = $id;
            $params['oid'] = $FromUserName;
            $params['type'] = $type;
            $params['weOptions'] = $this->options;

            if ($type) {
                $this->push($params);  // 响应请求
            }
        } catch (\Exception $e) {
            file_put_contents(APP_PATH . 'Weixin/error.json', json_encode($e->getMessage()));
        }
    }

    /**
     * 响应请求
     * @param  Object $wechat Wechat对象
     * @param  array  $data   接受到微信推送的消息
     */
    private function push($params) {
        $wechat = $params['weObj'];
        $data = $wechat->getRev()->getRevData();
        $type = $params["type"];
        switch ($type) {
            case \Wechat::MSGTYPE_TEXT:
                D('CustomReply')->weixin($params);
                break;
            case \Wechat::MSGTYPE_IMAGE:
                break;
            case \Wechat::MSGTYPE_LOCATION:
                break;
            case \Wechat::MSGTYPE_LINK:
                break;
            case \Wechat::MSGTYPE_EVENT:
                switch ($data['Event']) {
                    case \Wechat::EVENT_SUBSCRIBE:
                        $subscribemob = D("Subscribe");
                        $subscribemob->subscribe($params);
                        break;
                    case \Wechat::EVENT_UNSUBSCRIBE:
                        $wechat->text(C('weixin_config.unsubscribe_msg'))->reply();
                        break;
                    case \Wechat::EVENT_SCAN:
                        break;
                    case \Wechat::EVENT_LOCATION:
                        // 存储用户的地理位置信息
                        $con['openid'] = $data['FromUserName'];
                        $add['latitude'] = $data['Latitude'];
                        $add['longitude'] = $data['Longitude'];
                        $add['precision'] = $data['Precision'];
                        $result = D('UserBind')->where($con)->save($add);
                        break;
                    case \Wechat::EVENT_MENU_CLICK:
                        $params["key"] = $data['EventKey'];
                        D('CustomReply')->weixin($params);
                        break;
                    case \Wechat::EVENT_MENU_VIEW:
                        break;
                }
                break;
            case \Wechat::MSGTYPE_MUSIC:
                break;
            case \Wechat::MSGTYPE_NEWS:
                break;
            case \Wechat::MSGTYPE_VOICE:
                break;
            case \Wechat::MSGTYPE_VIDEO:
                break;
        }
    }

}
