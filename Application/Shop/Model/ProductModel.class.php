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
class ProductModel extends Model {
    /**
     * 数据库表名
     * @author jry <598821125@qq.com>
     */
    protected $tableName = 'shop_product';

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
     * 查找后置操作
     * @author jry <598821125@qq.com>
     */
    protected function _after_find(&$result, $options) {
//     	P($result);exit;
    }
    
    /**
     * 查找后置操作
     * @author jry <598821125@qq.com>
     */
    protected function _after_select(&$result, $options) {
    	foreach($result as &$record){
    		$this->_after_find($record, $options);
    	}
    }
    /**
     * 整理数据
     */
    public function get_list_order(&$array){
    	foreach($array as &$record){
    		$this->_get_list_data($record);
    	}
    }
/**
     * 查找后置操作
     * @author jry <598821125@qq.com>
     */
    public function _get_list_data(&$result) {
//     	P($result);exit;
    	if ($result['pic']) {
    		$result['pic_url'] = get_cover($result['pic'], 'default');
    	}
    	if ($result['type']) {
    		$result['type'] = D('type')->get_type_name($result['type']);
    	}
    	if ($result['group']) {
    		$result['group'] = D('type')->link_type($result['group']);
    	}
    	/* 产地 */
    	if ($result['origin']) {
	    	switch ($result['placetype']) {
		    case 1:
		    	/* 国内 */
		        $result['origin'] = M('district')->getFieldbyid($result['origin'],'name');
		        break;
		    case 2:
		        $result['origin'] = D('place')->get_type_name($result['origin']);
		        break;
			}
    	}
    	if ($result['place']) {
    		$result['place'] = M('district')->getFieldbyid($result['place'],'name');
    	}
    	if ($result['placetype']) {
    		$result['placetype'] = D('place')->link_type($result['placetype']);
    	}
    	if ($result['sell']) {
    		$result['sell'] = D('type')->sell_type($result['sell']);
    	}
    }
    
    
    
    
    
    
    
    
    
    

    
}
