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
	          <input type="text" id="zipcode" name="zipcode" value="33156" />
	          <input type="submit" value="Enter&rsaquo;" alt="Enter" />
	        </form>
	      	<p><?php __( 'Not from <strong>33156</strong>? Update your zip code above' ) ?></p>
	      </div>  
    	</div>
    </div>
  </div> <!-- /#content-top -->
    
  <div id="content-bottom" class="content-bottom grid_10 clearfix">
    <div id="column-first" class="grid_3">
      <h3><?php __( '*Here&#146;s how it works:' ) ?></h3>
      <div class="green-dot-divider">
        <?php echo $this->Html->image( 'green-dot-divider.png' ) ?>
      </div>     
      
      <?php //echo $this->Html->image( 'appliance-icon.png', array( 'class' => 'floatRight' ) ) ?>
      
      <p><?php __( 'There are $2 billion in energy credits and rebates available from utilities as well as federal, state, and local governments' ) ?></p>   
      <p><?php __( 'Here are just some of the available rebates for HVAC systems in <br /><strong>Fort Lauderdale, FL</strong>:' ) ?></p>
      <table class="rebates-preview">
      	<tr class="odd">
      		<td class="rebate-source">Florida Power and Light</td>
      		<td class="rebate-amount">$1,930</td>
      	</tr>
      	<tr class="even">
      		<td class="rebate-source">Lennox</td>
      		<td class="rebate-amount">$1,200</td>      	
      	</tr>
      	<tr class="odd">
      		<td class="rebate-source">Carrier Infinity</td>
      		<td class="rebate-amount">$1,000</td>
      	</tr>
      	<tr class="even">
      		<td class="rebate-source">Rheem</td>
      		<td class="rebate-amount">$1,000</td>      	
      	</tr>
      	<tr class="odd">
      		<td class="rebate-source">Trane</td>
      		<td class="rebate-amount">$1,000</td>
      	</tr>
      </table>
      <p><?php __( 'Enter our site and find more ways to save through rebates' ) ?></p>
    </div>    <!-- /#column-first -->
    
    <div id="column-middle" class="grid_3">
      <h3><?php __( 'Find a contractor' ) ?></h3>
      <div class="green-dot-divider">
        <?php echo $this->Html->image( 'green-dot-divider.png' ) ?>
      </div>      
      <p><?php __( 'Big Bread can help you get quotes from contractors in your area &ndash; free of charge' ) ?></p>
      
      <?php //echo $this->Html->image( 'rebate-money-icon.png', array( 'class' => 'floatRight' ) ) ?>
      
      <h3><?php __( 'Redeem a rebate' ) ?></h3>
      <div class="green-dot-divider">
        <?php echo $this->Html->image( 'green-dot-divider.png' ) ?>
      </div>
      <p><?php __( 'Tell us about your purchase and upload a scan of the invoice, and we&#146;ll handle the rest for you.' ) ?></p>

      <div class="green-dot-divider">
        <?php echo $this->Html->image( 'green-dot-divider.png' ) ?>
      </div>
      
      <div id="blog-link">
        <h3><?php echo $this->Html->link( __( 'Read our blog &rsaquo;', true ), '/blog', array( 'escape' => false ) ) ?></h3>
      </div><!-- /#blog-link -->

    </div>   <!-- /#column-middle -->
    
    
    
    <div id="column-last" class="grid_3">
      <div id="testimonials">
        <div class="testimonial-item">
          <div class="testimonial-quote">
            <span class="testimonial-quote-mark">&ldquo;</span>I never knew you could save this much!<span class="testimonial-quote-mark">&rdquo;</span>
          </div>
          <div class="testimonial-source">
            Annette B. , Washington, DC
          </div>  
        </div> <!-- /item -->
        
        <div class="testimonial-item">
          <div class="testimonial-quote">
            <span class="testimonial-quote-mark">&ldquo;</span>Before Big Bread, I&#146;d  leave so much money on the table...<span class="testimonial-quote-mark">&rdquo;</span>
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
