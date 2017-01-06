<?php
// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace Shop\Controller;
use Home\Controller\HomeController;
/**
 * 前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用模块名
 * @author jry <598821125@qq.com>
 */
class BaseController extends HomeController {
    /**
     * 初始化方法
     * @author jry <598821125@qq.com>
     */
    protected function _initialize() {
    	parent::_initialize();
    }
    
    function getProvince() {
    	$this->ajaxReturn(D("District")->getProvince());
    }
    
    function getCity() {
    	$this->ajaxReturn(D("District")->getCity());
    }
    
    function gettype() {
    	$this->ajaxReturn(D("type")->gettype());
    }
    function gettypes() {
    	$this->ajaxReturn(D("type")->gettypes());
    }
    function getplace() {
    	$this->ajaxReturn(D("place")->getplace());
    }
    
    
    
    
    
    
    
    

}
