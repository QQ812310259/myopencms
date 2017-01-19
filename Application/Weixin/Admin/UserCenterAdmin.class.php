<?php

// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------

namespace Weixin\Admin;

use Admin\Controller\AdminController;
use Common\Util\Think\Page;

/**
 * 素材控制器
 * @author jry <598821125@qq.com>
 */
class MpbaseAdmin extends AdminController {

    /**
     * 素材列表
     * @author jry <598821125@qq.com>
     */
    public function index() {
        //获取所有素材       
        $model = $this->getmodel();
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $map['uid'] = array('eq', session('user_auth.uid')); //禁用和正常状态
        $p = !empty($_GET["p"]) ? $_GET['p'] : 1;
        $data_list = $model
                ->page($p, C('ADMIN_PAGE_ROWS'))
                ->where($map)
                ->order('id desc')
                ->select();

        $page = new Page(
                $model->where($map)->count(), C('ADMIN_PAGE_ROWS')
        );

        // 使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('公众号列表')  // 设置页面标题
                ->addTopButton('addnew')   // 添加新增按钮
                ->addTopButton('delete')   // 添加删除按钮
                ->addTableColumn('public_name', '公众号名称')
                ->addTableColumn('type', '公众号类型')
                ->addTableColumn('create_time', '创建时间', 'time')
                ->addTableColumn('status', '状态', 'status')
                ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list)     // 数据列表
                ->setTableDataPage($page->show())  // 数据列表分页
                ->addRightButton('self', array('title' => '进入管理', 'href' => U('setcurrent', array('mpid' => '__data_id__')), 'class' => 'label label-primary'))
                ->addRightButton('self', array('title' => '域名绑定', 'href' => U('mpdomain/index', array('mpid' => '__data_id__')), 'class' => 'label label-primary'))
                ->addRightButton('self', array('title' => '接口配置', 'href' => U('mpinterface', array('mpid' => '__data_id__')), 'class' => 'label label-primary'))
                ->addRightButton('edit')           // 添加编辑按钮
                ->addRightButton('forbid')  // 添加禁用/启用按钮
                ->display();
    }

    public function setForm($id) {
        $model = $this->getmodel();       
        if(empty($id)){
           $title = "添加公众号";
           $PostUrl = U('add');
        }else
        {
           $title = "编辑公众号";
           $PostUrl = U('edit');
           $v=$model->find($id);
        }
        
        $builder = new \Common\Builder\FormBuilder();
        $builder->setMetaTitle($title)  // 设置页面标题
                ->setPostUrl($PostUrl)    // 设置表单提交地址
                ->addFormItem('id', 'hidden', 'ID', 'ID')
                ->addFormItem('public_name', 'text', '公众号名称', '公众号名称')
                ->addFormItem('wechat', 'text', '微信号', '微信号')
                ->addFormItem('public_id', 'text', '原始ID', '原始ID')
                ->addFormItem('type', 'radio', '公众号类型', '公众号类型', array('0' => '普通订阅号', '1' => '认证订阅号', '2' => '普通服务号', '3' => '认证服务号'))
                ->addFormItem('appid', 'text', 'AppID', '(应用ID)')
                ->addFormItem('secret', 'text', 'AppSecret', '(应用密钥)')
                ->addFormItem('encodingaeskey', 'text', 'EncodingAESKey', '（安全模式下必填） ')
                ->setFormData($v)
                ->display();
    }


	/**
	 * 设置公众号token and mid
	 */
    function setcurrent() {

        $model = $this->getmodel();
        $map ['id'] = I('mpid', 0, 'intval');
        $info = $model->where($map)->find();                                             //设置当前上下文mp_id
        unset($map);
        $map ['id'] = is_login();
        $res = M('admin_user')->where($map)->setField('cumpid', $info['id']);

        session('mpid', $info['id']);
        session('public_name', $info['public_name']);
        $this->success('切换公众号成功！');

        redirect(U('weixin/index/index'));
    }
	/**
	 * 接口配置
	 */
    function mpinterface() {
        $mpid = I('mpid', 0, 'intval');
        $this->assign('meta_title', '接口配置');
        $url = $_SERVER['HTTP_HOST'];

        $this->assign("mpid", $mpid);
        $this->assign("url", $url);

        $this->display();
    }

}
