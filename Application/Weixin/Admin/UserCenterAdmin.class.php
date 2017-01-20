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
require_once dirname(dirname(__FILE__)) . '/Util/Wechat/wechat.class.php';
/**
 * 素材控制器
 * @author jry <598821125@qq.com>
 */
class UserCenterAdmin extends AdminController {
	/**
	 * 设定模型
	 * @see \Admin\Controller\AdminController::_initialize()
	 */
	public function _initialize(){
		$this->thismodel	=	'UserBind';
		parent::_initialize();
	}

    /**
     * 素材列表
     * @author jry <598821125@qq.com>
     */
    public function index() {
    	//搜索
    	$keyword = I('keyword', '', 'string');
    	$condition = array('like','%'.$keyword.'%');
    	$map['id|nickname'] = array(
    			$condition,
    			$condition,
    			'_multi'=>true
    	);
        //获取所有素材       
        $model = $this->getmodel();
        $map['status'] = array('egt', '0'); //禁用和正常状态
        $map['token'] = array('eq', get_token()); //禁用和正常状态
        $p = !empty($_GET["p"]) ? $_GET['p'] : 1;
        $data_list = $model
                ->page($p, C('ADMIN_PAGE_ROWS'))
                ->where($map)
                ->order('id desc')
                ->select();

        $page = new Page(
                $model->where($map)->count(), C('ADMIN_PAGE_ROWS')
        );
        foreach ($data_list as $key=>&$v){
			$v['headimgurl']	=	<<<str
			<img src='{$v["headimgurl"]}' style="with:40px;height:40px"/>
str;
        }
//         P($data_list);exit;
        $attr['name'] = 'send';
        $attr['title'] = '一键同步公众号粉丝';
        $attr['class'] = 'btn btn-success ajax-get';
        $attr['url'] = U('syc_user');
        // 使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('公众号粉丝列表')  // 设置页面标题
       		    ->setSearch('请输入用户名', U('index'))
                ->addTopButton('self', $attr)
                ->addTableColumn('id', 'ID')
                ->addTableColumn('headimgurl', '头像')
                ->addTableColumn('nickname', '用户名称')
                ->addTableColumn('openid', 'openid')
                ->addTableColumn('province', '所在省会')
                ->addTableColumn('country', '所在国家')
                ->addTableColumn('uid', '绑定用户','status')
                ->addTableColumn('subscribe', '关注状态','status')
                ->addTableColumn('subscribe_time', '关注时间', 'time')
                ->addTableColumn('status', '状态', 'status')
                ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list)     // 数据列表
                ->setTableDataPage($page->show())  // 数据列表分页
                ->addRightButton('edit')           // 添加编辑按钮
                ->addRightButton('forbid')  // 添加禁用/启用按钮
                ->addRightButton('delete')  // 添加禁用/启用按钮
                ->display();
    }
    //选择菜单事件类型的时候改变页面元素
    private $extra_html = <<<EOF
    <script type="text/javascript">
        //选择菜单事件类型的时候改变页面元素
        $(function(){
             $("input[name='nickname']").attr('disabled','disabled');
        });
    </script>
EOF;

    public function setForm($id) {
        $model = $this->getmodel();
           $title = "编辑粉丝绑定用户";
           $PostUrl = U('edit');
           $v=$model->find($id);
        $builder = new \Common\Builder\FormBuilder();
        $builder->setMetaTitle($title)  // 设置页面标题
                ->setPostUrl($PostUrl)    // 设置表单提交地址
                ->addFormItem('id', 'hidden', 'ID', 'ID')
                ->addFormItem('uid', 'text', '绑定的用户id', '平台用户id')
                ->addFormItem('nickname', 'text', '微信号', '微信号')
                ->setExtraHtml($this->extra_html)
                ->setFormData($v)
                ->display();
    }


	/**
	 * 同步用户
	 */
    public function syc_user() {
    	$wechat	=	get_wecha_model(); // 获取wechat模型
    	$user_list	=	$wechat->getUserList(); //获取所有的关注用户openid
    	/* 获取本地数据 */
    	$map['token']	=	get_token();
    	$userbind_model	=	D('UserBind');
    	$old_user_list	=	$userbind_model->where($map)->select();
    	foreach ( $old_user_list as $g ) {
    		$groups [$g ['openid']] = $g;
    	}
    	/* 检测有新的数据 入库 */
    	foreach ($user_list['data']['openid'] as $v){
    		if(empty($groups[$v])){
    			$user_data	=	$weObj->getUserInfo($v);
    			$user_data['token']	=	$token;
    			if($userbind_model->create($user_data)){
    				$userbind_model->add();
    			}
    		}
    	    		
    	}

    	$this->success('同步微信服务器成功！');
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
