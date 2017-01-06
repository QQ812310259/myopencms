<?php
// +----------------------------------------------------------------------
// | i友街 [ 新生代贵州网购社区 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.iyo9.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: i友街 <iyo9@iyo9.com> <http://www.iyo9.com>
// +----------------------------------------------------------------------
// 

/**
 * 中国省市区三级联动插件
 * @author i友街
 * @author ranmoon update 2016.5.8
 * @link http:www.ranmoon.love
 */

namespace Addons\ChinaCity\Controller;
use Admin\Controller\AddonController;

class ChinaCityController extends AddonController{

	/* 载入初始的值!!! */
	public function loadArea($province=0, $city=0, $district=0, $community=0){
// 		$province = 1;
// 		$city = 37;
// 		$district = 568;
		$data['province'] = M('district')->find($province);

		$data['city'] = M('district')->where(array('upid'=>$province,'id'=>$city))->find();

		$data['district'] = M('district')->where(array('upid'=>$city,'id'=>$district))->find();

		$data['community'] = M('district')->where(array('upid'=>$district,'id'=>$community))->find();

		$area = $this->getAreaList(0);

		$list  = array();
		$list['province'] = "<option value =''>-省份-</option>";
		foreach($area as $val){
			$list['province'] .= "<option value='".$val['id']."'";
			if($province == $val['id']) $list['province'].="selected=selected >";
			else  $list['province'] .= ">";
			$list['province'] .= $val['name'];
			$list['province'] .= "</option>";
		}

		if(!empty($data['city'])){
			$area = $this->getAreaList($province);
			$list['city'] = "<option value =''>-城市-</option>";
			foreach($area as $val){
				$list['city'] .= "<option value='".$val['id']."'";
				if($city == $val['id']) $list['city'].="selected=selected >";
				else  $list['city'] .= ">";
				$list['city'] .= $val['name'];
				$list['city'] .= "</option>";
			}
		}

		if(!empty($data['district'])){
			$area = $this->getAreaList($city);
			$list['district'] = "<option value =''>-州县-</option>";
			foreach($area as $val){
				$list['district'] .= "<option value='".$val['id']."'";
				if($district == $val['id']) $list['district'].="selected=selected >";
				else  $list['district'] .= ">";
				$list['district'] .= $val['name'];
				$list['district'] .= "</option>";
			}
		}

		if(!empty($data['community'])){
			$area = $this->getAreaList($district);
			$list['community'] = "<option value =''>-乡镇-</option>";
			foreach($area as $val){
				$list['community'] .= "<option value='".$val['id']."'";
				if($community == $val['id']) $list['community'].="selected=selected >";
				else  $list['community'] .= ">";
				$list['community'].= $val['name'];
				$list['community'].= "</option>";
			};
		}
		return $list;
	}

	/* 城市列表 */
	public function getAreaList($upid=0){

		if(IS_AJAX){
			$upid = I('post.upid');
			$list = M('district')->where(array('upid'=>$upid))->select();
			$data = '';
			foreach($list as $val){
				$data .= "<option value='".$val['id']."'>";
				$data .= $val['name'];
				$data .= "</option>";
			};

			$this->ajaxReturn($data);
		}else{
			return M('district')->where(array('upid'=>$upid))->select();
		}


	}
	/* 省级列表 */
	public function getprolist(){
	
		if(IS_AJAX){
			$upid = I('post.upid');
			$list = M('district')->where(array('upid'=>0))->select();
			$data = '';
			foreach($list as $val){
				$data .= "<option value='".$val['id']."'";
				if($upid == $val['id']) $data.="selected=selected >";
				$data .= $val['name'];
				$data .= "</option>";
			};
	
			$this->ajaxReturn($data);
		}
	
	}
	/* 城市列表 */
	public function getclist(){
	
		if(IS_AJAX){
			$upid = I('post.upid');
			$list = M('district')->where(array('upid'=>0))->select();
			$data = '';
			foreach($list as $val){
				$data .= "<option value='".$val['id']."'";
				if($upid == $val['id']) $data.="selected=selected >";
				$data .= $val['name'];
				$data .= "</option>";
			};
	
			$this->ajaxReturn($data);
		}
	
	}
	
	public function getcityList($city_id){
		$city_info	=	M('district')->where(array('id'=>$city_id))->find();
		if($city_info['upid'] == 0){
			return $city_id_list['province']	=	$city_id;
		}else{
			switch ($city_info['level']){
				case 2 :
					$city_id_list['province']	=	$city_info['upid'];
					$city_id_list['city']	=	$city_id;
					break;
				case 3 :
					$city_id_list['province']	= 	M('district')->getFieldByid($city_info['upid'],'upid');
					$city_id_list['city']	=	$city_info['upid'];
					$city_id_list['district']	= 	$city_id;
					break;
				case 4 :
					$city_id_list['province']	= 	M('district')->getFieldByid($city_id_list['city'],'upid');
					$city_id_list['city']	=	M('district')->getFieldByid($city_info['upid'],'upid');
					$city_id_list['district']	= 	$city_info['upid'];
					$city_id_list['community']	= 	$city_id;
					break;
			}
			
		}
		return $city_id_list;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}