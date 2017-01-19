<?php

// +----------------------------------------------------------------------
// | wei51 [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.wei51.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: wei51.com
// +----------------------------------------------------------------------

namespace Weixin\Model;

use Think\Model;

/**
 * 公众号模型
 * @author jry <598821125@qq.com>
 */
class MaterialnewsModel extends Model {

    /**
     * 数据库真实表名
     * 一般为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     * @author wei51
     */
    protected $tableName = 'weixin_materialnews';

    function replyMsg($params) {
        $map_news ['group_id'] = $params ['group_id'];
        $map_news ['token'] = $params["mpid"];
        $data = $params['weObj']->getRevData();
        $nameinfo = $params['weObj']->getUserInfo($params['oid']);
        
        $list = $this->where($map_news)->select();

        foreach ($list as $k => $vo) {
            if ($k > 10)
                continue;

            if (empty($vo ['url'])) {
                $url = $this->_getNewsUrl($vo, $params);
            } else {
                $url = $vo ['url'];
            }
            $PicUrl = get_cover_url($vo['cover_id']);

            if (!empty($data)) {
                if (strstr($vo ['title'], "{name}")) {
                    $vo ['title'] = str_replace("{name}", $nameinfo['nickname'], $vo ['title']);
                }
                if (strstr($vo ['title'], "{head}")) {
                    $vo ['title'] = str_replace("{head}", "", $vo ['title']);
                    $PicUrl = $nameinfo['headimgurl'];
                }
                if (strstr($url, "samcmswxuser")) {
                    $url = str_replace("samcmswxuser", "oid=" . $data ['FromUserName'] . "&headimgurl=" . urlencode($nameinfo['headimgurl']) . "&nickname=" . $nameinfo['nickname'], $url);
                }
            }

            $articles [] = array(
                'Title' => $vo ['title'],
                'Description' => $vo ['intro'],
                'PicUrl' => $PicUrl,
                'Url' => $url
            );
        }
        $res = $params['weObj']->news($articles)->reply();
    }

    function _getNewsUrl($info, $param) {
        if (!empty($info ['link'])) {
            $url = $info ['link'];
        } else {
            $param ['id'] = $info ['id'];
            $url = U('Home/Material/news_detail', $param);
        }
        return $url;
    }

}
