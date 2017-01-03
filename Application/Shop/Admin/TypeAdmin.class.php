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
class TypeAdmin extends AdminController {
	/**
	 * 默认方法
	 *
	 */
	public function index() {
		//搜索
        $keyword = I('keyword', '', 'string');
        $condition = array('like','%'.$keyword.'%');
        $map['id|title'] = array(
            $condition,
            '_multi'=>true
        );

        // 获取所有分类
        $map['status'] = array('egt', '0');
        $data_list = D('type')
                   ->where($map)
                   ->order('sort asc, id asc')
                   ->select();

        // 转换成树状列表
        $tree = new Tree();
        $data_list = $tree->toFormatTree($data_list);
        
//         P($map);exit;
        
        // 使用Builder快速建立列表页面。
        $builder = new \Common\Builder\ListBuilder();
        $builder->setMetaTitle('分类列表') // 设置页面标题
                ->addTopButton('addnew', array('href' => U('add', array('group' => $group))))  // 添加新增按钮
                ->addTopButton('resume')  // 添加启用按钮
                ->addTopButton('forbid')  // 添加禁用按钮
                ->addTopButton('delete')  // 添加删除按钮
                ->setSearch('请输入分类名称', U('index', array('group' => $group)))
                ->addTableColumn('id', 'ID')
                ->addTableColumn('title_show', '标题')
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
            $type_object = D('type');
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
            $builder->setMetaTitle('新增分类')  // 设置页面标题
                    ->setPostUrl(U(''))     // 设置表单提交地址
                    ->addFormItem('pid', 'select', '上级分类', '上级分类', select_list_as_tree('type', '', '顶级分类'))
                    ->addFormItem('title', 'text', '分类标题', '分类前台显示标题')
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
            $type_object = D('type');
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
            $info = D('type')->find($id);

            // 使用FormBuilder快速建立表单页面。
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle('编辑分类')  // 设置页面标题
                    ->setPostUrl(U(''))     // 设置表单提交地址
                    ->addFormItem('pid', 'select', '上级分类', '上级分类', select_list_as_tree('type', '', '顶级分类'))
                    ->addFormItem('title', 'text', '分类标题', '分类前台显示标题')
                    ->addFormItem('sort', 'num', '排序', '用于显示的顺序')
                    ->setFormData($info)
                    ->display();
        }
    }
}
