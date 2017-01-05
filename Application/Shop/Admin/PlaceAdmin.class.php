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
class PlaceAdmin extends AdminController {
	/**
	 * 默认方法
	 *
	 */
	public function index($group=2) {
		//搜索
        $keyword = I('keyword', '', 'string');
        $condition = array('like','%'.$keyword.'%');
        $map['id|title'] = array(
            $condition,
            '_multi'=>true
        );

        // 获取所有分类
        $map['status'] = array('egt', '0');
//         $map['group']	=	$group;
        $data_list = D('Place')
                   ->where($map)
                   ->order('sort asc,id asc')
                   ->select();

        // 转换成树状列表
        $tree = new Tree();
        $data_list = $tree->toFormatTree($data_list);
//         P($data_list);exit;
        
        // 设置Tab导航数据列表
        $category_group_list = D('place')->place_list();  // 获取分类分组
        foreach ($category_group_list as $key => $val) {
        	$tab_list[$key]['title'] = $val;
        	$tab_list[$key]['href']  = U('index', array('group' => $key));
        }
        unset($tab_list[1]);
//         P($tab_list);exit;
        
        // 使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('地区列表') // 设置页面标题
                ->addTopButton('addnew', array('href' => U('add')))  // 添加新增按钮
                ->addTopButton('resume')  // 添加启用按钮
                ->addTopButton('forbid')  // 添加禁用按钮
                ->addTopButton('delete')  // 添加删除按钮
                ->setSearch('请输入名称', U('index'))
                ->setTabNav($tab_list, $group)  // 设置页面Tab导航
                ->addTableColumn('id', 'ID')
                ->addTableColumn('title_show', '名称')
                ->addTableColumn('status', '状态', 'status')
                ->addTableColumn('right_button', '操作', 'btn')
                ->setTableDataList($data_list)  // 数据列表
                ->addRightButton('edit', array('href' => U('edit', array( 'id' => '__data_id__'))))  // 添加编辑按钮
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
            $type_object = D('Place');
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
            // 使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('新增产品')  // 设置页面标题
                    ->setPostUrl(U(''))     // 设置表单提交地址
                    ->addFormItem('pid', 'select', '上级地区', '上级地区', select_list_as_tree('place','','顶级地区'))
                    ->addFormItem('title', 'text', '地区名称', '前台显示地区名称')
                    ->addFormItem('level', 'num', '层级关系','如 "美国" 请填 1 "美国加州" 请填 2')
                    ->addFormItem('sort', 'num', '排序', '用于显示的顺序')
                    ->display();
        }
    }

    /**
     * 编辑分类
     * @author jry <598821125@qq.com>
     */
    public function edit($id) {
        if (IS_POST) {
            $type_object = D('Place');
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
            $info = D('Place')->find($id);
            
            // 使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('编辑产品')  // 设置页面标题
            ->setPostUrl(U(''))     // 设置表单提交地址
            ->addFormItem('id', 'hidden', 'ID', 'ID')
            ->addFormItem('pid', 'select', '上级地区', '上级地区', select_list_as_tree('place','','顶级地区'))
            ->addFormItem('title', 'text', '地区名称', '前台显示地区名称')
            ->addFormItem('level', 'num', '层级关系','如 "美国" 请填 1 "美国加州" 请填 2')
            ->addFormItem('sort', 'num', '排序', '用于显示的顺序')
            ->setFormData($info)
            ->display();
        }
    }
}
