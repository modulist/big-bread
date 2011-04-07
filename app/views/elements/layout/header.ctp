<div id="logoheader">
  <div id="version"><?php echo $this->Html->image( 'beta.png', array( 'title' => 'beta' ) ) ?></div>
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
        <li class="first"><?php echo $this->Html->link( 'Login', Router::url( '/login' ), array( 'rel' => 'modal' ) ) ?></li>
        <li class="last"><?php echo $this->Html->link( 'Register', Router::url( '/register' ), array( 'rel' => 'modal' ) ) ?></li>
      <?php endif; ?>
    </ul>
  </div>
</div>

<div class="menu">
  <div id="social_media">
    Follow us on
    <?php echo $this->Html->image( 'facebook.png', array( 'url' => '#', 'alt' => 'Follow us on Facebook', 'title' => 'Follow us on Facebook' ) ) ?>
    <?php echo $this->Html->image( 'twitter.png', array( 'url' => '#', 'alt' => 'Follow us on Twitter', 'title' => 'Follow us on Twitter' ) ) ?>
  </div>
  <?php if( $this->Session->check( 'Auth.User' ) ): ?>
    <div id="menubar">
      <?php echo $this->Html->image( 'menubtn1_off.png', array( 'url' => array( 'controller' => 'buildings', 'action' => 'incentives' ), 'alt' => 'Ways to Save', 'title' => 'Ways to Save' ) ) ?>
      <?php echo $this->Html->image( 'menubtn2_off.png', array( 'url' => Router::url( '/questionnaire' ), 'alt' => 'My House', 'title' => 'My House' ) ) ?>
      <?php echo $this->Html->image( 'menubtn3_off.png', array( 'url' => Router::url( '/contact' ), 'alt' => 'Feedback', 'title' => 'Feedback' ) ) ?>
    </div>
  <?php endif; ?>
</div>

<div class="clear"></div>
