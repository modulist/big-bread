<div id="topheader">
  <div id="version"><?php echo $this->Html->image( 'beta.png', array( 'title' => 'beta' ) ) ?></div>
  <div id="logo">
    <?php echo $this->Html->image( 'logo.png', array( 'url' => Router::url( '/' ), 'title' => 'beta' ) ) ?>
  </div>
  <div id="nav-links">
    <ul id="menu">
      <li class="first"><?php echo $this->Html->link( 'Invite Friends', '#' ) ?></li>
      <li><?php echo $this->Html->link( 'Manage Profile', '#' ) ?></li>
      <li><?php echo $this->Html->link( 'Contact', Router::url( '/contact' ) ) ?></li>
      <li class="last"><?php echo $this->Html->link( 'Logout', Router::url( '/logout' ) ) ?></li>
    </ul>
  </div>
</div>

<?php # if( $this->Auth->user() ): ?>
  <div class="menu">
    <div id="menubar">
      <a href="#"><?php echo $this->Html->image( 'menubtn1.png' ) ?></a>
      <a href="#" ><?php echo $this->Html->image( 'menubtn2.png' ) ?></a>  
    </div>
  </div>
<?php # endif; ?>
