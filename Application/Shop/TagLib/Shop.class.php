<?php
/**
 * Created by PhpStorm.
 * User: Jess
 * Github: https://github.com/jessppp
 */

namespace Shop\TagLib;
use Think\Template\TagLib;
/**
 * 标签库
 *
 */
class Shop extends TagLib {
    /**
     * 定义标签列表
     *
     */
    protected $tags = array(
        'list' => array('attr' => 'name', 'close' => 1),  //文档列表
    );

    /**
     * 文档列表
     *
     */
    public function _list($tag, $content) {
        $name   = $tag["name"];
        $parse  = '<?php ';
        $parse .= '$__Shop_LIST__ = D("Shop/Index")->select();';
        $parse .= ' ?>';
        $parse .= '<volist name="__Shop_LIST__" id="'. $name .'">';
        $parse .= $content;
        $parse .= '</volist>';
        return $parse;
    }
}


