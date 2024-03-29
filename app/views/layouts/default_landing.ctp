<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
  <?php echo $this->element( 'layout/head_content' ) ?>
</head>

<body class="layout-default_landing <?php echo Inflector::underscore( $this->name ) . ' ' . Inflector::underscore( $this->action ) ?><?php echo $this->Session->check( 'Auth.User' ) ? ' authenticated' : false ?>">

<div id="wrapper" class="container_12">
  <div id="content-top" class="content-top grid_12">
	  <div id="links" class="clearfix">
	    <?php if( Configure::read( 'Feature.contractor_registration.enabled' ) ): ?>
	      <div class="contractor-link">
	        <?php echo $this->Html->link( __( 'For contractors &rsaquo;', true ), array( 'controller' => 'contractors' ), array( 'escape' => false ) ) ?>
	      </div>
	    <?php endif; ?>
	  	<div class="other-link">
	      <?php echo $this->Html->link( __( 'Inspectors &rsaquo;', true ), array( 'controller' => 'users', 'action' => 'register', 'inspector' => true ), array( 'escape' => false ) ) ?>
	    </div>
	  	<div class="other-link">
	      <?php echo $this->Html->link( __( 'Realtors &rsaquo;', true ), array( 'controller' => 'users', 'action' => 'register', 'realtor' => true ), array( 'escape' => false ) ) ?>
	    </div>
	  </div>

    <div class="login-wrapper">
      <?php if( !$this->Session->check( 'Auth.User' ) ): ?>
        <?php __( 'Registered Users' ) ?>
        <div id="login-trigger"><?php echo $this->Html->link( __( 'Login &rsaquo;', true ), '#', array( 'escape' => false ) ) ?></div>
        <div id="login-popup" class="clearfix">
        	<div class="close-button-wrapper clearfix"><a class="close-button"></a></div>
          <?php echo $this->Form->create( 'User', array( 'action' => 'login', 'inputDefaults' => array( 'error' => false ) ) ) ?>
            <?php echo $this->Form->input( 'User.email', array( 'id' => 'login-token-1', 'autofocus' => 'true' ) ) ?>
            <?php echo $this->Form->input( 'User.password', array( 'id' => 'login-token-2' ) ) ?>
          <?php echo $this->Form->end( __( 'Login', true ), array( 'after' => 'Cancel' ) ) ?>
          <?php echo $this->Html->link( __( 'Cancel', true ), '#', array( 'class' =>'cancel-link' ) ) ?>

          <div class="password-recovery">
            <?php printf( __( 'Don&#146;t have an account? %s.', true ), $this->Html->link( __( 'Sign up now for free', true ), array( 'controller' => 'users', 'action' => 'register' ) ) ) ?>
            <?php echo $this->Html->link( __( 'Oops, I forgot my password', true ), array( 'controller' => 'users', 'action' => 'forgot_password' ), array ('class' => 'forgot-password') ) ?>
          </div>
        </div>
      <?php else: ?>
        <?php printf( __( 'Welcome back, %s', true ), $this->Session->read( 'Auth.User.first_name' ) ) ?>            
      <?php endif; ?>
    </div>
    <div id="content-top-inner">
      <div class="branding">
        <div id="logo"><?php echo $this->Html->image( 'logo-home-2.png' ) ?></div>
        <div id="slogan"><?php printf( __( 'Save Big Bread with<br />home energy rebates.%s', true ), $this->Html->image( 'beta.png', array( 'class' => 'beta' ) ) ) ?></div>
      </div>
      
      <div class="sample-rebate">
        <div class="house-signup">
          <p class="headline"><?php __( 'We&#146;ve found more than' ) ?></p>
          <p class="sample-rebate-amount"><span><?php echo $this->Number->format( $total_savings, array( 'places' => 0, 'before' => '$' ) ) ?></span>*</p>
          <p class="headline"><?php __( 'in savings in your area.' ) ?></p>
          
          <?php echo $this->Form->create( 'User', array( 'action' => 'register', 'type' => 'get' ) ) ?>
            <?php echo $this->Form->input( 'User.zip_code', array( 'label' => false, 'id' => 'zipcode', 'default' => $this->Session->read( 'default_zip_code' ), 'autocomplete' => 'off' ) ) ?>
          <?php echo $this->Form->end( array( 'label' => __( 'Sign up free &rsaquo;', true ), 'div' => false, 'id' => 'zipcode-submit', 'escape' => false ) ) ?>

          <p><?php printf( __( 'Not from %s%s%s? Update your zip code above', true ), '<strong class="zip-code-display">', $this->Session->read( 'default_zip_code' ), '</strong>' ) ?></p>
        </div>
      </div>
    </div>
  </div> <!-- /#content-top -->
  
  <?php echo $content_for_layout ?>
  
  <footer>
    <?php echo $this->element( 'layout/footer' ) ?>
  </footer> <!-- #footer -->
</div> <!-- #wrapper -->
  
<?php echo $this->element( 'layout/include_scripts' ) ?>

<!-- Include any layout scripts -->
<?php echo $scripts_for_layout . "\n" ?>
 
<?php if( isset( $this->params['url']['debug'] ) ): ?>
  <!-- DEBUG INFORMATION -->
  <?php echo $this->element( 'sql_dump' ) ?>
<?php endif; ?>

</body>
</html>
