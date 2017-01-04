<?php
/**
 * Created by PhpStorm.
 * User: Jess
 * Github: https://github.com/jessppp
 */

namespace Shop\Admin;
use Admin\Controller\AdminController;
use Common\Util\Tree;
/**
 * 默认控制器
 *
 */
class ProductAdmin extends AdminController {
	// 文档类型切换触发操作JS
	private $extra_html = <<<EOF
        <script type="text/javascript">
            //选择模型时页面元素改变
            $(function() {
                $('input[name="placetype"]').change(function() {
                    var model_id = $(this).val();
                    if (model_id == 1) { //超链接
                        $('.item_origin_gn').removeClass('hidden');
                        $('.item_origin_gw').addClass('hidden');
                    } else if (model_id == 2) { //单页文档
                        $('.item_origin_gw').removeClass('hidden');
                        $('.item_origin_gn').addClass('hidden');
                    }else {
                        $('.item_origin_gw').removeClass('hidden');
                        $('.item_origin_gn').addClass('hidden');
                    }
                });
            });
        </script>
EOF;
	/**
	 * 默认方法
	 *
	 */
	public function index($group = 1) {
		//搜索
        $keyword = I('keyword', '', 'string');
        $condition = array('like','%'.$keyword.'%');
        $map['id|title'] = array(
            $condition,
            '_multi'=>true
        );

        // 获取所有分类
        $map['status'] = array('egt', '0');
        $map['group']	=	$group;
        $data_list = D('product')
                   ->where($map)
                   ->order('sort asc, id asc')
                   ->select();

        // 转换成树状列表
        $tree = new Tree();
        $data_list = $tree->toFormatTree($data_list);
        
        // 设置Tab导航数据列表
        $category_group_list = D('type')->group_list();  // 获取分类分组
        foreach ($category_group_list as $key => $val) {
        	$tab_list[$key]['title'] = $val;
        	$tab_list[$key]['href']  = U('index', array('group' => $key));
        }
//         P(D('type')->group_list());exit;
        
        // 使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('产品列表') // 设置页面标题
                ->addTopButton('addnew', array('href' => U('add', array('group' => $group))))  // 添加新增按钮
                ->addTopButton('resume')  // 添加启用按钮
                ->addTopButton('forbid')  // 添加禁用按钮
                ->addTopButton('delete')  // 添加删除按钮
                ->setSearch('请输入名称', U('index', array('group' => $group)))
                ->setTabNav($tab_list, $group)  // 设置页面Tab导航
                ->addTableColumn('id', 'ID')
                ->addTableColumn('title_show', '名称')
                ->addTableColumn('pic', '图片', 'picture')
                ->addTableColumn('type', '类型', 'callback', array(D('type'), 'get_type_name'))
                ->addTableColumn('sn', '厂号')
                ->addTableColumn('price', '价格(元)')
                ->addTableColumn('sort', '排序')
                ->addTableColumn('status', '状态', 'status')
                ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list)  // 数据列表
                ->addRightButton('edit', array('href' => U('edit', array('group' => $group, 'id' => '__data_id__'))))  // 添加编辑按钮
                ->addRightButton('forbid')      // 添加禁用/启用按钮
                ->addRightButton('delete')      // 添加删除按钮
                ->display();
	}

	/**
     * 新增分类
     * @author jry <598821125@qq.com>
     */
    public function add() {
        if (IS_POST) {
        	$_POST['place']	=	chack_array($_POST['place']);  // 获取地址id
        	/* 获取产地分类 */
        	switch ($_POST['placetype']){
        		case 1:
        			$_POST['origin']	=	chack_array($_POST['origin_gn']);  // 获取地址id
        			break;
        		case 2:
        			$_POST['origin']	=	$_POST['origin_gw'];  // 获取地址id
        			break;
        	}
            $type_object = D('product');
            $data = $type_object->create();
            if ($data) {
                $id = $type_object->add($data);
                if ($id) {
                    $this->success('新增成功', U('index', array('group' => $group)));
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($type_object->getError());
            }
        } else {
        	$gw_class	=	'hidden';
            // 使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('新增产品')  // 设置页面标题
                    ->setPostUrl(U(''))     // 设置表单提交地址
                    ->addFormItem('type', 'select', '产品分类', '产品分类', select_list_as_tree('type'))
                    ->addFormItem('title', 'text', '产品名称', '前台显示产品名称')
                    ->addFormItem('pic', 'picture', '图片')
                    ->addFormItem('sn', 'text', '厂号')
                    ->addFormItem('place', 'chinacity', '冷库地址', '冷库地址')
                    ->addFormItem('placetype', 'radio', '产地分类', '', D('place')->place_list())
                    ->addFormItem('origin_gn', 'chinacity', '国内产地','','',$gn_class)
                    ->addFormItem('origin_gw', 'select', '国外产地','',select_list_as_tree('place'),$gw_class)
                    ->addFormItem('price', 'price', '价格')
                    ->addFormItem('sell', 'radio', '出售方式', '出售方式', D('type')->sell_list())
                    ->addFormItem('sort', 'num', '排序', '用于显示的顺序')
                    ->setAjaxSubmit(false)
                    ->setExtraHtml($this->extra_html)
                    ->display();
        }
    }

    /**
     * 编辑分类
     * @author jry <598821125@qq.com>
     */
    public function edit($id) {
        if (IS_POST) {
        	$_POST['place']	=	chack_array($_POST['place']);  // 获取地址id
        	/* 获取产地分类 */
        	switch ($_POST['placetype']){
        		case 1:
        			$_POST['origin']	=	chack_array($_POST['origin_gn']);  // 获取地址id
        			break;
        		case 2:
        			$_POST['origin']	=	$_POST['origin_gw'];  // 获取地址id
        			break;
        	}
//         	P($_POST);exit;
            $type_object = D('product');
            $data = $type_object->create();
            if ($data) {
                if ($type_object->save($data)) {
                    $this->success('更新成功', U('index', array('group' => $group)));
                } else {
                    $this->error('更新失败');
                }
            } else {
                $this->error($type_object->getError());
            }
        } else {
            $info = D('product')->find($id);
            
            /* 获取产地分类 */
            switch ($info['placetype']){
            	case 1:
            		$info['origin_gn']	=	$info['origin'];  // 获取地址id
            		$gw_class	=	'hidden';
            		break;
            	case 2:
            		$info['origin_gw']	=	$info['origin'];  // 获取地址id
            		$gn_class	=	'hidden';
            		break;
            }
            
            // 使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('编辑产品')  // 设置页面标题
            ->setPostUrl(U(''))     // 设置表单提交地址
            ->addFormItem('id', 'hidden', 'ID', 'ID')
            ->addFormItem('type', 'select', '产品分类', '产品分类', select_list_as_tree('type'))
            ->addFormItem('title', 'text', '产品名称', '前台显示产品名称')
            ->addFormItem('pic', 'picture', '图片')
            ->addFormItem('sn', 'text', '厂号')
            ->addFormItem('place', 'chinacity', '冷库地址', '冷库地址')
            ->addFormItem('placetype', 'radio', '产地分类', '', D('place')->place_list())
            ->addFormItem('origin_gn', 'chinacity', '国内产地','','',$gn_class)
            ->addFormItem('origin_gw', 'select', '国外产地','',select_list_as_tree('place'),$gw_class)
            ->addFormItem('price', 'price', '价格')
            ->addFormItem('sell', 'radio', '出售方式', '出售方式', D('type')->sell_list())
            ->addFormItem('sort', 'num', '排序', '用于显示的顺序')
            ->setFormData($info)
            ->setExtraHtml($this->extra_html)
            ->setAjaxSubmit(false)
            ->display();
        }
    }
}
