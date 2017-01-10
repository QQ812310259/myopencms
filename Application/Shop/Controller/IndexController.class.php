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
    	if ($keyword) {
    		$map['title']  = array('like','%'.$keyword.'%');
    	}
    	//国内 地区
    	$ciy_id = I('cid');
    	if ($ciy_id) {
    		$map['place']  = array('EQ',$ciy_id);
    	}
    	//国内 地区
    	$ciy_id = I('cid');
    	if ($ciy_id) {
    		$map['place']  = array('EQ',$ciy_id);
    	}
    	//产品分类
    	$type_id = I('aaid');
    	if ($type_id) {
    		$map['type']  = array('EQ',$type_id);
    	}
    	
    	//产地国外
    	$placeid = I('placeid');
    	if ($placeid) {
    		$map['origin']  = array('EQ',$placeid);
    	}
    	
        $map['group']    = I('group',1);
    	$map['status']  = array('EQ',1);
    	$order   = 'price ';
    	$order	.=	(I('order'))?I('order'):'desc';
    	
//     	P($order);exit;
    	
    	// 获取所有分类
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
        $list = D('product')->where($map)->order($order)->select();
//         D('product')->get_list_order($list);

//         P($order);exit;
        $this->assign('keyword', $keyword );
        $this->assign('list', $list );
        $this->assign('meta_title', $meta_title);
        $this->display();
    }
    
    /**
     * 登录
     *
     */
    public function login() {
    	$this->assign('meta_title', "用户登录");
    	$this->display();
    }
    /**
     * 注册
     *
     */
    public function register() {
    	$this->assign('meta_title', "用户注册");
    	$this->display();
    }
    

    /**
     * 详情
     *
     */
    public function Detail($id) {
        $map['status'] = 1;
        $info = D('Index')->where($map)->order($order)->find($id);
        $this->assign('info', $info );
        $this->assign('meta_title', "Shop");
        $this->display();
    }

}

