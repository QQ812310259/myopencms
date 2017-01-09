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
class ProductController extends BaseController {
    /**
     * 默认方法
     */
    public function index() {
    	$info	=	D('product')->find(I('id'));
    	D('product')->_get_list_data($info);
        $this->assign('meta_title', "产品详细");
        $this->assign('info', $info );
        $this->display();
    }

    /**
     * 列表
     *
     */
    public function confirm() {
    	$v['number']	=	I('number');
    	$v['sell']	=	I('sell');
    	$v['id']	=	I('id');
    	if(!$v['id'])$this->error('参数错误',U('index/lists'));
    	$info	=	D('product')->find(I('id'));
    	D('product')->_get_list_data($info);
//     	P($v);exit;
    	$this->assign('v', $v );
    	$this->assign('info', $info );
    	$this->assign('meta_title', "下订单");
    	$this->display();
    }
    /**
     * 下订单
     */
    public function need(){
    	$data['sn']	=	build_order_no();
    	$data['uid']	=	2;
    	$data['sell']	=	I('sell');
    	$data['proid']	=	I('id');
    	$data['number']	=	I('number');
    	$data['price']	=	D('product')->getFieldbyid(I('id'),'price');
    	$info	=	D('order')->create($data);
    	if($info){
    		$chat	=	D('order')->add($data);
    		if ($chat) {
    			$this->success('下订单成功',U('user/index'));
    		}else {
    			$this->error('下订单失败,请稍后再试',U('index/lists'));
    		}
    	}
    }
    

}

