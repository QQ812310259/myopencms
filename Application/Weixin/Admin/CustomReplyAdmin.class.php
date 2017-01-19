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
 * 自定义回复控制器
 * @author jry <598821125@qq.com>
 */
class CustomReplyAdmin extends AdminController {

    /**
     * 自定义回复列表
     * @author jry <598821125@qq.com>
     */
    public function index() {
        //获取所有自定义回复
        $map['status'] = array('egt', '0');  // 禁用和正常状态
        $map['token'] = intval(session('mpid'));
        $p = !empty($_GET["p"]) ? $_GET['p'] : 1;
        $data_list = D('CustomReply')
                ->page($p, C('ADMIN_PAGE_ROWS'))
                ->where($map)
                ->order('id desc')
                ->select();
        $page = new Page(
                D('CustomReply')->where($map)->count(), C('ADMIN_PAGE_ROWS')
        );

        foreach ($data_list as &$vo) {
            if ($vo["reply_type"] == "materialnews" && !empty($vo["reply_key"])) {
                $vo["content"] = '<div id="materlistbox' . $vo["id"] . '" class="materlistbox"></div><script type="text/javascript">$.get("' . U("weixin/materialnews/getdetailajax", array("group_id" => $vo["reply_key"])) . '", function(data){$("#materlistbox' . $vo["id"] . '").html(data);});</script>';
            }
        }
        $extrahtml = <<<EOF
        <link type="text/css" rel="stylesheet" href="././Application/Weixin/View/Public/css/admin.css">
EOF;
        // 使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('关键词自动回复列表')  // 设置页面标题
        ->addTopButton('addnew')         // 添加新增按钮
        ->addTopButton('delete')         // 添加删除按钮
        ->addTableColumn('id', 'ID')
        ->addTableColumn('keyword', '关键词')
        ->addTableColumn('content', '回复内容')
        ->addTableColumn('reply_type', '回复类型')
        ->addTableColumn('ctime', '创建时间', 'time')
        ->addTableColumn('status', '状态', 'status')
        ->addTableColumn('right_button', '操作', 'btn')
        ->setExtraHtml($extrahtml)
        ->setTableDataList($data_list)     // 数据列表
                ->setTableDataPage($page->show())  // 数据列表分页
                ->addRightButton('edit')           // 添加编辑按钮
                ->addRightButton('forbid')  // 添加禁用/启用按钮
                ->addRightButton('delete')  // 添加删除按钮
                ->display();
    }

    //选择菜单事件类型的时候改变页面元素
    private $extra_html = <<<EOF
    <link type="text/css" rel="stylesheet" href="././Application/Weixin/View/Public/css/admin.css">
    <script type="text/javascript" src="./Public/libs/layer/layer.js"></script>
    <script type="text/javascript">
        //选择回复类型的时候改变页面元素
        $(function(){
            var type = $('input[name="reply_type"]:checked').val();
            setreplytype (type);
            $('input[name="reply_type"]').change(function(){               
                type = $(this).val();
                setreplytype (type);
            });
            function setreplytype (type)
	    {
                if(type == 'text'){
                    $('.item_content').removeClass('hidden').prop('disabled', false);
                    $('.item_reply_key').addClass('hidden').prop('disabled', true);
                    $('.item_selmate').addClass('hidden').prop('disabled', true);                       
                } else if (type == 'materialnews') {
                    $('.item_selmate').removeClass('hidden').prop('disabled', false);
                    $('.item_content').addClass('hidden').prop('disabled', true);
                    $('.item_reply_key').addClass('hidden').prop('disabled', true);
                } else {
                    $('.item_reply_key').removeClass('hidden').prop('disabled', false);
                    $('.item_content').addClass('hidden').prop('disabled', true);                   
                    $('.item_selmate').addClass('hidden').prop('disabled', true);
                }
            }
            $('.item_selmate .right').html('<button type="button" class="btn btn-success">选择图文</button><div class="tumang"><a href="javascript:;" class="bassbox">图文+</a></div>')
            $('.item_selmate .tumang,.item_selmate button').on('click', function(){
                layer.open({
                type: 2,
                title: '选择图文素材',
                maxmin: true,
                shadeClose: true, //点击遮罩关闭层
                area : ['1000px' , '600px'],
                content: 'admin.php?s=/weixin/Materialnews/windowslist.html'
                });
            });
            var gid = $('input[name="reply_key"]').val();
            if(gid > 0){
               $.get("admin.php?s=/weixin/Materialnews/getdetailajax/group_id/"+gid, function(data){                 
                  $('.item_selmate .tumang').html(data);
               });
            }
        });
    </script>
EOF;

    public function setForm($id) {
        $model = $this->getmodel();
        if (empty($id)) {
            $title = "添加关键词回复";
            $PostUrl = U('add');
            $v["token"] = intval(session('mpid'));
        } else {
            $title = "编辑关键词回复";
            $PostUrl = U('edit');
            $v = $model->find($id);

            $token = intval(session('mpid'));
            if ($v["token"] != $token) {
                $this->error('你没有权限修改!', U('index'));
            }
        }

        $builder = new \Common\Builder\FormBuilder();
        $builder->setMetaTitle($title)  // 设置页面标题
                ->setPostUrl($PostUrl)    // 设置表单提交地址
                ->addFormItem('id', 'hidden', 'ID', 'ID')
                ->addFormItem('token', 'hidden', 'token', 'token')
                ->addFormItem('keyword', 'text', '关键词', '自定义回复关键词')
                ->addFormItem('reply_type', 'radio', '回复类型', '回复类型', $model->reply_type())
                ->addFormItem('content', 'textarea', '文本回复正文', '简文本回复正文介', null, 'hidden')
                ->addFormItem('reply_key', 'text', '回复其他表数据主键', '格式：1,3,6', null, 'hidden')
                ->addFormItem('selmate', 'hidden', '选择图文', '选择图文', null, 'hidden')
                ->setExtraHtml($this->extra_html)
                ->setFormData($v)
                ->display();
    }

}
