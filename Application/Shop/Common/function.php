<?php
/**
 * Created by PhpStorm.
 * User: Jess
 * Github: https://github.com/jessppp
 */
function chack_array($array){
	if(is_array($array)){
		foreach( $array as $k=> $v){
			if( !$v )
				unset( $array[$k] );
		}
		$array	=	array_pop($array);
	}
	return $array;
}

/**
 * 生成唯一订单号
 */
function build_order_no()
{
	$no = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
	//检测是否存在
	$db = D('order');
	$info = $db->where(array('sn'=>$no))->find();
	(!empty($info)) && $no = $this->build_order_no();
	return $no;

}