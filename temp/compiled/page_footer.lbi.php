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
    <?php if ($this->_var['helps']): ?>
    <div class="footer-link">
    	<ul>
        	<?php $_from = $this->_var['helps']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'help_cat');$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from AS $this->_var['help_cat']):
        $this->_foreach['foo']['iteration']++;
?> 
            <?php if ($this->_foreach['foo']['iteration'] < 5): ?>
            <li>
            	<h3 class="title"><a><?php echo $this->_var['help_cat']['cat_name']; ?></a></h3>
                <?php $_from = $this->_var['help_cat']['article']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
            	<p><a href="<?php echo $this->_var['item']['url']; ?>" target="_blank" title="<?php echo htmlspecialchars($this->_var['item']['title']); ?>"><?php echo $this->_var['item']['short_title']; ?></a></p>
            	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </li>
            <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
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
    <?php endif; ?>
    <div class="footer-copyright">
    	<div><?php echo $this->_var['copyright']; ?></div>
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
        
        <?php $_from = $this->_var['qq']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'im');if (count($_from)):
    foreach ($_from AS $this->_var['im']):
?> 
        <?php if ($this->_var['im']): ?>
        <li><a href="http://wpa.qq.com/msgrd?V=1&amp;Uin=<?php echo $this->_var['im']; ?>&amp;Site=<?php echo $this->_var['shop_name']; ?>&amp;Menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=1:<?php echo $this->_var['im']; ?>:4" height="16" border="0" alt="QQ" /> <?php echo $this->_var['im']; ?></a> </li>
        <?php endif; ?> 
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
        <?php $_from = $this->_var['ww']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'im');if (count($_from)):
    foreach ($_from AS $this->_var['im']):
?> 
        <?php if ($this->_var['im']): ?>
        <li><a href="http://amos1.taobao.com/msg.ww?v=2&uid=<?php echo urlencode($this->_var['im']); ?>&s=2" target="_blank"><img src="http://amos1.taobao.com/online.ww?v=2&uid=<?php echo urlencode($this->_var['im']); ?>&s=2" width="16" height="16" border="0" alt="淘宝旺旺" /><?php echo $this->_var['im']; ?></a></li>
        <?php endif; ?> 
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
        <?php $_from = $this->_var['ym']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'im');if (count($_from)):
    foreach ($_from AS $this->_var['im']):
?> 
        <?php if ($this->_var['im']): ?>
        <li><a href="http://edit.yahoo.com/config/send_webmesg?.target=<?php echo $this->_var['im']; ?>n&.src=pg" target="_blank"><img src="themes/ecmoban_baiduMall/images/yahoo.gif" width="18" height="17" border="0" alt="Yahoo Messenger" /> <?php echo $this->_var['im']; ?></a></li>
        <?php endif; ?> 
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
        <?php $_from = $this->_var['msn']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'im');if (count($_from)):
    foreach ($_from AS $this->_var['im']):
?> 
        <?php if ($this->_var['im']): ?>
        <li><img src="themes/ecmoban_baiduMall/images/msn.gif" width="18" height="17" border="0" alt="MSN" /> <a href="msnim:chat?contact=<?php echo $this->_var['im']; ?>"><?php echo $this->_var['im']; ?></a></li>
        <?php endif; ?> 
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
        <?php $_from = $this->_var['skype']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'im');if (count($_from)):
    foreach ($_from AS $this->_var['im']):
?> 
        <?php if ($this->_var['im']): ?>
        <li><img src="http://mystatus.skype.com/smallclassic/<?php echo urlencode($this->_var['im']); ?>" alt="Skype" /><a href="skype:<?php echo urlencode($this->_var['im']); ?>?call"><?php echo $this->_var['im']; ?></a></li>
        <?php endif; ?> 
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
        
        <?php if ($this->_var['service_phone']): ?>
        <li> 服务热线: <?php echo $this->_var['service_phone']; ?></li>
        <?php endif; ?>
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
</script>





















 

 
