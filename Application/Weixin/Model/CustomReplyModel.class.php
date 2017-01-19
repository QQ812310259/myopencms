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
class CustomReplyModel extends Model {

    /**
     * 数据库真实表名
     * 一般为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     * @author jry <598821125@qq.com>
     */
    protected $tableName = 'weixin_custom_reply';

    /**
     * 自动验证规则
     * @author jry <598821125@qq.com>
     */
    protected $_validate = array(
        array('keyword', 'require', '关键词不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
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

    public function weixin($params) {
        $data = $params['weObj']->getRevData();
        $map['token'] = $params["mpid"];
        if (!empty($params['key'])) {
            $map['keyword'] = $params['key'];
        } else {
            $map['keyword'] = $data['Content'];
        }
        $map['status'] = 1;

        $info = $this->where($map)->find();
        if ($info) {
            if ($info["reply_type"] == "text") {
                $params["weObj"]->text($info["content"])->reply();
            } elseif ($info["reply_type"] == "materialnews") {
                $params["group_id"] = $info["reply_key"];
                D("Materialnews")->replyMsg($params);
            }
        } else {

            //没匹配到关键词转到官方多客服  http://dkf.qq.com/，避免出现“该公众号暂时无法提供服务，请稍候再试”的提示
            $params['weObj']->transfer_customer_service();
        }
    }

}
