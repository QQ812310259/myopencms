<?php

// +----------------------------------------------------------------------
// | wei51 [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.wei51.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: wei51.com
// +----------------------------------------------------------------------

namespace Weixin\Admin;

use Admin\Controller\AdminController;
use Common\Util\Think\Page;

/**
 * 素材控制器
 * @author wei51.com
 */
class MaterialnewsAdmin extends AdminController {

    /**
     * 素材列表
     * @author wei51.com
     */
    public function index() {
        $list = $this->getlist();
        $this->assign("list", $list);
        $this->display();
    }

    public function windowslist() {
        $list = $this->getlist();
        $this->assign("list", $list);
        $this->display();
    }

    function getlist() {
        $model = M('weixin_materialnews');
        //$map['status'] = array('egt', '0'); //禁用和正常状态
        $map['isfirst'] = 1; //禁用和正常状态
        $map['token'] = intval(session('mpid'));
        $p = I('p', 1, 'intval'); // 默认显示第一页数据
        $list = $model
                ->page($p, C('ADMIN_PAGE_ROWS'))
                ->where($map)
                ->order('id desc')
                ->select();

        $page = new Page(
                $model->where($map)->count(), C('ADMIN_PAGE_ROWS')
        );

        foreach ($list as &$vo) {
            if ($vo ['count'] == 1)
                continue;

            $map2 ['group_id'] = $vo ['group_id'];
            $map2 ['id'] = array(
                'exp',
                '!=' . $vo ['id']
            );

            $vo ['child'] = $model->where($map2)->select();
        }

        $this->assign('add_url', U('add'));
        $this->assign("page", $page->show());

        return $list;
    }

    public function add() {
        $map ['group_id'] = I('group_id', 0, 'intval');
        if (!empty($map ['group_id'])) {
            $list = M('weixin_materialnews')->where($map)->order('id asc')->select();
            $count = count($list);

            $main = $list [0];
            unset($list [0]);
            if (!empty($list)) {
                $others = $list;
            }

            $this->assign('main', $main);
            $this->assign('others', $others);
        }

        $this->assign('post_url', U('doAdd', $map));
        $this->display();
    }

    public function doAdd() {
        $textArr = array(
            1 => '一',
            2 => '二',
            3 => '三',
            4 => '四',
            5 => '五',
            6 => '六',
            7 => '七',
            8 => '八',
            9 => '九',
            10 => '十'
        );
        $data = json_decode($_POST ['dataStr'], true);
        //dump ( $_POST );
        //dump ( $data );
        //exit ();

        $ids = array();
        foreach ($data as $key => $vo) {
            $save = array();
            foreach ($vo as $k => $v) {
                $save [$v ['name']] = safe($v ['value']);
            }
            if (empty($save ['title'])) {
                $this->error('请填写第' . $textArr [$key + 1] . '篇文章的标题');
            }
            if (empty($save ['cover_id'])) {
                $this->error('请上传第' . $textArr [$key + 1] . '篇文章的封面图片');
            }
            if (empty($save ['content'])) {
                $this->error('请填写第' . $textArr [$key + 1] . '篇文章的正文内容');
            }
            if (!empty($save ['id'])) { // 更新数据
                $map2 ['id'] = $save ['id'];
                M('weixin_materialnews')->where($map2)->save($save);
                //echo M('weixin_materialnews')->getLastSql();
            } else { // 新增加
                $save ['cTime'] = NOW_TIME;
                $save ['token'] = get_token();
                if ($key == 0) {
                    $save ['isfirst'] = 1;
                }
                $id = M('weixin_materialnews')->add($save);
                if ($id) {
                    $ids [] = $id;
                } else {
                    if (!empty($ids)) {
                        $map ['id'] = array(
                            'in',
                            $ids
                        );
                        M('weixin_materialnews')->where($map)->delete();
                        //echo M('weixin_materialnews')->getLastSql();
                    }
                    $this->error('增加第' . $textArr [$key + 1] . '篇文章失败，请检查数据后重试');
                }
            }
        }
        if (!empty($ids)) {
            $map ['id'] = array(
                'in',
                $ids
            );
            $group_id = I('get.group_id', 0, 'intval');
            empty($group_id) && $group_id = $ids [0];
            M('weixin_materialnews')->where($map)->setField('group_id', $group_id);
        }

        $this->success('操作成功', U('index'));
    }
    
    
	/**
	 * 输出素材信息
	 */
    function getdetailajax() {
        $map ['group_id'] = I('group_id', 0, 'intval');
        if (!empty($map ['group_id'])) {
            $list = M('weixin_materialnews')->where($map)->order('id asc')->select();
            $count = count($list);

            $main = $list [0];
            unset($list [0]);
            if (!empty($list)) {
                $others = $list;
            }

            $this->assign('main', $main);
            $this->assign('others', $others);
        }       
        $this->display();
        exit;
    }

    function del_material_by_id() {
        $map ['id'] = I('id');
        echo M('weixin_materialnews')->where($map)->delete();
    }

    function del_material_by_groupid() {
        $map ['group_id'] = I('group_id');
        $map ['token'] = get_token();
        $res = M('weixin_materialnews')->where($map)->delete();
        if ($res) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

}
