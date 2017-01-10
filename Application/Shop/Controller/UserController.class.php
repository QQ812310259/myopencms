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
        if (empty($uid)) {
            $this->error('请先登录系统', U('Index/login'));
        }
		parent::_initialize();
	}
    /**
     * 默认方法
     */
    public function index() {
    	$v	=	session('user_auth');
//     	P($v);exit;
    	$this->assign('v', $v);
        $this->assign('meta_title', "用户中心");
        $this->display();
    }

    /**
     * 列表
     *
     */
    public function order() {
        $user	=	session('user_auth');
        $map['uid'] = $user['uid'];
        $map['status'] = 1;
//         $list = D('order')->where($map)->select();
        
       $list =  D('order')->join('LEFT JOIN  oc_shop_product ON oc_shop_order.proid = oc_shop_product.id')
              			->field('oc_shop_product.title,oc_shop_product.pic,oc_shop_order.*')
       					->select();
//        P($list);exit;
        $this->assign('list', $list );
        $this->assign('meta_title', "订单列表");
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

