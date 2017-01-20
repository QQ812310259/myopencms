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


// 获取当前用户的Token
function get_token($token = NULL) {

	if (MODULE_MARK === 'Admin') {
		$mpid = session('mpid');
		$mpid = intval($mpid);
		return $mpid;
	}

	$stoken = session('token');
	$domain = strip_tags($_SERVER ['HTTP_HOST']);

	if ($token !== NULL && $token != '-1') {
		session('token', $token);
	} elseif (empty($stoken) && $domain != 'os.samcms.com' && $domain != 'localhost') {
		
		$token = M("mpdomain")->cache(true)->where(array("url" => $domain))->getField('mpid');
		$token && session('token', $token);
	} elseif (!empty($_REQUEST ['token']) && $_REQUEST ['token'] != '-1') {
		session('token', $_REQUEST ['token']);
	} 
	$token = session('token');

	if (empty($token)) {
		$token = '-1';
	}
	return $token;
}
/**
 * 获取当前公众号实例化的 wechat 
 */
function get_wecha_model(){
	$token = get_token();	//获取token
	if($token	==	'-1'){
		return false;
	}
	$mpinfo = get_token_appinfo($token);
	//加载微信SDK
	$options = array(
			'token' => "wei51", //填写你设定的key
			'encodingaeskey' => $mpinfo["encodingaeskey"], //填写加密用的EncodingAESKey
			'appid' => $mpinfo["appid"], //填写高级调用功能的app id, 请在微信开发模式后台查询
			'appsecret' => $mpinfo["secret"]        //填写高级调用功能的密钥
	);
	 
	$weObj = new \Wechat($options);
	return $weObj;
}

// 获取公众号的信息
function get_token_appinfo($token = '') {
	empty($token) && $token = get_token();
	$map['id'] = $token;
	$info = M("Mpbase")->where($map)->cache(true)->find();
	return $info;
}

// 全局的安全过滤函数
function safe($text, $type = 'html') {
	// 无标签格式
	$text_tags = '';
	// 只保留链接
	$link_tags = '<a>';
	// 只保留图片
	$image_tags = '<img>';
	// 只存在字体样式
	$font_tags = '<i><b><u><s><em><strong><font><big><small><sup><sub><bdo><h1><h2><h3><h4><h5><h6>';
	// 标题摘要基本格式
	$base_tags = $font_tags . '<p><br><hr><a><img><map><area><pre><code><q><blockquote><acronym><cite><ins><del><center><strike><section><header><footer><article><nav><audio><video>';
	// 兼容Form格式
	$form_tags = $base_tags . '<form><input><textarea><button><select><optgroup><option><label><fieldset><legend>';
	// 内容等允许HTML的格式
	$html_tags = $base_tags . '<meta><ul><ol><li><dl><dd><dt><table><caption><td><th><tr><thead><tbody><tfoot><col><colgroup><div><span><object><embed><param>';
	// 全HTML格式
	$all_tags = $form_tags . $html_tags . '<!DOCTYPE><html><head><title><body><base><basefont><script><noscript><applet><object><param><style><frame><frameset><noframes><iframe>';
	// 过滤标签
	$text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
	$text = strip_tags($text, ${$type . '_tags'});

	// 过滤攻击代码
	if ($type != 'all') {
		// 过滤危险的属性，如：过滤on事件lang js
		while (preg_match('/(<[^><]+)(ondblclick|onclick|onload|onerror|unload|onmouseover|onmouseup|onmouseout|onmousedown|onkeydown|onkeypress|onkeyup|onblur|onchange|onfocus|codebase|dynsrc|lowsrc)([^><]*)/i', $text, $mat)) {
			$text = str_ireplace($mat [0], $mat [1] . $mat [3], $text);
		}
		while (preg_match('/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i', $text, $mat)) {
			$text = str_ireplace($mat [0], $mat [1] . $mat [3], $text);
		}
	}
	return $text;
}

function geturl() {
	return "http://" . strip_tags($_SERVER ['HTTP_HOST']) . __ROOT__;
}

function get_cover_url($cover_id) {
	$url = get_cover($cover_id);
	if (empty($url))
		return '';

	return geturl() . $url;
}