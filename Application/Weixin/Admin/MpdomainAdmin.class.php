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
class MpdomainAdmin extends AdminController {

    /**
     * 素材列表
     * @author jry <598821125@qq.com>
     */
    public function index() {
        //获取所有素材

        $mpid = I('mpid', 0, 'intval');
        $map['status'] = array('egt', '0'); //禁用和正常状态       
        $map["mpid"] = $mpid;
        $p = !empty($_GET["p"]) ? $_GET['p'] : 1;
        $data_list = D('Mpdomain')
                ->page($p, C('ADMIN_PAGE_ROWS'))
                ->where($map)
                ->order('id desc')
                ->select();
        $page = new Page(
                D('Mpdomain')->where($map)->count(), C('ADMIN_PAGE_ROWS')
        );

        // 使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('绑定域名列表')  // 设置页面标题
                ->addTopButton('self', array('title' => '新增', 'href' => U('add', array('mpid' => $mpid)), 'class' => 'btn btn-primary'))   // 添加新增按钮
                ->addTopButton('delete')   // 添加删除按钮
                ->addTableColumn('url', '域名')
                ->addTableColumn('ismobpc', '类型')
                ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list)     // 数据列表
                ->setTableDataPage($page->show())  // 数据列表分页              
                ->addRightButton('edit')           // 添加编辑按钮
                ->display();
    }

    public function setForm($id) {
        $mpid = I('mpid', 0, 'intval');
        $model = $this->getmodel();
        if (empty($id)) {
            $title = "新增绑定域名";
            $v["mpid"] = $mpid;
            $PostUrl = U('add');
        } else {
            $title = "编辑绑定域名";
            $PostUrl = U('edit');
            $v = $model->find($id);
            $mpid = $v["mpid"];
        }
        $v["gotopage"] = U('index', array("mpid" => $mpid));
        // 使用FormBuilder快速建立表单页面。
        $builder = new \Common\Builder\FormBuilder();
        $builder->setMetaTitle($title)  // 设置页面标题
                ->setPostUrl($PostUrl)    // 设置表单提交地址
                ->addFormItem('id', 'hidden', 'ID', 'ID')
                ->addFormItem('gotopage', 'hidden', 'gotopage', 'gotopage')
                ->addFormItem('mpid', 'hidden', 'mpid', 'mpid')
                ->addFormItem('url', 'text', '域名', '域名')
                ->addFormItem('ismobpc', 'radio', '移动端/pc端', '移动端/pc端', array('1' => '移动端', '2' => 'pc端'))
                ->setFormData($v)
                ->display();
    }
}
