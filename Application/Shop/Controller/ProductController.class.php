<?php
/**
 * Created by PhpStorm.
 * User: Jess
 * Github: https://github.com/jessppp
 */

namespace Shop\Controller;
use Home\Controller\HomeController;
/**
 * 默认控制器
 *
 */
class ProductController extends HomeController {
    /**
     * 默认方法
     */
    public function index() {
        $this->assign('meta_title', "前台模块");
        $this->display();
    }

    /**
     * 列表
     *
     */
    public function lists($cid) {
        $map['cid']    = $cid;
        $map['status'] = 1;
        $list = D('Index')->where($map)->select();
        $this->assign('list', $list );
        $this->assign('meta_title', "Shop列表");
        $this->display();
    }
    
    /**
     * 登录
     *
     */
    public function login() {
    	$this->assign('meta_title', "Shop列表");
    	$this->display();
    }
    

    /**
     * 详情
     *
     */
    public function Detail($id) {
        $map['status'] = 1;
        $info = D('Index')->where($map)->find($id);
        $this->assign('info', $info );
        $this->assign('meta_title', "Shop");
        $this->display();
    }

}

