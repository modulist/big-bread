<div id="logoheader">
  <div id="logo">
    <?php echo $this->Html->image( 'logo.png', array( 'url' => '/', 'title' => 'beta' ) ) ?>
  </div>
  <div id="nav-links">
    <ul id="menu">
      <?php if( $this->Session->check( 'Auth.User' ) ): ?>
        <li class="first last"><?php echo $this->Html->link( 'Logout', array( 'controller' => 'users', 'action' => 'logout' ) ) ?></li>
      <?php else: ?>
        <li class="first"><?php echo $this->Html->link( 'Login', array( 'controller' => 'users', 'action' => 'login' ) ) ?></li>
        <li class="last"><?php echo $this->Html->link( 'Register', array( 'controller' => 'users', 'action' => 'register' ) ) ?></li>
      <?php endif; ?>
    </ul>
  </div>
</div>

<div class="main-menu">
  <?php if( $this->Session->check( 'Auth.User' ) ): ?>
    <ul class="menu">
    	<li class="leaf"><?php echo $this->Html->link( 'My Home', array( 'controller' => 'users', 'action' => 'dashboard' ) ) ?></li>
    	<li class="leaf"><?php echo $this->Html->link( 'Ways to Save', array( 'controller' => 'buildings', 'action' => 'ways_to_save' ) ) ?></li>
    	<li class="leaf"><?php echo $this->Html->link( 'Add a Location', array( 'controller' => 'buildings', 'action' => 'add' ) ) ?></li>
    	<li class="leaf"><?php echo $this->Html->link( 'Add Equipment', array( 'controller' => 'buildings', 'action' => 'equipment' ) ) ?></li>
    	<li class="leaf"><?php echo $this->Html->link( 'Tools', '#' ) ?></li>
    </ul>
  <?php endif; ?>
</div>
