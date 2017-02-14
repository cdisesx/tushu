<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SHDT图书管理系统</title>
	<meta name="description" content="这是一个form页面">
	<meta name="keywords" content="form">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="renderer" content="webkit">
	<meta http-equiv="Cache-Control" content="no-siteapp" />
	<link rel="icon" type="image/png" href="/Public/AmazeUI-2.7.2/assets/i/favicon.png">
	<link rel="apple-touch-icon-precomposed" href="/Public/AmazeUI-2.7.2/assets/i/app-icon72x72@2x.png">
	<meta name="apple-mobile-web-app-title" content="Amaze UI" />
	<link rel="stylesheet" href="/Public/AmazeUI-2.7.2/assets/css/amazeui.min.css"/>
	<link rel="stylesheet" href="/Public/AmazeUI-2.7.2/assets/css/admin.css">
</head>

<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="/Public/AmazeUI-2.7.2/assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="/Public/AmazeUI-2.7.2/assets/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="/Public/AmazeUI-2.7.2/assets/js/amazeui.min.js"></script>
<script src="/Public/AmazeUI-2.7.2/assets/js/app.js"></script>



<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，Amaze UI 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
	以获得更好的体验！</p>
<![endif]-->



<style type="text/css">
	#search_text{
		height:34px;
		font:20px Arial;
		color:#000;
		width:80%;
		margin:auto;
		border-radius:5px 0px 0px 5px;
		border:0px solid #fff;
		padding:0px 10px;
		float:left;
	}
	.search_text_btn{
		height:34px;
		line-height:1;
		border-radius:0px 5px 5px 0px;
	}
	#amz-go-top1{
		position:fixed;
		bottom:10px;
		right:10px;
		z-index:99999;
	}
	.margin-A{
		margin-top:0px;
		margin-bottom:5px;
	}
	.margin-B{
		margin-top:2px;
		margin-bottom:2px;
	}
	.font-A{
		font:400 10px "Segoe UI";
		line-height:12px;
	}
	.btn-loading-example:hover{
		color:#0e90d2;
	}
</style>

<!--button id="amz-go-top" data-am-smooth-scroll="{position: 189}" class="am-btn am-icon-arrow-up am-radius "></button-->


<!--a class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu" href="#" data-am-offcanvas="{target: '#admin-offcanvas'}"></a-->

<!--a data-am-smooth-scroll href="#top" title="回到顶部" class="am-icon-btn am-icon-arrow-up am-active" id="amz-go-top"></a-->

<header class="am-topbar am-topbar-inverse admin-header">
    <div class="am-topbar-brand">
        <strong>上海东同</strong> <small>图书管理系统</small>
    </div>
	
    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-search"></span></button>
	
	<?php if(($params['id'] > 0) OR ($params['book_name']) ): ?><a href='<?php echo U("Book/bookList");?>' class="am-topbar-btn am-btn am-fr am-btn-sm am-btn-warning " ><span class="am-icon-home"></span></a><?php endif; ?>
	

    <div class="am-collapse am-topbar-collapse" style="padding:3px 10px;" id="topbar-collapse">

        <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
            <li>
				<form action="<?php echo U('Book/bookList');?>" method="get" class="am-form">
					<input id="search_text" name="book_name" type="text" value="<?php echo ($params['book_name']); ?>" />
					<button style="width:19%;" type="submit" class="am-btn am-btn-danger search_text_btn">搜索</button>
				</form>
			</li>
        </ul>
    </div>
</header>

<div class="am-cf admin-main">
  
  <!-- content start -->
  <div class="admin-content">

    <div class="admin-content-body">

      <hr>
      <ul class="am-avg-sm-1 am-avg-md-4 am-panel-group am-avg-lg-6 am-margin gallery-list" id="accordion">
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
				<div class="am-panel am-panel-default">
					<div class="am-panel-hd">
					  <div class="am-panel-title" data-am-collapse="{parent: '#accordion', target: '#do-not-say-<?php echo ($vo["id"]); ?>'}">
						<img class="am-img-thumbnail am-img-bdrs" src="/Pic<?php echo ($vo["pic"]); ?>" alt=""/>
						
						<p class="margin-A">
							<?php switch($vo["status"]): case "1": ?><span class="am-badge am-badge-success am-radius font-A">在架</span><?php break;?>
								<?php case "2": ?><span class="am-badge am-badge-warning am-radius font-A"><?php echo ($vo["user_name"]); ?>借了</span><?php break;?>
								<?php case "3": ?><span class="am-badge am-badge-danger am-radius font-A">丢失</span><?php break; endswitch;?>
							<?php echo ($vo["name"]); ?>
						</p>
					  </div>
					</div>
					<div id="do-not-say-<?php echo ($vo["id"]); ?>" class="am-panel-collapse am-collapse">
						<?php switch($vo["status"]): case "1": ?><button type="button" onclick="borrow_book('<?php echo ($vo["name"]); ?>',<?php echo ($vo["id"]); ?>);" class="am-btn am-btn-warning am-btn-block am-btn-sm">点击借阅《<?php echo (sub_string($vo["name"],10)); ?>》</button><?php break;?>
							<?php case "2": ?><button type="button" onclick="return_book('<?php echo ($vo["name"]); ?>',<?php echo ($vo["id"]); ?>);" class="am-btn am-btn-success am-btn-block am-btn-sm">我要还书</button>
								<button type="button" onclick="lose_book('<?php echo ($vo["name"]); ?>',<?php echo ($vo["id"]); ?>);" class="am-btn am-btn-danger am-btn-block am-btn-sm" style="margin-top:0px;">我要挂失</button><?php break;?>
							<?php case "3": ?><button type="button" onclick="return_book('<?php echo ($vo["name"]); ?>',<?php echo ($vo["id"]); ?>);" class="am-btn am-btn-success am-btn-block am-btn-sm">我要还书</button><?php break; endswitch;?>
						
						
						<div class="am-panel-bd">
							<?php echo ($vo["introduction"]); ?>
						</div>
					</div>
				</div>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
	  

    </div>

    <footer class="admin-content-footer" >
      <hr>
	  <center id="nextPage" hidden>
		<i style="font-size:20px;margin-bottom:5px;" class="am-icon-spinner am-icon-spin"></i> wait...
	  </center>
    </footer>
	

  </div>
  <!-- content end -->

</div>

<div class="am-modal am-modal-confirm" tabindex="-1" id="my-borrow">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">确认借阅</div>
    <div class="am-modal-bd am-g">
		《<font id="borrow-book-name"></font>》 <hr>
		<form class="checkForm" id="borrow_form">
		<!--am-form-error-->
		<div class="">
			<input name="user_name" type="text" class="margin-B am-form-field" placeholder="请输入你的名字">
		</div>
		
		<div class="">
			<input name="phone" type="text" class="margin-B am-form-field" placeholder="请输入手机号码">
		</div>
		
		<div class=" am-u-sm-8" style="padding-left:0px;">
			<input name="code" type="text" class="am-form-field" style="margin-top:5px;" placeholder="验证码" />
		</div>
		
		<a class="btn-loading-example am-btn" style="margin-top:5px;" >获取</a>
		</form>
    </div>
    <div class="am-modal-footer">
      <span class="am-modal-btn" data-am-modal-cancel>取消</span>
      <span class="am-modal-btn" data-am-modal-confirm>确定</span>
    </div>
  </div>
</div>

<div class="am-modal am-modal-confirm" tabindex="-1" id="my-return">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">确认还书</div>
    <div class="am-modal-bd am-g">
		《<font id="return-book-name"></font>》 <hr>
		<form class="checkForm" id="return_form">
		
		<div class="">
			<input name="phone" type="text" class="margin-B am-form-field" placeholder="请输入手机号码">
		</div>
		
		<div class=" am-u-sm-8" style="padding-left:0px;">
			<input name="code" type="text" class="am-form-field" style="margin-top:5px;" placeholder="验证码" />
		</div>
		
		<a class="btn-loading-example am-u-sm-4 am-btn" style="margin-top:5px;" >获取</a>
		</form>
    </div>
    <div class="am-modal-footer">
      <span class="am-modal-btn" data-am-modal-cancel>取消</span>
      <span class="am-modal-btn" data-am-modal-confirm>确定</span>
    </div>
  </div>
</div>

<div class="am-modal am-modal-confirm" tabindex="-1" id="my-lose">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">上报丢失</div>
    <div class="am-modal-bd am-g">
		《<font id="lose-book-name"></font>》 <hr>
		<form class="checkForm" id="lose_form">
		
		<div class="">
			<input name="phone" type="text" class="margin-B am-form-field" placeholder="请输入手机号码">
		</div>
		
		<div class=" am-u-sm-8" style="padding-left:0px;">
			<input name="code" type="text" class="am-form-field" style="margin-top:5px;" placeholder="验证码" />
		</div>
		
		<a class="btn-loading-example am-u-sm-4 am-btn" style="margin-top:5px;" >获取</a>
		</form>
    </div>
    <div class="am-modal-footer">
      <span class="am-modal-btn" data-am-modal-cancel>取消</span>
      <span class="am-modal-btn" data-am-modal-confirm>确定</span>
    </div>
  </div>
</div>

<div class="am-modal am-modal-confirm" tabindex="-1" id="my-loading">
  <div class="am-modal-dialog" style="background-color:rgba(0,0,0,0);">
    <i style="color:#fff;" class="am-icon-spinner am-icon-spin am-icon-md"></i>
  </div>
</div>

<script type="text/javascript">
	
	// 滚动到顶端
	$('#my-button').on('click', function() {
	  var $w = $(window);
	  $w.smoothScroll({position: $(document).height() - $w.height()});
	});
	
	// 借阅
	function borrow_book(name,id){
		$('#borrow-book-name').html(name);
		$('#my-borrow').modal({
			relatedTarget: this,
			closeOnConfirm:false,
			onConfirm: function(options) {
				if(checkInput('borrow')){
					var url = '<?php echo U("Book/borrowBook");?>';
					var push_data = $('#borrow_form').serialize();
					push_data += '&id='+id;
					$.ajax({
						url: url,
						data:push_data,
						type:'post',
						dataType:'json',
						beforeSend:function (){
							$('#my-borrow').modal('close');
							$('#my-loading').modal({
								relatedTarget: this,
								closeViaDimmer: 0
							});
						},
						success:function(data){
							$('#my-loading').modal('close');
							loadAlert('borrow',data,name,id);
						},
						error:function (){
							$('#my-loading').modal('close');
							doAlert('网络错误');
						}
					});
				}
			},
			onCancel: function() {}
		});
	}
	// 归还
	function return_book(name,id){
	$('#return-book-name').html(name);
		$('#my-return').modal({
			relatedTarget: this,
			closeOnConfirm:false,
			onConfirm: function(options) {
				if(checkInput('return')){
					var url = '<?php echo U("book/returnBook");?>';
					var push_data = $('#return_form').serialize();
					push_data += '&id='+id;
					$.ajax({
						url: url,
						data:push_data,
						type:'post',
						dataType:'json',
						beforeSend:function (){
							$('#my-return').modal('close');
							$('#my-loading').modal({
								relatedTarget: this,
								closeViaDimmer: 0
							});
						},
						success:function(data){
							loadAlert('return',data,name,id);
						},
						error:function (){
							$('#my-loading').modal('close');
							doAlert('网络错误');
						}
					});
				}
			},
			onCancel: function() {}
		});
	}
	// 报失
	function lose_book(name,id){
		$('#lose-book-name').html(name);
		$('#my-lose').modal({
			relatedTarget: this,
			closeOnConfirm:false,
			onConfirm: function(options){	
				if(checkInput('lose')){
					var url = '<?php echo U("book/loseBook");?>';
					var push_data = $('#lose_form').serialize();
					push_data += '&id='+id;
					$.ajax({
						url:url,
						data:push_data,
						type:'post',
						dataType:'json',
						beforeSend:function (){
							$('#my-lose').modal('close');
							$('#my-loading').modal({
								relatedTarget: this,
								closeViaDimmer: 0
							});
						},
						success:function(data){
							loadAlert('lose',data,name,id);
						},
						error:function (){
							$('#my-loading').modal('close');
							doAlert('网络错误');
						}
					});
				}
			},
			onCancel: function() {}
		});
	}
	// 关闭Comfirm并开启alert 当alert执行难后，重新开启Comfirm
	function loadAlert(action,data,name,id){	
		$('#my-loading').modal('close');
		switch (action){
			case 'borrow':
				doAlert(data.msg, function(){
					if(data.code>0){
						borrow_book(name,id);
					}else{
						window.location.href='<?php echo U("book/booklist");?>?id='+id;
					}
				})
				break;
			case 'return':
				doAlert(data.msg, function(){
					if(data.code>0){
						return_book(name,id);
					}else{
						window.location.href='<?php echo U("book/booklist");?>?id='+id;
					}
				})
				break;
			case 'lose':
				doAlert(data.msg, function(){
					if(data.code>0){
						lose_book(name,id);
					}else{
						window.location.href='<?php echo U("book/booklist");?>?id='+id;
					}
				})
				break;
		}
		
		
	}
	
	// 前段验证
	function checkInput(checkForm){
	
		if('borrow'===checkForm){
			
			var obj = $('#borrow_form').find('input[name="user_name"]');
			if(!obj.val()){
				showError(obj);return false;
			}
			var obj = $('#borrow_form').find('input[name="phone"]');
			if(!checkIsPhone(obj.val())){
				showError(obj);return false;
			}
			var obj = $('#borrow_form').find('input[name="code"]');
			if(!obj.val()){
				showError(obj);return false;
			}
			
		}
		
		
		
		if('return'===checkForm){
			
			var obj = $('#return_form').find('input[name="phone"]');
			if(!checkIsPhone(obj.val())){
				showError(obj);return false;
			}
			var obj = $('#return_form').find('input[name="code"]');
			if(!obj.val()){
				showError(obj);return false;
			}
			
		}
		
		if('lose'===checkForm){
			
			var obj = $('#lose_form').find('input[name="phone"]');
			if(!checkIsPhone(obj.val())){
				showError(obj);return false;
			}
			var obj = $('#lose_form').find('input[name="code"]');
			if(!obj.val()){
				showError(obj);return false;
			}
			
		}
		
		return true;
	}
	// 验证恢复
	$('input').on('change click focus',function(){
		$(this).parent('div').removeClass('am-form-error');
	});
	// 显示报错
	function showError(obj){
		$(obj).parent('div').addClass('am-form-error');
		whipping(obj);
	}
	// 摇摆动画
	var whipping_time = 24;
	var whipping_speed = 30;
	function whipping(obj){
		if(whipping_time--){
			var times = whipping_time%4;
			var obj_p = $(obj).parent('div');
			switch (times){
				case 0:obj_p.animate({paddingTop: '10px'}, whipping_speed, whipping(obj));break;
				case 1:obj_p.animate({paddingTop: '0px'}, whipping_speed, whipping(obj));break;
				case 2:obj_p.animate({paddingBottom: '10px'}, whipping_speed, whipping(obj));break;
				case 3:obj_p.animate({paddingBottom: '0px'}, whipping_speed, whipping(obj));break;
			}
		}else{
			whipping_time = 24;
		}
	}
	
	// 手机号码检测
	function checkIsPhone(phone){
		var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
		if(myreg.test(phone)){ 
			return true;
		} 
		return false;
	}
	
	
	// 验证码
	var clock = '';
	var nums = 60;
	var btn;
	$('.btn-loading-example').click(function () {
	
		if(nums==60){
			sendCode($(this));
		}
		
	});
	function sendCode(thisBtn){
		btn = thisBtn;
		var phone = $(thisBtn).parent('.checkForm').find('input[name="phone"]').val();
		if(!checkIsPhone(phone)){
			showError($(thisBtn).parent('.checkForm').find('input[name="phone"]'));
			return false;
		}
		$.ajax({
			url:'<?php echo U("book/sendCode");?>',
			data:'phone='+phone,
			type:'post',
			dataType:'json',
			beforeSend:function (){
				$(btn).html('<i class="am-icon-spinner am-icon-spin"></i>');
			},
			success:function(data){
				if(data.code==0){
					beginCount();
				}else{
					$(btn).html('reTry');
				}
				
			},
			error:function (){
				$(btn).html('reTry');
			}
		});
	}
	function beginCount(){
		$(btn).html(nums+'s');
		clock = setInterval(doLoop, 1000); //一秒执行一次
	}
	function doLoop(){
		nums--;
		if(nums > 0){
			$(btn).html(nums+'s');
		}else{
			clearInterval(clock); //清除js定时器
			$(btn).html('获取');
			nums = 60; //重置时间
		}
	}
	
	// 点击空白处收回搜索框
	$('.admin-main').click(function (){
		if($('#topbar-collapse').hasClass('am-in')){
			$('.am-topbar-btn').trigger('click');
		};
	});
	
	// 到达底部操作
	var page = 1;
	$(".admin-content").scroll(function(){
		var totalHeight = $(this).height();
        var nScrollHight = $(this)[0].scrollHeight;
        var nScrollTop = $(this)[0].scrollTop;
　　　　var paddingBottom = parseInt( $(this).css('padding-bottom') )
		var paddingTop = parseInt( $(this).css('padding-top') );
        if(nScrollTop + paddingBottom + paddingTop + totalHeight >= nScrollHight - 20){
			if(page<=20){
				getNextPage();
			}else{
				$('#nextPage').html('已经没有了');
			}
			
		}
    });
	// 获取下一页
	function getNextPage(){
		++page;
		$.ajax({
			url:'<?php echo U("book/bookList");?>',
			data:'is_ajax=1&page='+page,
			type:'get',
			dataType:'html',
			beforeSend:function (){
				$('#nextPage').show();
			},
			success:function(html){
				if(html){
					$('#accordion').append(html);
					$('#nextPage').hide();
				}else{
					page = 20;
					$('#nextPage').html('已经没有了');
				}
			},
			error:function (){
				$('#nextPage').hide();
			}
		});
	}
</script>



<script type="text/javascript">
<!--提示框-->
	function doAlert(word, fn){
		if(fn != undefined){
			$('#am-doFunction').click(fn);
		}
		$('#am-alertWord').html(word);
		$('#my-alert').modal({relatedTarget: this,});
	}
	
	$('img').each(function (i){
		if(!$(this).attr('src')){
			$(this).attr('src',$(this).attr('empty_src'));
		}
	})
	
</script>
<!--提示框-->
<div class="am-modal am-modal-alert" tabindex="-1" id="my-alert">
	<div class="am-modal-dialog">
		<div class="am-modal-hd" id="am-alertWord"></div>
		<div class="am-modal-footer">
		  <span class="am-modal-btn" id="am-doFunction">确定</span>
		</div>
	</div>
</div>

</body>
</html>