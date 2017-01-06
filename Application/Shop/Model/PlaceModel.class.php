<?php
// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace Shop\Model;
use Think\Model;
use \Common\Util\Tree;
/**
 * 导航模型
 * @author jry <598821125@qq.com>
 */
class PlaceModel extends Model {
    /**
     * 数据库表名
     * @author jry <598821125@qq.com>
     */
    protected $tableName = 'shop_place';

    /**
     * 自动验证规则
     * @author jry <598821125@qq.com>
     */
    protected $_validate = array(
        array('title', 'require', '标题不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );

    /**
     * 自动完成规则
     * @author jry <598821125@qq.com>
     */
    protected $_auto = array(
        array('create_time', 'time', self::MODEL_INSERT, 'function'),
        array('update_time', 'time', self::MODEL_BOTH, 'function'),
        array('status', '1', self::MODEL_INSERT),
    );

    /**
     * 栏目分组
     * @author jry <598821125@qq.com>
     */
    public function place_list() {
    	return parse_attr(C('shop_config.place_list'));
    }
    
    /**
     * 栏目分组
     * @author jry <598821125@qq.com>
     */
    public function sell_list() {
    	return parse_attr(C('shop_config.sell_list'));
    }

    /**
     * 导航类型
     * @author jry <598821125@qq.com>
     */
    public function link_type($id) {
        $group_list	=	parse_attr(C('shop_config.place_list'));
    	return $id ? $group_list[$id] : $group_list;
    }
    
    /**
     * 导航类型
     * @author jry <598821125@qq.com>
     */
    public function get_type_name($id) {
    	return $this->getFieldByid($id,'title');
    }
    
    //获取中国省份信息
    public function getplace() {
    	if (IS_AJAX) {
    		$pid = I('pid');  //默认的省份id
    		$map['status'] = array('egt', '0');
    
    		$list = $this->where($map)->order('id ASC')->select();
    		$data = "<option value =''>选择国家</option>";
    		foreach ($list as $k => $vo) {
    			$data .= "<option ";
    			if ($pid == $vo['id']) {
    				$data .= " selected ";
    			}
    			$data .= " value ='" . $vo['id'] . "'>";
    			if($vo['pid'] != 0){
    				$data .= '&nbsp;&nbsp;|-';
    			}
    			$data .= $vo['title'] . "</option>";
    		}
    		return $data;
    	}
    }

    /**
     * 根据导航类型获取值
     * @author jry <598821125@qq.com>
     */
    public function get_value_by_type($value) {
        if (!$value) {
            switch (I('post.type')) {
                case 'link':
                    return I('post.url');
                    break;
                case 'module':
                    return I('post.module_name');
                    break;
                case 'page':
                    return I('post.content');
                    break;
            }
        } else {
            return $value;
        }
    }

    /**
     * 获取参数的所有父级导航
     * @param int $id 导航id
     * @return array 参数导航和父类的信息集合
     * @author jry <598821125@qq.com>
     */
    public function getParentNav($id, $group = 'main') {
        if (empty($id)) {
            return false;
        }
        $con['status'] = 1;
        $con['group']  = array('eq', $group);
        $nav_list = $this->where($con)->field(true)->order('sort asc,id asc')->select();
        $current_nav = $this->field(true)->find($cid); //获取当前导航的信息
        $result[] = $current_nav;
        $pid = $current_nav['pid'];
        while (true) {
            foreach ($nav_list as $key => $val) {
                if ($val['id'] == $pid) {
                    $pid = $val['pid'];
                    array_unshift($result, $val); //将父导航插入到第一个元素前
                }
            }
            // 已找到顶级导航或者没有任何父导航
            if ($pid == 0 || count($result) == 1) {
                break;
            }
        }
        return $result;
    }

    /**
     * 获取导航树，指定导航则返回指定导航的子导航树，不指定则返回所有导航树，指定导航若无子导航则返回同级导航
     * @param  integer $id    导航ID
     * @param  boolean $field 查询字段
     * @return array          导航树
     * @author jry <598821125@qq.com>
     */
    public function getNavTree($id = 0, $group = 'main', $field = true) {
        // 获取当前导航信息
        if ((int)$id > 0) {
            $info = $this->find($id);
            $id   = $info['id'];
        }
        // 获取所有导航
        $map['status'] = array('eq', 1);
        $map['group']  = array('eq', $group);
        $tree = new Tree();
        $list = $this->field($field)->where($map)->order('sort asc,id asc')->select();

        // 返回当前导航的子导航树
        $list = $tree->list_to_tree(
            $list,
            $pk = 'id',
            $pid = 'pid',
            $child = '_child',
            $root = (int)$id
        );
        if (!$list) {
            return $this->getSameLevelNavTree($id);
        }
        return $list;
    }

    /**
     * 获取同级导航树
     * @param  integer $id 导航ID
     * @return array       导航树
     * @author jry <598821125@qq.com>
     */
    public function getSameLevelNavTree($id = 0, $group = 'main') {
        //获取当前导航信息
        if ((int)$id > 0) {
            $nav_info    = $this->find($id);
            $parent_info = $this->find($nav_info['pid']);
            $id   = $info['id'];
        }
        //获取所有导航
        $map['status'] = array('eq', 1);
        $map['group']  = array('eq', $group);
        $map['pid']    = array('eq', $nav_info['pid']);
        $tree = new Tree();
        $list = $this->field($field)->where($map)->order('sort asc,id asc')->select();
        return $list;
    }
}
