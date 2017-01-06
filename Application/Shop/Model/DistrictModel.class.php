<?php

namespace Shop\Model;

use Think\Model;

class DistrictModel extends Model {
	/**
	 * 数据库表名
	 * @author jry <598821125@qq.com>
	 */
	protected $tableName = 'district';

    //获取中国省份信息
    public function getProvince() {
        if (IS_AJAX) {
            $pid = I('pid');  //默认的省份id
            $map['level'] = 1;
            $map['upid'] = 0;

            $list = $this->where($map)->order('id ASC')->select();
            $data = "<option value =''>选择省份</option>";
            foreach ($list as $k => $vo) {
                $data .= "<option ";
                if ($pid == $vo['id']) {
                    $data .= " selected ";
                }
                $data .= " value ='" . $vo['id'] . "'>" . $vo['name'] . "</option>";
            }
            return $data;
        }
    }

    //获取城市信息
    public function getCity() {
        if (IS_AJAX) {
            $cid = I('cid');  //默认的城市id
            $pid = I('pid');  //传过来的省份id

            $map['level'] = 2;
            $map['upid'] = $pid;

            $list = $this->where($map)->order('id ASC')->select();

            $data = "<option value =''>选择城市</option>";
            foreach ($list as $k => $vo) {
                $data .= "<option ";
                if ($cid == $vo['id']) {
                    $data .= " selected ";
                }
                $data .= " value ='" . $vo['id'] . "'>" . $vo['name'] . "</option>";
            }
            return $data;
        }
    }

    //获取区县市信息
    public function getDistrict() {
        if (IS_AJAX) {
            $did = I('did');  //默认的城市id
            $cid = I('cid');  //传过来的城市id

            $map['level'] = 3;
            $map['pid'] = $cid;

            $list = $this->where($map)->order('id ASC')->select();
            $data = "<option value =''>-区/县-</option>";
            foreach ($list as $k => $vo) {
                $data .= "<option ";
                if ($did == $vo['id']) {
                    $data .= " selected ";
                }
                $data .= " value ='" . $vo['id'] . "'>" . $vo['title'] . "</option>";
            }
            return $data;
        }
    }

    //获取乡镇信息
    public function getCommunity() {
        if (IS_AJAX) {
            $coid = I('coid');  //默认的乡镇id
            $did = I('did');  //传过来的区县市id

            $where['city_id'] = $cid;

            if (!empty($coid)) {
                $map['id'] = $coid;
            }
            $map['level'] = 4;
            $map['pid'] = $did;

            $list = $this->where($map)->order('id ASC')->select();

            $data = "<option value =''>-镇街道-</option>";
            foreach ($list as $k => $vo) {
                $data .= "<option ";
                if ($did == $vo['id']) {
                    $data .= " selected ";
                }
                $data .= " value ='" . $vo['id'] . "'>" . $vo['title'] . "</option>";
            }
            return $data;
        }
    }

    function htweizhi($id = "", $str = "/") {

        $weizhiArray = $this->find($id);
        $weizhistr = $weizhiArray['title'];
        if ($weizhiArray["pid"] != 0) {

            $weizhistr = $this->htweizhi($weizhiArray["pid"], $str) . $str . $weizhistr;
        }
        return $weizhistr;
    }

    function getid($id) {
    	//print_r($id);exit;
       $idarray =  $this->find($id);
       if($idarray["level"]==3)
       {
           $did["id"] = $id;
           $did["cid"] = $idarray["pid"];
           $pidarray =  $this->find($did["cid"]);
           $did["pid"] = $pidarray["pid"];
       }
       return $did;
    }

}
