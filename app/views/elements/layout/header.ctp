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
    	<li class="leaf"><a href="/users/dashboard">My Home</a></li>
    	<li class="leaf"><a href="/buildings/incentives">Ways to Save</a></li>
    	<li class="leaf"><a href="/questionnaire//equipment">Add Equipment</a></li>
    	<li class="leaf"><a href="/tools">Tools</a></li>
    </ul>
  <?php endif; ?>
</div>
