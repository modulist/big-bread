<div id="logoheader">
  <div id="logo">
    <?php echo $this->Html->image( 'logo.png', array( 'url' => Router::url( '/' ), 'title' => 'beta' ) ) ?>
  </div>
  <div id="nav-links">
    <ul id="menu">
      <!-- <li class="first"><?php echo $this->Html->link( 'Invite Friends', '#' ) ?></li> -->
      <!-- <li><?php echo $this->Html->link( 'Manage Profile', '#' ) ?></li> -->
      <!-- <li><?php echo $this->Html->link( 'Contact', Router::url( '/contact' ) ) ?></li> -->
      <?php if( $this->Session->check( 'Auth.User' ) ): ?>
        <li class="first last"><?php echo $this->Html->link( 'Logout', Router::url( '/logout' ) ) ?></li>
      <?php else: ?>
        <li class="first"><?php echo $this->Html->link( 'Login', Router::url( '/login' ) ) ?></li>
        <li class="last"><?php echo $this->Html->link( 'Register', Router::url( '/register' ) ) ?></li>
      <?php endif; ?>
    </ul>
  </div>
</div>

<div class="main-menu">
  <?php if( $this->Session->check( 'Auth.User' ) ): ?>
    <ul class="menu">
    	<li class="leaf"><a href="/users/dashboard">My Home</a></li>
    	<li class="leaf"><a href="/buildings/incentives">Ways to Save</a></li>
    	<li class="leaf"><a href="/questionnaire//equipment">Add Equipment</a></li>
    	<li class="leaf"><a href="/tools">Tools</a></li>
    </ul>
  <?php endif; ?>
</div>

<div class="clear"></div>
