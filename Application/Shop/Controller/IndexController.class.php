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
class IndexController extends BaseController {
    /**
     * 默认方法
     */
    public function index() {
        $this->assign('meta_title', "一吨网");
        $this->display();
    }

    /**
     * 列表
     *
     */
    public function lists() {
    	//搜索
    	$keyword = I('keyword', '', 'string');
    	$condition = array('like','%'.$keyword.'%');
    	$map['id|sn'] = array(
    			$condition,
    			'_multi'=>true
    	);
    	
    	// 获取所有分类
        $map['group']    = I('group');
        $map['status'] = 1;
	    switch ($group) {
	    case 1:
	        $meta_title	=	'自营店';
	        break;
	    case 2:
	        $meta_title	=	'加盟店';
	        break;
        default:
        	$meta_title	=	'自营店';
        	break;
		}
        $list = D('product')->where($map)->select();
        D('product')->get_list_order($list);
//         P($list);exit;
        $this->assign('list', $list );
        $this->assign('meta_title', $meta_title);
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

