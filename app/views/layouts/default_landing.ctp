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
    <div class="branding">
      <?php echo $this->Html->image( 'home-logo.png' ) ?>
    </div>
    
    <div class="background-elements">
      <?php echo $this->Html->image( 'home-top-content-trees.png' ) ?>
    </div>
    
    <div class="slide-show">
    	<div class="house-signup">
        <h2><?php __( 'Start saving today!' ) ?></h2>
        <?php # TODO: Replace this with form helper ?>
        <form>
          <input type="text" name="name" value="Your name" /><br />
          <input type="text" name="email" value="Your email address"><br />
          <input type="image" src="img/home-top-content-house-arrow.png" value="Submit" alt="Submit" class="submit">
        </form>
    	</div>
    </div>
  </div> <!-- /#content-top -->
    
  <div id="content-bottom" class="content-bottom grid_10 clearfix">
    <div id="column-first" class="grid_3">
      <h2><?php __( 'Replace an old appliance - and save!' ) ?></h2>
      <div class="green-dot-divider">
        <?php echo $this->Html->image( 'green-dot-divider.png' ) ?>
      </div>
      <div class="button-home">
        <div class="button-home-text"><?php __( 'Find rebates' ) ?></div>
      </div>
      
      <?php echo $this->Html->image( 'appliance-icon.png', array( 'class' => 'floatRight' ) ) ?>
      
      <p><?php __( 'Need to replace an appliance, your A/C, windows, or any other piece of equipment in your home?' ) ?></p>   
      <p><?php __( 'We&#146;ll help you find not one, but multiple rebates when you&#146;re looking for a replacement.' ) ?></p>
    </div>    <!-- /#column-first -->
    
    <div id="column-middle" class="grid_3">
      <h2><?php __( 'Set up a home profile for more savings.' ) ?></h2>
      <div class="green-dot-divider">
        <?php echo $this->Html->image( 'green-dot-divider.png' ) ?>
      </div>
      <div class="button-home">
        <div class="button-home-text"><?php __( 'Set up a profile' ) ?></div>
      </div>    
      
      <p><?php __( 'Complete a profile of the equipment and appliances in your house, and you can be the first to know about recalls, and other rebates.' ) ?></p>
      
      <?php echo $this->Html->image( 'rebate-money-icon.png', array( 'class' => 'floatRight' ) ) ?>
      
      <p><?php __( 'There are $2 billion in rebates and other incentives waiting to be claimed by homeowners like you.' ) ?></p>
    </div>   <!-- /#column-middle -->
    
    
    
    <div id="column-last" class="grid_3">
      <div class="green-dot-divider">
        <?php echo $this->Html->image( 'green-dot-divider.png' ) ?>
      </div>
      <div id="testimonials">
        <div class="testimonial-item">
          <div class="testimonial-quote">
            <span class="testimonial-quote-mark">"</span>I never knew you could save this much!<span class="testimonial-quote-mark">"</span>
          </div>
          <div class="testimonial-source">
            Annette B. , Washington, DC
          </div>  
        </div> <!-- /item -->
        
        <div class="testimonial-item">
          <div class="testimonial-quote">
            <span class="testimonial-quote-mark">"</span>Before Big Bread, I&#146;d  leave so much money on the table...<span class="testimonial-quote-mark">"</span>
          </div>
          <div class="testimonial-source">
            Julian G., Orlando, FL
          </div>  
        </div> <!-- /item -->
        <div class="testimonial-item">
          <div class="add-story"><?php __( 'Add your Big Bread story &rsaquo;' ) ?></div> 	
        </div> <!-- /item -->
      </div> <!-- /testimonials -->
      <div class="green-dot-divider">
        <?php echo $this->Html->image( 'green-dot-divider.png' ) ?>
      </div>
    
      <div id="social-media">
        <div id="microphone">
          <?php echo $this->Html->image( 'home-microphone-icon.png' ) ?>
        </div>
        <h3><?php __( 'Talk us up!' ) ?></h3>
        <div class="icon-grid">
          <div id="google-plus" class="icon">
            <?php echo $this->Html->link( $this->Html->image( 'icon-google-plus.png', array( 'alt' => 'Google Plus' ) ), 'http://google.com/plus', array( 'rel' => 'no-follow', 'escape' => false ) ) ?>
          </div>
          <div id="facebook" class="icon">
            <?php echo $this->Html->link( $this->Html->image( 'icon-facebook.png', array( 'alt' => 'Facebook' ) ), 'http://www.facebook.com', array( 'rel' => 'no-follow', 'escape' => false ) ) ?>
          </div>
          <div id="twitter" class="icon">
            <?php echo $this->Html->link( $this->Html->image( 'icon-twitter.png', array( 'alt' => 'Twitter' ) ), 'http://www.twitter.com/savebigbread', array( 'rel' => 'no-follow', 'escape' => false ) ) ?>
          </div>
        </div> <!-- /icon-grid -->
      </div> <!-- /social media -->   
      
      <div class="green-dot-divider">
        <?php echo $this->Html->image( 'green-dot-divider.png' ) ?>
      </div>
      
      <div id="blog-link">
        <h3><?php echo $this->Html->link( __( 'Read our blog &rsaquo;', true ), '/blog', array( 'escape' => false ) ) ?></h3>
      </div><!-- /#blog-link -->

    </div> <!-- /#column-last -->

    <?php //echo $content_for_layout ?>
  </div> <!-- #content-bottom -->
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
