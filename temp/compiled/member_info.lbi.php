
<?php if ($this->_var['user_info']): ?>

<ul class="user-command active">
	<li><?php echo $this->_var['lang']['welcome']; ?></li>
    <li class="userinfo">
    	<a target="_blank" href="user.php">
			Hi，
			<span class="username"><?php echo $this->_var['user_info']['username']; ?></span>
		</a>
    </li>
    <li class="logout"><a id="logout" href="user.php?act=logout"> 退出 </a></li>
    <?php if ($this->_var['navigator_list']['top']): ?>
    <?php $_from = $this->_var['navigator_list']['top']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav_0_57745500_1463982639');$this->_foreach['nav_top_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_top_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav_0_57745500_1463982639']):
        $this->_foreach['nav_top_list']['iteration']++;
?>
    <li><a href="<?php echo $this->_var['nav_0_57745500_1463982639']['url']; ?>" <?php if ($this->_var['nav_0_57745500_1463982639']['opennew'] == 1): ?> target="_blank" <?php endif; ?>><?php echo $this->_var['nav_0_57745500_1463982639']['name']; ?></a></li>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   	<?php endif; ?>
    <li><a href="user.php"> 个人中心 </a></li>
</ul>
 
  <?php else: ?> 
  
<ul class="user-command">
	<li><?php echo $this->_var['lang']['welcome']; ?></li>
    <li class="login"><a class="login" href="user.php"> 请登录 </a></li>
    <li class="register"><a name="register" href="user.php?act=register"> 免费注册 </a></li>
    <?php if ($this->_var['navigator_list']['top']): ?>
    <?php $_from = $this->_var['navigator_list']['top']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav_0_57845500_1463982639');$this->_foreach['nav_top_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_top_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav_0_57845500_1463982639']):
        $this->_foreach['nav_top_list']['iteration']++;
?>
    <li><a href="<?php echo $this->_var['nav_0_57845500_1463982639']['url']; ?>" <?php if ($this->_var['nav_0_57845500_1463982639']['opennew'] == 1): ?> target="_blank" <?php endif; ?>><?php echo $this->_var['nav_0_57845500_1463982639']['name']; ?></a></li>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   	<?php endif; ?>
    <li><a href="user.php"> 个人中心 </a></li>
</ul>
 
 
 <?php endif; ?>