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
class SubscribeAdmin extends AdminController {

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
               $.get("admin.php?s=/weixin/materialnews/getdetailajax/group_id/"+gid, function(data){                 
                  $('.item_selmate .tumang').html(data);
               });
            }
        });
    </script>
EOF;

    public function setForm($id) {
        $model = $this->getmodel();
        $id = $this->addbass();
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
        $v["gotopage"] = U('edit');
        
        $builder = new \Common\Builder\FormBuilder();
        $builder->setMetaTitle($title)  // 设置页面标题
                ->setPostUrl($PostUrl)    // 设置表单提交地址
                ->addFormItem('id', 'hidden', 'ID', 'ID')
                ->addFormItem('gotopage', 'hidden', 'gotopage', 'gotopage')
                ->addFormItem('token', 'hidden', 'token', 'token')
                ->addFormItem('reply_type', 'radio', '回复类型', '回复类型', $model->reply_type())
                ->addFormItem('content', 'textarea', '文本回复正文', '', null, 'hidden')
                ->addFormItem('reply_key', 'text', '回复其他表数据主键', '格式：1,3,6', null, 'hidden')
                ->addFormItem('selmate', 'hidden', '选择图文', '选择图文', null, 'hidden')
                ->setExtraHtml($this->extra_html)
                ->setFormData($v)
                ->display();
    }

    function addbass() {

        $model = $this->getmodel();
        $idmap["token"] = intval(session('mpid'));
        $id = $model->where($idmap)->getField('id', 1);
        if (empty($id)) {
            $data["token"] = intval(session('mpid'));
            $id = $model->add($data);
        }

        return $id;
    }

}
