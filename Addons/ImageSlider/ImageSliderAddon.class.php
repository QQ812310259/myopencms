<?php

namespace Addons\ImageSlider;
use Common\Controller\Addon;

/**
 * 图片轮播插件
 * @author birdy
 */

    class ImageSliderAddon extends Addon{

        public $info = array(
            'name'=>'ImageSlider',
            'title'=>'图片轮播',
            'description'=>'图片轮播 此插件移植于onethink插件，原地址http://www.topthink.com/topic/6244.html 如有侵权请原作者联系<1@lailin.xyz>下架',
            'status'=>1,
            'author'=>'莫回首 移植',
            'version'=>'1.0'
        );

        public function install(){
            /* 先判断插件需要的钩子是否存在 */
            D('Admin/Hook')->existHook($this->info['name'], $this->info['name'], $this->info['description']);
            return true;
        }

        public function uninstall(){
            //删除钩子
            D('Admin/Hook')->deleteHook($this->info['name']);
            return true;
        }
        
        //实现的ImageSlider钩子方法
        public function ImageSlider($param){
            $config = $this->getConfig();
            if($config['status']){
                $images = array();
                if($config['images']){
                    $images = M("public_upload")->field('id,path')->where("id in ({$config['images']})")->select();
                }
                $this->assign('urls', explode("\r\n",$config['url']));
                $this->assign('images', $images);
                $this->assign('config', $config);
                $this->display($config['type']);
            }
        }
    }