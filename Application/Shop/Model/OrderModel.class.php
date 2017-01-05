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
class OrderModel extends Model {
    /**
     * 数据库表名
     * @author jry <598821125@qq.com>
     */
    protected $tableName = 'shop_order';

    /**
     * 自动验证规则
     * @author jry <598821125@qq.com>
     */
    protected $_validate = array(
        array('sn', 'require', '订单号不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
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
    public function group_list() {
    	return parse_attr(C('shop_config.group_list'));
    }
    
    /**
     * 导航类型
     * @author jry <598821125@qq.com>
     */
    public function link_type($id) {
        $group_list	=	parse_attr(C('shop_config.group_list'));
    	return $id ? $group_list[$id] : $group_list;
    }
    
    /**
     * 导航类型
     * @author jry <598821125@qq.com>
     */
    public function get_type_name($id) {
    	return $this->getFieldByid($id,'title');
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
}
