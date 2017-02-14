<?php if (!defined('THINK_PATH')) exit(); if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
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