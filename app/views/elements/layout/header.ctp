<div id="logoheader" class="clearfix">
  <div id="logo">
    <?php echo $this->Html->image( 'logo.png', array( 'url' => '/', 'title' => 'beta' ) ) ?>
  </div>
  <div id="nav-links">
    <ul id="menu">
      <?php if( $this->Session->check( 'Auth.User' ) ): ?>
        <li class="first last"><?php echo $this->AppHtml->cleanLink( 'Logout', array( 'controller' => 'users', 'action' => 'logout' ) ) ?></li>
      <?php else: ?>
        <li class="first"><?php echo $this->AppHtml->cleanLink( 'Login', array( 'controller' => 'users', 'action' => 'login' ), array ( 'class' => 'login') ) ?></li>
        <li class="last"><?php echo $this->Html->link( 'Sign up', array( 'controller' => 'users', 'action' => 'register' ), array ( 'class' => 'signup') ) ?></li>
      <?php endif; ?>
    </ul>
  </div>
</div>

<div class="main-menu">
  <?php if( $this->Session->check( 'Auth.User' ) ): ?>
    <ul class="menu">
    	<li class="leaf"><?php echo $this->AppHtml->cleanLink( 'Home', Configure::read( 'nav.home' ), array( 'class' => 'home' ) ) ?></li>
    	<li class="leaf"><?php echo $this->AppHtml->cleanLink( 'Ways to Save', array( 'controller' => 'buildings', 'action' => 'ways_to_save' ), array( 'class' => 'ways-to-save' ) ) ?></li>
      <?php if( !User::agent() ): # If user is an agent, this is the homepage ?>
        <li class="leaf"><?php echo $this->AppHtml->cleanLink( 'Add a Location', array( 'controller' => 'buildings', 'action' => 'add' ), array( 'class' => 'location' ) ) ?></li>
      <?php endif; ?>
    	<li class="leaf"><?php echo $this->AppHtml->cleanLink( 'My Profile', array( 'controller' => 'users', 'action' => 'edit' ), array( 'class' => 'profile' ) ) ?></li>
    </ul>
  <?php endif; ?>
</div>
