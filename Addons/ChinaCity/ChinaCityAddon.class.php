<?php
// +----------------------------------------------------------------------
// | i友街 [ 新生代贵州网购社区 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.iyo9.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: i友街 <iyo9@iyo9.com> <http://www.iyo9.com>
// +----------------------------------------------------------------------
// 
namespace Addons\ChinaCity;
use Addons\ChinaCity\Controller\ChinaCityController;
use Common\Controller\Addon;
use Addons\ChinaCity\Controller\ChinaCityController as Region;

/**
 * 中国省市区三级联动插件
 * @author i友街
 */

    class ChinaCityAddon extends Addon{

        public $info = array(
            'name'=>'ChinaCity',
            'title'=>'中国省市区三级联动',
            'description'=>'每个系统都需要的一个中国省市区三级联动插件。',
            'status'=>1,
            'author'=>'i友街',
            'version'=>'2.0'
        );

        public function install(){

            /* 先判断插件需要的钩子是否存在 */
            D('Admin/Hook')->existHook('J_China_City',$this->info);
            //读取插件sql文件
            $sqldata = file_get_contents(C('ADDON_PATH').$this->info['name'].'/install.sql');
//             P($sqldata);exit;
            $sqlFormat = $this->sql_split($sqldata, C('DB_PREFIX'));
            $counts = count($sqlFormat);
            
            for ($i = 0; $i < $counts; $i++) {
                $sql = trim($sqlFormat[$i]);
                D()->execute($sql);
            }
            return true;
        }

        public function uninstall(){
            //读取插件sql文件
            $sqldata = file_get_contents(C('ADDON_PATH').$this->info['name'].'/uninstall.sql');
            $sqlFormat = $this->sql_split($sqldata, C('DB_PREFIX'));
            $counts = count($sqlFormat);
             
            for ($i = 0; $i < $counts; $i++) {
                $sql = trim($sqlFormat[$i]);
                D()->execute($sql);
            }

            //清除钩子
            $hook = D('Admin/Hook')->where(array('name'=>'J_China_City'))->find();
            if($hook){
                D('Admin/Hook')->where(array('name'=>'J_China_City'))->delete();
            }


            return true;
        }

        /**
         * @param $param  default  array('province'=>0,'city'=>0,'district'=>0,'community'=>0)
         */
        public function J_China_City($param){

            empty($param['province']) ? $province =0 : $province = $param['province'];
            empty($param['city']) ? $city =0 : $city = $param['city'];
            empty($param['district']) ? $district =0 : $district = $param['district'];
            empty($param['community']) ? $community =0 : $community = $param['community'];
            
            trace('写入信息','用户信息','debug');
            
            $region = new ChinaCityController();

            $data = $region->loadArea($province, $city, $district, $community);

            $this->assign('region', $data);
            $this->display('chinacity');
        }

        /**
         * 解析数据库语句函数
         * @param string $sql  sql语句   带默认前缀的
         * @param string $tablepre  自己的前缀
         * @return multitype:string 返回最终需要的sql语句
         */
        public function sql_split($sql, $tablepre) {

            if ($tablepre != "onethink_")
                $sql = str_replace("onethink_", $tablepre, $sql);
                $sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=utf8", $sql);

            if ($r_tablepre != $s_tablepre)
                $sql = str_replace($s_tablepre, $r_tablepre, $sql);
                $sql = str_replace("\r", "\n", $sql);
                $ret = array();

                $num = 0;
                $queriesarray = explode(";\n", trim($sql));
                unset($sql);

            foreach ($queriesarray as $query) {
                $ret[$num] = '';
                $queries = explode("\n", trim($query));
                $queries = array_filter($queries);
                foreach ($queries as $query) {
                    $str1 = substr($query, 0, 1);
                    if ($str1 != '#' && $str1 != '-')
                        $ret[$num] .= $query;
                }
                $num++;
            }
            return $ret;
        }
    }