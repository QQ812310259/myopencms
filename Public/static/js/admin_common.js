
//上传图片组件
function initUploadImg(opts){
	if(opts && opts.width && opts.height){
		width = opts.width;
		height = opts.height;
	}else{
		width = height = 100;
	}
	
	$uploadDom = $('.uploadrow2');
	if(opts && opts.uploadDom){
		$uploadDom = opts.uploadDom;
	}
	$uploadDom.each(function(index, obj) {
	
		setTimeout(function(){
			var name = $(obj).attr('rel');
			
			var is_mult = $(obj).hasClass('mult');
			$('#upload_picture_'+name).uploadify({
				//alert("dddsa");
				"height"          : height,
				"swf"             : "/Public/static/uploadify/uploadify.swf",
				"fileObjName"     : "download",
				"buttonText"      : "上传图片",
				"uploader"        : UPLOAD_PICTURE,
				"width"           : width,
				'cancelImg'		  : 'JS/jquery.uploadify-v2.1.0/cancel.png',
				'removeTimeout'	  : 1,
				'fileTypeExts'	  : '*.jpg; *.png; *.gif;',
				"onUploadSuccess" : function(file, data, response) {
					//console.log(22);
					//console.log($('#cover_id_'+name).parent().find('.upload-img-box'));
					$('#cover_id_'+name).parent().find('.upload-img-box').show();
					onUploadImsSuccess(file, data, name, is_mult,opts);
				},
				"onUploadError" : function(file, data, response) {
					//console.log(33);
					//console.log(data);
				   // onUploadImsSuccess(file, data, name, is_mult);
				}
			});
		},400);
		
	});
	
}


$(document).ready(function() {
  $('#file_upload').uploadify({  	'buttonImg'      : 'static/js/uploadify/ny.png',//浏览按钮的图片的路径 。	    'wmode'          : 'transparent' ,//设置该项为transparent 可以使浏览按钮的flash背景文件透明，并且flash文件会被置为页面的最高层。  
	'uploader'  : 'static/js/uploadify/uploadify.swf?v='+new Date(),
	"fileObjName" : "file_upload",
    'script'    : './?xm=Admin-File-uploadPicture-session_id-rppfcdk6eg0lrh9vkq6cn2rre5',
    'cancelImg' : 'static/js/uploadify/cancel.png',
    'folder'    : 'upload/',
    'auto'      : true,
	'multi'     : true,
	'fileExt'    : '*.jpg;*.gif;',
	'onComplete':function(event,queueId,fileObj,response,data){
		$('#piclist').append('<li id="'+response+'"><img src="Uploads/'+response+'"><p><a href="#" onclick=delpic("'+response+'");>删除</a></p><input type="hidden" name="p_pics[]" value="'+response+'"></li>');//在页面上显示文件相对路径
	}
  });

});


function onUploadImsSuccess(file, data, name, is_mult,opts){
	var data = $.parseJSON(data);
	var src = '';
	if(opts){
		var width = opts.width;
		var height = opts.height;
	}else{
		var width = height = 100;
	}
	if(data.status){
		$('#cover_id_'+name).val(data.id);
		src = data.url || ROOT + data.path;
		
		if(is_mult){
			$addImg = $('<div class="upload-pre-item22"><img width="100" height="100" src="' + src + '"/>'
				+'<input type="hidden" name="'+name+'[]" value="'+data.id+'"/><em onClick="if(confirm(\'确认删除？\')){$(this).parent().remove();}">&nbsp;</em></div>');
			$("#mutl_picture_"+name).append($addImg);
			
			
			$("#mutl_picture_"+name).dragsort('destroy');
			$("#mutl_picture_"+name).dragsort({
			    itemSelector: ".upload-pre-item22", dragSelector: ".upload-pre-item22", dragBetween: false, placeHolderTemplate: "<div class='upload-pre-item22'></div>",dragSelectorExclude:'em',dragEnd: function() {$(".upload-pre-item22").attr('style','')}
		    });
		}else{										
			$('#cover_id_'+name).parent().find('.upload-img-box').html(
				'<div class="upload-pre-item2" style="width:'+width+'px;height:'+height+'px;max-height:'+height+'px"><img width="'+width+'" height="'+height+'" src="' + src + '"/></div><em class="edit_img_icon">&nbsp;</em>'
			);
			
			$('.weixin-cover-pic').attr('src',src);
		}
		//外部回调函数
		if(!(opts && opts.callback)){
			var callback = $('#cover_id_'+name).data('callback');
			if(callback){
				eval(callback+'(\''+name+'\','+data.id+',\''+src+'\')');
			}
		}else{
			opts.callback(name,data.id,src);
		}
	} else {
		updateAlert(data.info);
		setTimeout(function(){
			$('#top-alert').find('button').click();
			$(that).removeClass('disabled').prop('disabled',false);
		},1500);
	}
}