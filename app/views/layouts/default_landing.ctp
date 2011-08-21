<!DOCTYPE html>
<html lang="en">
<head>
  <?php echo $this->element( 'layout/head_content' ) ?>
</head>

<body class="front <?php echo Inflector::underscore( $this->name ) . ' ' . Inflector::underscore( $this->action ) ?><?php echo $this->Session->check( 'Auth.User' ) ? ' authenticated' : false ?>">
<!-- default_landing.ctp -->
  
<div id="wrapper">
	<div id="content-top" class="content-top">
	  <?php //echo $this->element( 'layout/flash_messages' ) ?>
		<div class="branding">
		
		</div>
	  
	  <div class="background-elements">
	  </div>
	  
	  <div class="slide-show">
	  
	  </div>
	  
	  
	</div> <!-- #content-top -->
	  
	<div id="content-bottom" class="content-bottom">
		<div id="column-first" class="grid-3">
		</div>	  
		<div id="column-middle" class="grid-3">
		</div>	  
		<div id="column-last" class="grid-3">
		</div>	  

	  <?php //echo $content_for_layout ?>
	</div> <!-- #content-bottom -->
	<div class="clear"></div>
  
  <div id="footer">
    <?php echo $this->element( 'layout/footer' ) ?>
  </div> <!-- #footer -->
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
