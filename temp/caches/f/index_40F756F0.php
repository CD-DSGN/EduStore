<?php exit;?>a:3:{s:8:"template";a:13:{i:0;s:77:"D:/Demo/ecshopCode/ecshop_php5..5_modified/themes/ecmoban_baiduMall/index.dwt";i:1;s:91:"D:/Demo/ecshopCode/ecshop_php5..5_modified/themes/ecmoban_baiduMall/library/page_header.lbi";i:2;s:88:"D:/Demo/ecshopCode/ecshop_php5..5_modified/themes/ecmoban_baiduMall/library/index_ad.lbi";i:3;s:99:"D:/Demo/ecshopCode/ecshop_php5..5_modified/themes/ecmoban_baiduMall/library/category_tree_index.lbi";i:4;s:92:"D:/Demo/ecshopCode/ecshop_php5..5_modified/themes/ecmoban_baiduMall/library/new_articles.lbi";i:5;s:91:"D:/Demo/ecshopCode/ecshop_php5..5_modified/themes/ecmoban_baiduMall/library/ad_position.lbi";i:6;s:99:"D:/Demo/ecshopCode/ecshop_php5..5_modified/themes/ecmoban_baiduMall/library/recommend_promotion.lbi";i:7;s:93:"D:/Demo/ecshopCode/ecshop_php5..5_modified/themes/ecmoban_baiduMall/library/recommend_new.lbi";i:8;s:93:"D:/Demo/ecshopCode/ecshop_php5..5_modified/themes/ecmoban_baiduMall/library/recommend_hot.lbi";i:9;s:94:"D:/Demo/ecshopCode/ecshop_php5..5_modified/themes/ecmoban_baiduMall/library/recommend_best.lbi";i:10;s:89:"D:/Demo/ecshopCode/ecshop_php5..5_modified/themes/ecmoban_baiduMall/library/cat_goods.lbi";i:11;s:84:"D:/Demo/ecshopCode/ecshop_php5..5_modified/themes/ecmoban_baiduMall/library/help.lbi";i:12;s:91:"D:/Demo/ecshopCode/ecshop_php5..5_modified/themes/ecmoban_baiduMall/library/page_footer.lbi";}s:7:"expires";i:1463986239;s:8:"maketime";i:1463982639;}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="ECSHOP演示站" />
<meta name="Description" content="ECSHOP演示站" />
<title>LTMALL测试站</title>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="themes/ecmoban_baiduMall/style.css" rel="stylesheet" type="text/css" />
<link rel="alternate" type="application/rss+xml" title="RSS|LTMALL测试站" href="feed.php" />
<script type="text/javascript" src="js/common.js"></script><script type="text/javascript" src="js/index.js"></script></head>
<body class="index_page">
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script><script type="text/javascript" src="js/jquery.json.js"></script><script type="text/javascript">
var process_request = "正在处理您的请求...";
</script>
<script type="text/javascript">
//设为首页 www.ecmoban.com
function SetHome(obj,url){
    try{
        obj.style.behavior='url(#default#homepage)';
       obj.setHomePage(url);
   }catch(e){
       if(window.netscape){
          try{
              netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
         }catch(e){
              alert("抱歉，此操作被浏览器拒绝！\n\n请在浏览器地址栏输入“about:config”并回车然后将[signed.applets.codebase_principal_support]设置为'true'");
          }
       }else{
        alert("抱歉，您所使用的浏览器无法完成此操作。\n\n您需要手动将【"+url+"】设置为首页。");
       }
  }
}
 
//收藏本站 bbs.ecmoban.com
function AddFavorite(title, url) {
  try {
      window.external.addFavorite(url, title);
  }
catch (e) {
     try {
       window.sidebar.addPanel(title, url, "");
    }
     catch (e) {
         alert("抱歉，您所使用的浏览器无法完成此操作。\n\n加入收藏失败，请使用Ctrl+D进行添加");
     }
  }
}
</script>
 
<div class="top_nav" style=" display:none">
	<script type="text/javascript">
          //初始化主菜单
            function sw_nav(obj,tag)
            {
     
            var DisSub = document.getElementById("DisSub_"+obj);
            var HandleLI= document.getElementById("HandleLI_"+obj);
                if(tag==1)
                {
                    DisSub.style.display = "block";
             
                    
                }
                else
                {
                    DisSub.style.display = "none";
                
                }
     
            }
     
    </script>
    <div class="block">     
    
        <ul class="top_bav_l">
        <li class="top_sc">
           <a href="javascript:void(0);" onclick="AddFavorite('我的网站',location.href)">收藏本站</a>
</li>
            <li>关注我们：</li>
            <li style="border:none" class="menuPopup"  onMouseOver="sw_nav(1,1);" onMouseOut="sw_nav(1,0);">
            <a id="HandleLI_1" href="javascript:;" title="微博" class="attention"></a> 
            <div id=DisSub_1 class="top_nav_box  top_weibo"> 
            <a href="http://e.weibo.com/ECMBT" target="_blank" title="新浪微博" class="top_weibo"></a>
            <a href="http://e.t.qq.com/ecmoban_com" target="_blank" title="QQ微博" class="top_qq"></a> 
            </div> 
            </li> 
            <li class="menuPopup" onMouseOver="sw_nav(2,1);" onMouseOut="sw_nav(2,0);">
            <a id="HandleLI_2" href="javascript:;" title="微信" class="top_weixin"></a> 
            <div id="DisSub_2" class="weixinBox" style="display: none;"> 
		
            <img src="themes/ecmoban_baiduMall/images/weixin.png" style="width:150px; height:190px;  background:#0000CC" width="150" height="190"> 
            </div> 
            </li>
        </ul>
    
        <div class="header_r">
        
        <script type="text/javascript" src="js/transport_jquery.js"></script><script type="text/javascript" src="js/utils.js"></script>        <font id="ECS_MEMBERZONE" >554fcae493e564ee0dc75bdf2ebf94camember_info|a:1:{s:4:"name";s:11:"member_info";}554fcae493e564ee0dc75bdf2ebf94ca </font>
     
                                        <a href="flow.php" >查看购物车</a>
                                         |
                                                   <a href="pick_out.php" >选购中心</a>
                                         |
                                                   <a href="tag_cloud.php" >标签云</a>
                                         |
                                                   <a href="quotation.php" >报价单</a>
                                                    
        </div>
    </div>
</div>
<div class="normal-header">
	<div class="block logo_wrap">
    	<a class="logo_new" href="index.php"><img src="themes/ecmoban_baiduMall/images/logo.gif" /></a>
        <div class="account">
        	554fcae493e564ee0dc75bdf2ebf94camember_info|a:1:{s:4:"name";s:11:"member_info";}554fcae493e564ee0dc75bdf2ebf94ca            <div class="shopping-trolley" id="ECS_CARTINFO">
            	购物袋（554fcae493e564ee0dc75bdf2ebf94cacart_info|a:1:{s:4:"name";s:9:"cart_info";}554fcae493e564ee0dc75bdf2ebf94ca）
            </div>
        </div>
    </div>
    <div class="menu_box clearfix"> 
		<div class="block"> 
            <div class="menu">
            	<a href="javascript:void(0);" class="all-category">全部商品分类</a>
                <a href="index.php" class="cur">首页<span></span></a>
                                <a href="category.php?id=3"  >GSM手机<span></span></a>
                                <a href="category.php?id=5"  >双模手机<span></span></a>
                                <a href="category.php?id=6"  >手机配件<span></span></a>
                                <a href="group_buy.php"  >团购商品<span></span></a>
                                <a href="activity.php"  >优惠活动<span></span></a>
                                <a href="snatch.php"  >夺宝奇兵<span></span></a>
                                <a href="auction.php"  >拍卖活动<span></span></a>
                                <a href="exchange.php"  >积分商城<span></span></a>
                                <a href="message.php"  >留言板<span></span></a>
                                <a href="http://bbs.ecshop.com/" target="_blank"  >EC论坛<span></span></a>
                            </div> 
		</div>
	</div>
</div><style type="text/css"> 
.container, .container *{margin:0; padding:0;}
.container{width:100%; height:419px; overflow:hidden;position:relative;}
.slider{position:absolute; width:100%; height:419px;}
.slider li , .slider li a{list-style:none; float:left;width:100%; height:419px;}
.slider img{width:100%; height:419px; display:block;}
.slider2{width:2000px;}
.slider2 li{float:left;}
.num{position:absolute; right:5px; bottom:5px; width:800px; margin:0 auto;}
.num li{
	float: left;
	color: #000;
	text-align: center;
	line-height: 16px;
	width: 16px;
	height: 16px;
	font-family: Arial;
	font-size: 12px;
	cursor: pointer;
	overflow: hidden;
	margin: 3px 1px;
	border: 1px solid #8575bb;
	background-color: #fff;
}
.num li.on{
	color: #fff;
	line-height: 21px;
	width: 21px;
	height: 21px;
	font-size: 16px;
	margin: 0 1px;
	border: 0;
	background-color: #8575bb;
	font-weight: bold;
}
</style>
<div class="container" id="idTransformView">
  <ul class="slider" id="idSlider">
        <li style="background:url(data/afficheimg/20160422dzwebz.jpg) center 0 no-repeat #da2653; position:relative;"><a href="http://" target="_blank"></a></li>
            <li style="background:url(data/afficheimg/20160129prsrpo.png) center 0 no-repeat #da2653; position:relative;"><a href="http://mb.ecmoban.com/kuajingtong/" target="_blank"></a></li>
            <li style="background:url(data/afficheimg/20160129vfrgku.jpg) center 0 no-repeat #da2653; position:relative;"><a href="http://dsc.ecmoban.com/" target="_blank"></a></li>
            <li style="background:url(data/afficheimg/20160129bcmitn.jpg) center 0 no-repeat #da2653; position:relative;"><a href="http://www.ecjia.com/" target="_blank"></a></li>
            <li style="background:url(data/afficheimg/20150608boezpt.png) center 0 no-repeat #da2653; position:relative;"><a href="http://www.ectouch.cn/" target="_blank"></a></li>
            <li style="background:url(data/afficheimg/20160129pcigev.png) center 0 no-repeat #da2653; position:relative;"><a href="http://www.ecmoban.com/topic/wfx/index.html" target="_blank"></a></li>
      
  </ul>
  <ul class="num" id="idNum">
 
    
          <li>
    1    </li> 
         <li>
    2    </li> 
         <li>
    3    </li> 
         <li>
    4    </li> 
         <li>
    5    </li> 
         <li>
    6    </li> 
        
  </ul>
</div>
<script type="text/javascript">
var $s = function (id) {
	return "string" == typeof id ? document.getElementById(id) : id;
};
var Class = {
  create: function() {
	return function() {
	  this.initialize.apply(this, arguments);
	}
  }
}
Object.extend = function(destination, source) {
	for (var property in source) {
		destination[property] = source[property];
	}
	return destination;
}
var TransformView = Class.create();
TransformView.prototype = {
  //容器对象,滑动对象,切换参数,切换数量
  initialize: function(container, slider, parameter, count, options) {
	if(parameter <= 0 || count <= 0) return;
	var oContainer = $s(container), oSlider = $s(slider), oThis = this;
	this.Index = 0;//当前索引
	
	this._timer = null;//定时器
	this._slider = oSlider;//滑动对象
	this._parameter = parameter;//切换参数
	this._count = count || 0;//切换数量
	this._target = 0;//目标参数
	
	this.SetOptions(options);
	
	this.Up = !!this.options.Up;
	this.Step = Math.abs(this.options.Step);
	this.Time = Math.abs(this.options.Time);
	this.Auto = !!this.options.Auto;
	this.Pause = Math.abs(this.options.Pause);
	this.onStart = this.options.onStart;
	this.onFinish = this.options.onFinish;
	
	oContainer.style.overflow = "hidden";
	oContainer.style.position = "relative";
	
	oSlider.style.position = "absolute";
	oSlider.style.top = oSlider.style.left = 0;
  },
  //设置默认属性
  SetOptions: function(options) {
	this.options = {//默认值
		Up:			true,//是否向上(否则向左)
		Step:		5,//滑动变化率
		Time:		10,//滑动延时
		Auto:		true,//是否自动转换
		Pause:		2000,//停顿时间(Auto为true时有效)
		onStart:	function(){},//开始转换时执行
		onFinish:	function(){}//完成转换时执行
	};
	Object.extend(this.options, options || {});
  },
  //开始切换设置
  Start: function() {
	if(this.Index < 0){
		this.Index = this._count - 1;
	} else if (this.Index >= this._count){this.Index = 0;}
	
	this._target = -1 * this._parameter * this.Index;
	this.onStart();
	this.Move();
  },
  //移动
  Move: function() {
	clearTimeout(this._timer);
	var oThis = this, style = this.Up ? "top" : "left", iNow = parseInt(this._slider.style[style]) || 0, iStep = this.GetStep(this._target, iNow);
	
	if (iStep != 0) {
		this._slider.style[style] = (iNow + iStep) + "px";
		this._timer = setTimeout(function(){oThis.Move();}, this.Time);
	} else {
		this._slider.style[style] = this._target + "px";
		this.onFinish();
		if (this.Auto) { this._timer = setTimeout(function(){oThis.Index++; oThis.Start();}, this.Pause); }
	}
  },
  //获取步长
  GetStep: function(iTarget, iNow) {
	var iStep = (iTarget - iNow) / this.Step;
	if (iStep == 0) return 0;
	if (Math.abs(iStep) < 1) return (iStep > 0 ? 1 : -1);
	return iStep;
  },
  //停止
  Stop: function(iTarget, iNow) {
	clearTimeout(this._timer);
	this._slider.style[this.Up ? "top" : "left"] = this._target + "px";
  }
};
window.onload=function(){
	function Each(list, fun){
		for (var i = 0, len = list.length; i < len; i++) {fun(list[i], i);}
	};
	
	var objs = $s("idNum").getElementsByTagName("li");
	var obj_len = objs.length;
	var tv = new TransformView("idTransformView", "idSlider", 419, obj_len, {
		onStart : function(){ Each(objs, function(o, i){o.className = tv.Index == i ? "on" : "";}) }//按钮样式
	});
	
	tv.Start();
	
	Each(objs, function(o, i){
		o.onmouseover = function(){
			o.className = "on";
			tv.Auto = false;
			tv.Index = i;
			tv.Start();
		}
		o.onmouseout = function(){
			o.className = "";
			tv.Auto = true;
			tv.Start();
		}
	})
	
	////////////////////////test2
	
//	var objs2 = $("idNum2").getElementsByTagName("li");
//	
//	var tv2 = new TransformView("idTransformView2", "idSlider2",1200, 3, {
//		onStart: function(){ Each(objs2, function(o, i){o.className = tv2.Index == i ? "on" : "";}) },//按钮样式
//		Up: false
//	});
//	
//	tv2.Start();
//	
//	Each(objs2, function(o, i){
//		o.onmouseover = function(){
//			o.className = "on";
//			tv2.Auto = false;
//			tv2.Index = i;
//			tv2.Start();
//		}
//		o.onmouseout = function(){
//			o.className = "";
//			tv2.Auto = true;
//			tv2.Start();
//		}
//	})
//	
//	$("idStop").onclick = function(){tv2.Auto = false; tv2.Stop();}
//	$("idStart").onclick = function(){tv2.Auto = true; tv2.Start();}
//	$("idNext").onclick = function(){tv2.Index++; tv2.Start();}
//	$("idPre").onclick = function(){tv2.Index--;tv2.Start();}
//	$("idFast").onclick = function(){ if(--tv2.Step <= 0){tv2.Step = 1;} }
//	$("idSlow").onclick = function(){ if(++tv2.Step >= 10){tv2.Step = 10;} }
//	$("idReduce").onclick = function(){ tv2.Pause-=1000; if(tv2.Pause <= 0){tv2.Pause = 0;} }
//	$("idAdd").onclick = function(){ tv2.Pause+=1000; if(tv2.Pause >= 5000){tv2.Pause = 5000;} }
//	
//	$("idReset").onclick = function(){
//		tv2.Step = Math.abs(tv2.options.Step);
//		tv2.Time = Math.abs(tv2.options.Time);
//		tv2.Auto = !!tv2.options.Auto;
//		tv2.Pause = Math.abs(tv2.options.Pause);
//	}
	
}
</script>
 
 
 
 
 
 <div class="blank5"></div>
<div class="blank"></div><div class="blank"></div>
<div class="block clearfix">
<script type="text/javascript">
  //初始化主菜单
	function sw_nav2(obj,tag)
	{
	var DisSub2 = document.getElementById("DisSub2_"+obj);
	var HandleLI2= document.getElementById("HandleLI2_"+obj);
		if(tag==1)
		{
			DisSub2.style.display = "block";
			HandleLI2.className="current";
		}
		else
		{
			DisSub2.style.display = "none";
			HandleLI2.className="";
		}
	}
</script>
 
    
<div id="category_tree"> 
	<dl class="clearfix" style=" margin-top:-457px;" >
     	        <div  class="dt"    onMouseOver="sw_nav2(1,1);" onMouseOut="sw_nav2(1,0);">        
        	<div id="HandleLI2_1">
        		<a class="a  " href="category.php?id=1">手机类型</a>
			</div>
        	<dd  id=DisSub2_1 style="display:none"> 
				 				<a class="over_2" href="category.php?id=2">CDMA手机</a>  
				<div class="clearfix">
                                    </div>   
       			 				<a class="over_2" href="category.php?id=3">GSM手机</a>  
				<div class="clearfix">
                                    </div>   
       			 				<a class="over_2" href="category.php?id=4">3G手机</a>  
				<div class="clearfix">
                                    </div>   
       			 				<a class="over_2" href="category.php?id=5">双模手机</a>  
				<div class="clearfix">
                                    </div>   
       						</dd> 
		</div>
		        <div  class="dt"    onMouseOver="sw_nav2(2,1);" onMouseOut="sw_nav2(2,0);">        
        	<div id="HandleLI2_2">
        		<a class="a t  " href="category.php?id=6">手机配件</a>
			</div>
        	<dd  id=DisSub2_2 style="display:none"> 
				 				<a class="over_2" href="category.php?id=7">充电器</a>  
				<div class="clearfix">
                                    </div>   
       			 				<a class="over_2" href="category.php?id=8">耳机</a>  
				<div class="clearfix">
                                    </div>   
       			 				<a class="over_2" href="category.php?id=9">电池</a>  
				<div class="clearfix">
                                    </div>   
       			 				<a class="over_2" href="category.php?id=11">读卡器和内存卡</a>  
				<div class="clearfix">
                                    </div>   
       						</dd> 
		</div>
		        <div  class="dt"    onMouseOver="sw_nav2(3,1);" onMouseOut="sw_nav2(3,0);">        
        	<div id="HandleLI2_3">
        		<a class="a  " href="category.php?id=12">充值卡</a>
			</div>
        	<dd  id=DisSub2_3 style="display:none"> 
				 				<a class="over_2" href="category.php?id=13">小灵通/固话充值卡</a>  
				<div class="clearfix">
                                    </div>   
       			 				<a class="over_2" href="category.php?id=14">移动手机充值卡</a>  
				<div class="clearfix">
                                    </div>   
       			 				<a class="over_2" href="category.php?id=15">联通手机充值卡</a>  
				<div class="clearfix">
                                    </div>   
       						</dd> 
		</div>
		 
	</dl>
</div><div class="AreaL">
 
<div id="mallNews"    class="  box_1">
    <h3><span>站内快讯</span></h3>
    <div class="NewsList tc  " style="border-top:none">
        <ul>
                <li>
      <a href="article.php?id=33" title="三星SGHU308说明书下载">三星SGHU308说明书下载</a>
        </li>
                <li>
      <a href="article.php?id=32" title="手机游戏下载">手机游戏下载</a>
        </li>
                <li>
      <a href="article.php?id=30" title="促销诺基亚N96">促销诺基亚N96</a>
        </li>
                <li>
      <a href="article.php?id=29" title="诺基亚5320 促销">诺基亚5320 促销</a>
        </li>
                <li>
      <a href="article.php?id=34" title="3G知识普及">3G知识普及</a>
        </li>
                <li>
      <a href="article.php?id=31" title="诺基亚6681手机广告欣赏">诺基亚6681手机广告欣赏</a>
        </li>
                <li>
      <a href="article.php?id=28" title="飞利浦9@9促销">飞利浦9@9促销</a>
        </li>
                <li>
      <a href="article.php?id=27" title="800万像素超强拍照机 LG Viewty Smart再曝光">800万像素超强拍照机 LG V...</a>
        </li>
                </ul>
    </div>
</div>
<div  class="blank"></div>  
554fcae493e564ee0dc75bdf2ebf94caads|a:3:{s:4:"name";s:3:"ads";s:2:"id";s:3:"159";s:3:"num";s:1:"0";}554fcae493e564ee0dc75bdf2ebf94ca
<div class="blank"></div>
</div>
<div class="Arear">
 
</div> 
  <div class="goodsBox_1">
  
  
  
<div class="xm-box">
<h4 class="title"><span>新品上架</span> <a class="more" href="search.php?intro=new">更多</a></h4>
<div id="show_new_area" class="clearfix">
      <div class="goodsItem">
       
           <a href="goods.php?id=9"><img src="images/200905/thumb_img/9_thumb_G_1241511871555.jpg" alt="诺基亚E66" class="goodsimg" /></a><br />
           <p class="f1"><a href="goods.php?id=9" title="诺基亚E66">诺基亚E66</a></p>
           
           
 市场价：<font class="market">￥2758元</font> <br/>
      
           本店价：<font class="f1">
                     ￥2298元                     </font>      
		    
        </div>
    <div class="goodsItem">
       
           <a href="goods.php?id=1"><img src="images/200905/thumb_img/1_thumb_G_1240902890710.jpg" alt="KD876" class="goodsimg" /></a><br />
           <p class="f1"><a href="goods.php?id=1" title="KD876">KD876</a></p>
           
           
 市场价：<font class="market">￥1666元</font> <br/>
      
           本店价：<font class="f1">
                     ￥1388元                     </font>      
		    
        </div>
    <div class="goodsItem">
       
           <a href="goods.php?id=8"><img src="images/200905/thumb_img/8_thumb_G_1241425513488.jpg" alt="飞利浦9@9v" class="goodsimg" /></a><br />
           <p class="f1"><a href="goods.php?id=8" title="飞利浦9@9v">飞利浦9@9v</a></p>
           
           
 市场价：<font class="market">￥479元</font> <br/>
      
           本店价：<font class="f1">
                     ￥399元                     </font>      
		    
        </div>
    <div class="goodsItem">
       
           <a href="goods.php?id=19"><img src="images/200905/thumb_img/19_thumb_G_1241970175208.jpg" alt="三星SGH-F258" class="goodsimg" /></a><br />
           <p class="f1"><a href="goods.php?id=19" title="三星SGH-F258">三星SGH-F...</a></p>
           
           
 市场价：<font class="market">￥1030元</font> <br/>
      
           本店价：<font class="f1">
                     ￥858元                     </font>      
		    
        </div>
    <div class="goodsItem">
       
           <a href="goods.php?id=20"><img src="images/200905/thumb_img/20_thumb_G_1242106490058.jpg" alt="三星BC01" class="goodsimg" /></a><br />
           <p class="f1"><a href="goods.php?id=20" title="三星BC01">三星BC01</a></p>
           
           
 市场价：<font class="market">￥336元</font> <br/>
      
           本店价：<font class="f1">
                     ￥280元                     </font>      
		    
        </div>
   
    </div>
</div>
<div class="blank"></div>
  <div class="xm-box">
<h4 class="title"><span>热卖商品</span> <a class="more" href="search.php?intro=hot">更多</a></h4>
<div id="show_hot_area" class="clearfix">
      <div class="goodsItem">
       
           <a href="goods.php?id=9"><img src="images/200905/thumb_img/9_thumb_G_1241511871555.jpg" alt="诺基亚E66" class="goodsimg" /></a><br />
           <p class="f1"><a href="goods.php?id=9" title="诺基亚E66">诺基亚E66</a></p>
           
           
 市场价：<font class="market">￥2758元</font> <br/>
      
           本店价：<font class="f1">
                     ￥2298元                     </font>      
		    
        </div>
    <div class="goodsItem">
       
           <a href="goods.php?id=1"><img src="images/200905/thumb_img/1_thumb_G_1240902890710.jpg" alt="KD876" class="goodsimg" /></a><br />
           <p class="f1"><a href="goods.php?id=1" title="KD876">KD876</a></p>
           
           
 市场价：<font class="market">￥1666元</font> <br/>
      
           本店价：<font class="f1">
                     ￥1388元                     </font>      
		    
        </div>
    <div class="goodsItem">
       
           <a href="goods.php?id=8"><img src="images/200905/thumb_img/8_thumb_G_1241425513488.jpg" alt="飞利浦9@9v" class="goodsimg" /></a><br />
           <p class="f1"><a href="goods.php?id=8" title="飞利浦9@9v">飞利浦9@9v</a></p>
           
           
 市场价：<font class="market">￥479元</font> <br/>
      
           本店价：<font class="f1">
                     ￥399元                     </font>      
		    
        </div>
    <div class="goodsItem">
       
           <a href="goods.php?id=13"><img src="images/200905/thumb_img/13_thumb_G_1241968002527.jpg" alt="诺基亚5320 XpressMusic" class="goodsimg" /></a><br />
           <p class="f1"><a href="goods.php?id=13" title="诺基亚5320 XpressMusic">诺基亚5320...</a></p>
           
           
 市场价：<font class="market">￥1573元</font> <br/>
      
           本店价：<font class="f1">
                     ￥1311元                     </font>      
		    
        </div>
    <div class="goodsItem">
       
           <a href="goods.php?id=14"><img src="images/200905/thumb_img/14_thumb_G_1241968492116.jpg" alt="诺基亚5800XM" class="goodsimg" /></a><br />
           <p class="f1"><a href="goods.php?id=14" title="诺基亚5800XM">诺基亚5800...</a></p>
           
           
 市场价：<font class="market">￥3150元</font> <br/>
      
           本店价：<font class="f1">
                     ￥2625元                     </font>      
		    
        </div>
   
    </div>
</div>
<div class="blank"></div>
  <div class="xm-box">
<h4 class="title"><span>精品推荐</span> <a class="more" href="search.php?intro=best">更多</a></h4>
<div id="show_best_area" class="clearfix">
      <div class="goodsItem">
       
           <a href="goods.php?id=9"><img src="images/200905/thumb_img/9_thumb_G_1241511871555.jpg" alt="诺基亚E66" class="goodsimg" /></a><br />
           <p class="f1"><a href="goods.php?id=9" title="诺基亚E66">诺基亚E66</a></p>
           
           
 市场价：<font class="market">￥2758元</font> <br/>
      
           本店价：<font class="f1">
                     ￥2298元                     </font>      
		    
        </div>
    <div class="goodsItem">
       
           <a href="goods.php?id=1"><img src="images/200905/thumb_img/1_thumb_G_1240902890710.jpg" alt="KD876" class="goodsimg" /></a><br />
           <p class="f1"><a href="goods.php?id=1" title="KD876">KD876</a></p>
           
           
 市场价：<font class="market">￥1666元</font> <br/>
      
           本店价：<font class="f1">
                     ￥1388元                     </font>      
		    
        </div>
    <div class="goodsItem">
       
           <a href="goods.php?id=8"><img src="images/200905/thumb_img/8_thumb_G_1241425513488.jpg" alt="飞利浦9@9v" class="goodsimg" /></a><br />
           <p class="f1"><a href="goods.php?id=8" title="飞利浦9@9v">飞利浦9@9v</a></p>
           
           
 市场价：<font class="market">￥479元</font> <br/>
      
           本店价：<font class="f1">
                     ￥399元                     </font>      
		    
        </div>
    <div class="goodsItem">
       
           <a href="goods.php?id=17"><img src="images/200905/thumb_img/17_thumb_G_1241969394587.jpg" alt="夏新N7" class="goodsimg" /></a><br />
           <p class="f1"><a href="goods.php?id=17" title="夏新N7">夏新N7</a></p>
           
           
 市场价：<font class="market">￥2760元</font> <br/>
      
           本店价：<font class="f1">
                     ￥2300元                     </font>      
		    
        </div>
    <div class="goodsItem">
       
           <a href="goods.php?id=19"><img src="images/200905/thumb_img/19_thumb_G_1241970175208.jpg" alt="三星SGH-F258" class="goodsimg" /></a><br />
           <p class="f1"><a href="goods.php?id=19" title="三星SGH-F258">三星SGH-F...</a></p>
           
           
 市场价：<font class="market">￥1030元</font> <br/>
      
           本店价：<font class="f1">
                     ￥858元                     </font>      
		    
        </div>
   
    </div>
</div>
<div class="blank"></div>
  <div class="xm-box">
<h4 class="title"><span></span> <a class="more" href="category.php?id=21">更多</a></h4>
<div id="show_hot_area" class="clearfix">
 
          </div>
 
 
</div>
<div class="blank"></div>
  </div> 
  
    </div>
  
  
  
 
    <a href="http://www.ecmoban.com" class="ecmoban">ecshop模板堂</a> 
<style>
#footer h3{text-align:left}
</style>
<div id="footer">
	<ul class="helper">
    	<li>
			<div class="helper-item">
				<i class="helper-icon icon-diamond"></i>
				<h3>甄选品牌 正品保障</h3>
			</div>
		</li>
        <li>
			<div class="helper-item">
				<i class="helper-icon icon-crown"></i>
				<h3>新款推荐 引领潮流</h3>
			</div>
		</li>
        <li>
			<div class="helper-item">
				<i class="helper-icon icon-lamp"></i>
				<h3>创意个性 特色特惠</h3>
			</div>
		</li>
        <li>
			<div class="helper-item">
				<i class="helper-icon icon-flower"></i>
				<h3>优质服务 无忧购物</h3>
			</div>
		</li>
    </ul>
        <div class="footer-link">
    	<ul>
        	 
                        <li>
            	<h3 class="title"><a>新手上路 </a></h3>
                            	<p><a href="article.php?id=9" target="_blank" title="售后流程">售后流程</a></p>
            	            	<p><a href="article.php?id=10" target="_blank" title="购物流程">购物流程</a></p>
            	            	<p><a href="article.php?id=11" target="_blank" title="订购方式">订购方式</a></p>
            	            </li>
                         
                        <li>
            	<h3 class="title"><a>手机常识 </a></h3>
                            	<p><a href="article.php?id=12" target="_blank" title="如何分辨原装电池">如何分辨原装电池</a></p>
            	            	<p><a href="article.php?id=13" target="_blank" title="如何分辨水货手机 ">如何分辨水货手机</a></p>
            	            	<p><a href="article.php?id=14" target="_blank" title="如何享受全国联保">如何享受全国联保</a></p>
            	            </li>
                         
                        <li>
            	<h3 class="title"><a>配送与支付 </a></h3>
                            	<p><a href="article.php?id=15" target="_blank" title="货到付款区域">货到付款区域</a></p>
            	            	<p><a href="article.php?id=16" target="_blank" title="配送支付智能查询 ">配送支付智能查询</a></p>
            	            	<p><a href="article.php?id=17" target="_blank" title="支付方式说明">支付方式说明</a></p>
            	            </li>
                         
                        <li>
            	<h3 class="title"><a>会员中心</a></h3>
                            	<p><a href="article.php?id=18" target="_blank" title="资金管理">资金管理</a></p>
            	            	<p><a href="article.php?id=19" target="_blank" title="我的收藏">我的收藏</a></p>
            	            	<p><a href="article.php?id=20" target="_blank" title="我的订单">我的订单</a></p>
            	            </li>
                         
                         
                                    <li class="footer-follow">
            	<h1 class="footer-logo">
                	<img src="themes/ecmoban_baiduMall/images/logo_reverse.png">
                </h1>
                <p class="slogan">ecmoban旗下电商，为您提供值得信赖的品质服务</p>
                <div class="follow">
                	关注我们
                    <i class="icon-weixin-logo icon-wechat">
						<span class="two-dimension-code"></span>
					</i>
					<a class="icon-weibo-logo icon-micro-blog" href="#" target="_blank"> </a>
					<a class="icon-weibo-logo icon-tieba" target="_blank" href="#"> </a>
                </div>
            </li>
        </ul>
    </div>
        <div class="footer-copyright">
    	<div>&copy; 2005-2016 LTMALL 版权所有，并保留所有权利。</div>
        <p align="center" style=" margin-top:10px"><a href=" http://www.ecmoban.com" target="_blank"><img src="themes/ecmoban_baiduMall/images/ecmoban.gif" alt="ECShop模板" /></a></p>
    </div>
</div>
<link href="ecmoban_qq/images/qq.css" rel="stylesheet" type="text/css" />
<div class="QQbox" id="divQQbox" style="width: 170px; ">
  <div class="Qlist" id="divOnline" onmouseout="hideMsgBox(event);" style="display: none; " onmouseover="OnlineOver();">
    <div class="t"></div>
    <div class="infobox">我们营业的时间<br>
      9:00-18:00</div>
    <div class="con">
      <ul>
        
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         
        
              </ul>
    </div>
    <div class="b"></div>
  </div>
  <div id="divMenu" onmouseover="OnlineOver();" style="display: block; "><img src="ecmoban_qq/images/qq_1.gif" class="press" alt="在线咨询"></div>
</div>
<script type="text/javascript">
//<![CDATA[
var tips; var theTop = 120/*这是默认高度,越大越往下*/; var old = theTop;
function initFloatTips() {
tips = document.getElementById('divQQbox');
moveTips();
};
function moveTips() {
var tt=50;
if (window.innerHeight) {
pos = window.pageYOffset
}
else if (document.documentElement && document.documentElement.scrollTop) {
pos = document.documentElement.scrollTop
}
else if (document.body) {
pos = document.body.scrollTop;
}
pos=pos-tips.offsetTop+theTop;
pos=tips.offsetTop+pos/10;
if (pos < theTop) pos = theTop;
if (pos != old) {
tips.style.top = pos+"px";
tt=10;
//alert(tips.style.top);
}
old = pos;
setTimeout(moveTips,tt);
}
//!]]>
initFloatTips();
function OnlineOver(){
document.getElementById("divMenu").style.display = "none";
document.getElementById("divOnline").style.display = "block";
document.getElementById("divQQbox").style.width = "170px";
}
function OnlineOut(){
document.getElementById("divMenu").style.display = "block";
document.getElementById("divOnline").style.display = "none";
}
if(typeof(HTMLElement)!="undefined")    //给firefox定义contains()方法，ie下不起作用
{   
      HTMLElement.prototype.contains=function(obj)   
      {   
          while(obj!=null&&typeof(obj.tagName)!="undefind"){ //通过循环对比来判断是不是obj的父元素
   　　　　if(obj==this) return true;   
   　　　　obj=obj.parentNode;
   　　}   
          return false;   
      };   
}  
function hideMsgBox(theEvent){ //theEvent用来传入事件，Firefox的方式
　 if (theEvent){
　 var browser=navigator.userAgent; //取得浏览器属性
　 if (browser.indexOf("Firefox")>0){ //如果是Firefox
　　 if (document.getElementById('divOnline').contains(theEvent.relatedTarget)) { //如果是子元素
　　 return; //结束函式
} 
} 
if (browser.indexOf("MSIE")>0){ //如果是IE
if (document.getElementById('divOnline').contains(event.toElement)) { //如果是子元素
return; //结束函式
}
}
}
/*要执行的操作*/
document.getElementById("divMenu").style.display = "block";
document.getElementById("divOnline").style.display = "none";
}
</script></body>
</html>