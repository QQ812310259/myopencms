<?php
// +----------------------------------------------------------------------
// | OpenCMF [ Simple Efficient Excellent ]
// +----------------------------------------------------------------------
// | Copyright (c) 2014 http://www.opencmf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: jry <598821125@qq.com>
// +----------------------------------------------------------------------

//开发者二次开发公共函数统一写入此文件，不要修改function.php以便于系统升级。
/**
 * 传递数据以易于阅读的样式格式化后输出
 * @param unknown $data
 */
function P($data){
    // 定义样式
    $str='<pre style="display: block;padding: 9.5px;margin: 44px 0 0 0;font-size: 13px;line-height: 1.42857;color: #333;word-break: break-all;word-wrap: break-word;background-color: #F5F5F5;border: 1px solid #CCC;border-radius: 4px;">';
    // 如果是boolean或者null直接显示文字；否则print
    if (is_bool($data)) {
        $show_data=$data ? 'true' : 'false';
    }elseif (is_null($data)) {
        $show_data='null';
    }else{
        $show_data=print_r($data,true);
    }
    $str.=$show_data;
    $str.='</pre>';
    echo $str;
}
/**
 * 检测城市
 */
function getCity($ip){
	$argv = array(
			'ThinkPHP/Library/Vendor/Ip2Region/ip2region.db',
			'binary'
	);
	$dbFile     = $argv[0];
	if ( isset($argv[1]) ) {
		switch ( strtolower($argv[1]) ) {
			case 'binary':
				$algorithm = 'Binary';
				$method    = 'binarySearch';
				break;
			case 'memory':
				$algorithm = 'Memory';
				$method    = 'memorySearch';
				break;
		}
	}
	Vendor('Ip2Region.Ip2Region');
	$ip2regionObj = new Ip2Region($dbFile);
	$line = $ip;
	$data   = $ip2regionObj->{$method}($line);
	$city	=	explode('|', $data['region']);
	// 		print_r($city[2].$city[3]);exit;
	// 	if($city[2]	==	0){
	// 		$city_info	=	getCity2($ip);
	// 		return $city_info;
	// 	}
	return $city[2].'  '.$city[3];
}