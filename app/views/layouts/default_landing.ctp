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
			<h2>Replace an old appliance - and save!</h2>
			Find rebates >
			Need to replace an appliance, your A/C,  windows, or any other piece of 
equipment in your home?
			We’ll help you find not one, but multiple rebates when you’re looking for a replacement.
		</div>	  <!-- #column-first -->
		
		<div id="column-middle" class="grid-3">
		<h2>Set up a home profile for more savings.</h2>
		Set up a profile >
		Complete a profile of the equipment and appliances in your house, and you can be the first to know about recalls, and other rebates.

There are $2 billion in rebates and other  incentives waiting to be claimed by homeowners like you.
		</div>	 <!-- #column-middle -->
		
		<div id="column-last" class="grid-3">
		I never knew you could save this much!
		Annette B. , Washington, DC
		
		Before Big Bread, I’d  leave so much money on the table...
		Julian G., Orlando, FL
		
		Talk us up!
		
		Read our blog ›
		</div> <!-- #column-last -->

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
