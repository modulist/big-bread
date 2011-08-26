<!DOCTYPE html>
<html lang="en">
<head>
  <?php echo $this->element( 'layout/head_content' ) ?>
</head>

<body class="front <?php echo Inflector::underscore( $this->name ) . ' ' . Inflector::underscore( $this->action ) ?><?php echo $this->Session->check( 'Auth.User' ) ? ' authenticated' : false ?>">
<!-- default_landing.ctp -->
  
<div id="wrapper" class="container_12">
  <div id="content-top" class="content-top grid_12">
    <?php //echo $this->element( 'layout/flash_messages' ) ?>
    <div class="branding">
    <img src="img/home-logo.png" />
    </div>
    
    <div class="background-elements">
    <img src="img/home-top-content-trees.png" />
    </div>
    
    <div class="slide-show">
    	<div class="house-signup"><h2>Start saving today!</h2>
    	<form>
    	<input type="text" name="name" value="Your name" /><br />
    	<input type="text" name="email" value="Your email address">
    	<input type="image" src="img/home-top-content-house-arrow.png" value="Submit" alt="Submit" class="submit">
    	</form>
    	</div>
    </div>
    
    
  </div> <!-- /#content-top -->
    
  <div id="content-bottom" class="content-bottom grid_10 clearfix">
    <div id="column-first" class="grid_3">
      <h2><?php __( 'Replace an old appliance - and save!' ) ?></h2>
      	<div class="green-dot-divider"><img src="img/green-dot-divider.png" /></div>
      	<div class="button-home"><span class="button-home-text">Find rebates</span></div>
      	<img src="img/applicance-icon.png" class="floatRight" />	
      <p><?php __( 'Need to replace an appliance, your A/C, windows, or any other piece of equipment in your home?' ) ?></p>   
      <p><?php __( 'We&#146;ll help you find not one, but multiple rebates when you&#146;re looking for a replacement.' ) ?></p>
    </div>    <!-- /#column-first -->
    
    <div id="column-middle" class="grid_3">
    <h2><?php __( 'Set up a home profile for more savings.' ) ?></h2>
    <div class="green-dot-divider"><img src="img/green-dot-divider.png" /></div>
      <div class="button-home"><span class="button-home-text">Set up a profile</span></div>    
      <p><?php __( 'Complete a profile of the equipment and appliances in your house, and you can be the first to know about recalls, and other rebates.' ) ?></p>
      <img src="img/rebate-money-icon.png" class="floatRight" />
      <p><?php __( 'There are $2 billion in rebates and other incentives waiting to be claimed by homeowners like you.' ) ?></p>
    </div>   <!-- /#column-middle -->
    
    
    
    <div id="column-last" class="grid_3">
    <div class="green-dot-divider"><img src="img/green-dot-divider.png" /></div>
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
      <div class="green-dot-divider"><img src="img/green-dot-divider.png" /></div>
    
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
    <div class="green-dot-divider"><img src="img/green-dot-divider.png" /></div>
      <div id="blog-link">
        <a href="/blog">Read our blog &rsaquo;</a>
      </div><!-- /#blog-link -->

    </div> <!-- /#column-last -->

    <?php //echo $content_for_layout ?>
  </div> <!-- #content-bottom -->
  <div id="page-bottom"><img src="img/home-page-bottom.gif" /></div>
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
