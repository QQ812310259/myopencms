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
 * @author wei51
 */
class SubscribeModel extends Model {

    /**
     * 数据库真实表名
     * 一般为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     * @author wei51
     */
    protected $tableName = 'weixin_subscribe';

    /**
     * 自动验证规则
     * @author wei51
     */
    protected $_validate = array(
        array('reply_type', 'require', '回复类型不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
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

    // 关注时自动处理
    public function subscribe($params) {
        $info = $this->where(array('token' => $params["mpid"]))->find();
        if ($info["reply_type"] == "text") {
            $params["weObj"]->text($info["content"])->reply();
        }elseif($info["reply_type"] == "materialnews"){
            $params["group_id"] = $info["reply_key"];
            D("Materialnews")->replyMsg($params);
        }
    }

    /**
     * 自定义回复类型
     * @author jry <598821125@qq.com>
     */
    public function reply_type($id) {
        $list['text'] = '文本回复';
        $list['materialnews'] = '图文回复';
        $list['addon'] = '插件回复';
        return $id ? $list[$id] : $list;
    }

}
