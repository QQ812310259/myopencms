<?php
/**
 * Created by PhpStorm.
 * User: Jess
 * Github: https://github.com/jessppp
 */

namespace Shop\Controller;
/**
 * 默认控制器
 *
 */
class UserController extends BaseController {
	/**
	 * 初始化方法
	 * @author jry <598821125@qq.com>
	 */
	protected function _initialize() {
		//用户登录检测
        $uid = is_login();
        if ($uid) {
            return $uid;
        } else {
            $this->error('请先登录系统', U('Shop/Index/login'));
        }
		parent::_initialize();
	}
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

