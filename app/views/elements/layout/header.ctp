<div id="logoheader" class="clearfix">
  <div id="logo">
    <?php echo $this->Html->image( 'logo.png', array( 'url' => '/', 'title' => 'beta' ) ) ?>
  </div>
  <div id="nav-links">
    <ul id="menu">
      <?php if( $this->Session->check( 'Auth.User' ) ): ?>
        <li class="first last"><?php echo $this->Html->link( 'Logout', array( 'controller' => 'users', 'action' => 'logout', 'realtor' => false, 'inspector' => false ) ) ?></li>
      <?php else: ?>
        <li class="first"><?php echo $this->Html->link( 'Login', array( 'controller' => 'users', 'action' => 'login', 'realtor' => false, 'inspector' => false ) ) ?></li>
        <li class="last"><?php echo $this->Html->link( 'Sign up', array( 'controller' => 'users', 'action' => 'register' ) ) ?></li>
      <?php endif; ?>
    </ul>
  </div>
</div>

<div class="main-menu">
  <?php if( $this->Session->check( 'Auth.User' ) ): ?>
    <ul class="menu">
    	<li class="leaf"><?php echo $this->Html->link( 'Home', array( 'controller' => 'users', 'action' => 'dashboard', 'realtor' => false, 'inspector' => false ), array( 'class' => 'home' ) ) ?></li>
    	<li class="leaf"><?php echo $this->Html->link( 'Ways to Save', array( 'controller' => 'buildings', 'action' => 'ways_to_save', 'realtor' => false, 'inspector' => false ), array( 'class' => 'ways-to-save' ) ) ?></li>
    	<li class="leaf"><?php echo $this->Html->link( 'Add a Location', array( 'controller' => 'buildings', 'action' => 'add', 'realtor' => false, 'inspector' => false ), array( 'class' => 'location' ) ) ?></li>
    	<li class="leaf"><?php echo $this->Html->link( 'My Profile', array( 'controller' => 'users', 'action' => 'edit', 'realtor' => false, 'inspector' => false ), array( 'class' => 'profile' ) ) ?></li>
    </ul>
  <?php endif; ?>
</div>
