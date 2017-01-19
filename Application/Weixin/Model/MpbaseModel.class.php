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
class MpbaseModel extends Model {

    /**
     * 数据库真实表名
     * 一般为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     * @author jry <598821125@qq.com>
     */
    protected $tableName = 'mpbase';

    /**
     * 自动验证规则
     * @author jry <598821125@qq.com>
     */
    protected $_validate = array(
        array('public_name', 'require', '公众号名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('wechat', 'require', '微信号不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('public_id', 'require', '原始ID不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    );

    /**
     * 自动完成规则
     * @author jry <598821125@qq.com>
     */
    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
        array('status', '1', self::MODEL_INSERT),
    	array('uid', 'is_login', self::MODEL_INSERT,'function'),
    );

}
