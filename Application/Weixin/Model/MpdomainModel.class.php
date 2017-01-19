<?php
// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------
namespace Weixin\Model;
use Think\Model;
/**
 * 公众号模型
 * @author jry <598821125@qq.com>
 */
class MpdomainModel extends Model {
    /**
     * 数据库真实表名
     * 一般为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     * @author jry <598821125@qq.com>
     */
    protected $tableName = 'mpdomain';

    /**
     * 自动验证规则
     * @author jry <598821125@qq.com>
     */
    protected $_validate = array(
        array('url', 'require', '域名不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('ismobpc', 'require', '请选择:移动端/pc端', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH)
    );

    /**
     * 自动完成规则
     * @author jry <598821125@qq.com>
     */
    protected $_auto = array(
        array('status', '1', self::MODEL_INSERT),
    );
}