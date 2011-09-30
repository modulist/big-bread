<!DOCTYPE html>
<html lang="en">
<head>
  <?php echo $this->element( 'layout/head_content' ) ?>
</head>

<body class="front <?php echo Inflector::underscore( $this->name ) . ' ' . Inflector::underscore( $this->action ) ?><?php echo $this->Session->check( 'Auth.User' ) ? ' authenticated' : false ?>">
<!-- default_landing.ctp -->
  
<div id="wrapper" class="container_12">
  
  <?php echo $this->Html->link( 'Signup Form', array( 'controller' => 'users', 'action' => 'register' ) ) ?>
  
  <div id="content-top" class="content-top grid_12">
  	<div class="login-wrapper">
  		Registered Users
  		<div id="login-trigger"><a href="#">Log in &rsaquo;</a></div>
  		<div id="login-popup" class="clearfix">
  			<form>
  				<div class="instructions">Log in as a registered user:</div>
  				<input type="text" id="login-token-1" name="username" value="Email or username" />
  				<input type="password" id="login-token-2" name="password" value="Password" />
  				<input type="submit" value="Log in" />
  				<div class="password-recovery">Don&#146;t have an account? <a href="/signup">Click here</a> to sign up.</div>
  			</form>
  		</div>
  	</div>
  	<div id="content-top-inner">
	    <div class="branding">
	    	<div id="logo"><?php echo $this->Html->image( 'logo-home-2.png' ) ?></div>
	      <div id="slogan"><?php __( 'Save Big Bread with<br />home energy rebates.' ) ?></div>
	    </div>
	    
	    <div class="sample-rebate">
	    	<div class="house-signup">
	      	<p class="headline"><?php __( 'We&#146;ve found more than' ) ?></p>
	      	<p class="sample-rebate-amount"><?php __( '$6,130*' ) ?></p>
	      	<p class="headline"><?php __( 'in savings in your area.' ) ?></p>
	    		
	        <?php # TODO: Replace this with form helper ?>
	        <form>
	          <input type="text" id="zipcode" name="zipcode" value="<?php echo $this->Session->read( 'default_zip_code' ) ?>" />
	          <input type="submit" id="zipcode-submit" value="Enter&rsaquo;" alt="Enter" />
	        </form>
	      	<p><?php printf( __( 'Not from %s%d%s? Update your zip code above', true ), '<strong>', $this->Session->read( 'default_zip_code' ), '</strong>' ) ?></p>
	      </div>  
    	</div>
    </div>
  </div> <!-- /#content-top -->
  
  <?php echo $content_for_layout ?>
  
  <div id="page-bottom">
    <?php echo $this->Html->image( 'home-page-bottom.gif' ) ?>
  </div>
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
