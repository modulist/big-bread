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
	  
	  
	</div> <!-- /#content-top -->
	  
	<div id="content-bottom" class="content-bottom">
		<div id="column-first" class="grid-3">
			<h2>Replace an old appliance - and save!</h2>
			<a class="button-home" href="/users/register">Find rebates</a>
			Need to replace an appliance, your A/C,  windows, or any other piece of equipment in your home?
			We&#146;ll help you find not one, but multiple rebates when you&#146;re looking for a replacement.
		</div>	  <!-- /#column-first -->
		
		<div id="column-middle" class="grid-3">
		<h2>Set up a home profile for more savings.</h2>
			<a class="button-home" href="/users/register">Set up a profile</a>
			Complete a profile of the equipment and appliances in your house, and you can be the first to know about recalls, and other rebates.
			There are $2 billion in rebates and other  incentives waiting to be claimed by homeowners like you.
		</div>	 <!-- /#column-middle -->
		
		
		
		<div id="column-last" class="grid-3">
			<div id="testimonials">
				<div class="testimonial-item">
					<div class="testimonial-quote">
						I never knew you could save this much!
					</div>
					<div class="testimonial-source">
						Annette B. , Washington, DC
					</div>	
				</div> <!-- /item -->
				
				<div class="testimonial-item">
					<div class="testimonial-quote">
						Before Big Bread, I&#146;d  leave so much money on the table...
					</div>
					<div class="testimonial-source">
						Julian G., Orlando, FL
					</div>	
				</div> <!-- /item -->
			</div> <!-- /testimonials -->
		
			<div id="social-media">
				<h2>Talk us up!</h2>
				<div class="icon-grid">
					<div id="google-plus" class="icon">
						<a href="http://google.com/plus" rel="nofollow"><img src="../img/icon-google-plus.png" alt="Google Plus"></a>
					</div>
					<div id="facebook" class="icon">
						<a href="http://www.facebook.com" rel="nofollow"><img src="../img/icon-facebook.png" alt="Facebook"></a>
					</div>
					<div id="twitter" class="icon">
						<a href="http://www.twitter.com/savebigbread" rel="nofollow"><img src="../img/icon-twitter.png" alt="Twitter"></a>
					</div>
				</div> <!-- /icon-grid -->
			</div> <!-- /social media -->		
		
			<div id="blog-link">
				<a href="/blog">Read our blog &rsaquo;</a>
			</div><!-- /#blog-link -->

		</div> <!-- /#column-last -->

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
