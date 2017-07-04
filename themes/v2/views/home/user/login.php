<?php 
	Yii::app()->clientScript->registerCssFile("/themes/v2/static/home/style/user-common.css");

	Yii::app()->clientScript->registerCssFile("/themes/v2/static/home/style/user-regis.css");
	Yii::app()->clientScript->registerCssFile("/themes/v2/static/home/style/user-login.css");
	Yii::app()->clientScript->registerCssFile("/themes/v2/static/home/style/user-wap.css");
?>
<style type="text/css">
	.step-panel .table .lab-left {
		width: 380px
	}
</style>
<section class="container" style="margin-top: 40px">
<div class="step-panel register-panel" style="width: 100%">
    <div class="clearfix-row">
    <br><br>
        <center><h3><img style="height: 50px" src="<?=ImageTools::fixImage(SiteExt::getAttr('qjpz','pcLogo'))?>">&nbsp;&nbsp;球布斯登录</h3></center>
    </div>
    <form id="fm1" method="post">
    <div class="clearfix-row" >
        <div id="register-bind" class="table">
            <div class="clearfix-row m-t-72" style="margin-top: 50px">
                <div class="lab-left"><span class="line-h-40">手机号：</span></div>
                <div class="lab-right">
                    <div class="text-box">
                        <input class="text w-308" id="username" value="<?=$phone?>"  name="name" type="text" placeholder="" onblur="ckit(this)">
                    </div>
                </div>
            </div>
            <div class="clearfix-row m-t-16">
                <div class="lab-left"><span class="line-h-40">密码：</span></div>
                <div class="lab-right">
                    <div class="text-box">
                        <input class="text w-308" onkeydown="clearit()" id="pwd" value="<?=$pwd?>" name="pwd" type="password" placeholder=""><?php if($wrong):?><span id="pwdspan" style="margin-left:20px;color:red">手机号或密码错误！</span><?php endif;?>
                    </div>
                </div>
            </div>
            <div class="clearfix-row m-t-16 text-a-c m-b-50"><a class="botton btn-border active submit line-h-35 w-120" onclick="ckfm()">登录</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=$this->createUrl('regis')?>" style="color:gray">立即注册</a></div>
        </div>
    </div>
    </form>
</div>
</section>
<script type="text/javascript">
	function ckit(obj) {
		$('#namespan').remove();
		if($(obj).val()=='') {
			$(obj).after('<span id="namespan" style="margin-left:20px;color:red">此项不能为空！</span>');
			$(obj).focus();
		}
	}
	function ckfm() {
		var name = $('#name').val();
		var pwd = $('#pwd').val();
		$('#namespan').remove();
		$('#pwdspan').remove();
		if(name=='') {
			$('#name').after('<span id="namespan" style="margin-left:20px;color:red">此项不能为空！</span>');
			$('#name').focus();
			return false;
		}
		if(pwd=='') {
			$('#pwd').after('<span id="pwdspan" style="margin-left:20px;color:red">此项不能为空！</span>');
			$('#pwd').focus();
			return false;
		}
		document.getElementById('fm1').submit()
	}
	function clearit() {
		$('#pwdspan').remove();
	}
</script>