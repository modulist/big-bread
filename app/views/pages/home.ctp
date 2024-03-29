<?php $this->set( 'title_for_layout', __( 'Save Big Bread with home energy rebates.', true ) ) ?>
 
<div id="content-bottom" class="content-bottom grid_10 clearfix">
	<div class="content-wrapper clearfix">
	  <div id="column-first" class="grid_3">
	    <h3 class="title"><?php __( '*Here&#146;s how it works:' ) ?></h3>
	    <h3><?php __( '1. Find savings' ) ?></h3>
	    <div class="green-dot-divider">
	      <?php echo $this->Html->image( 'green-dot-divider.png' ) ?>
	    </div>     
	    <p><?php __( 'Over $2 billion in manufacturer, utility and government energy efficient, home improvement is available for homeowners on SaveBigBread.' ) ?></p>   
	    <p><?php printf( __( 'Here are just some of the available rebates for HVAC systems in %s:', true ), '<br /><span class="rebate-city">' . h( $locale['ZipCode']['city'] ) . ', ' . h( $locale['ZipCode']['state'] ) . '</span>' ) ?></p>
	    <table class="rebates-preview">
	      <?php $i = 0 ?>
	      <?php foreach( $featured_rebates as $name => $amount ): ?>
	        <tr class="<?php echo $i++ % 2 === 0 ? 'even' : 'odd' ?>">
	          <td class="rebate-source" title="<?php echo h( preg_replace( '/-.+$/', '', $name ) ) ?>"><?php echo h( $this->Text->truncate( preg_replace( '/\s*-.+$/', '', $name ), 25, array( 'ending' => '...', 'exact' => false ) ) ) ?></td>
	          <td class="rebate-amount"><?php echo h( $this->Number->format( $amount, array( 'before' => '$', 'places' => 2 ) ) ) ?></td>
	        </tr>
	      <?php endforeach; ?>
	    </table>
	    <p><?php echo $this->Html->link( __( 'Sign up free', true ), array( 'controller' => 'users', 'action' => 'register' ) ) . __( ' and find more ways to save through rebates.', true ) ?></p>
	  </div>    <!-- /#column-first -->
	  
	  <div id="column-middle" class="grid_3">
	    <h3><?php __( '2. Find a contractor' ) ?></h3>
	    <div class="green-dot-divider">
	      <?php echo $this->Html->image( 'green-dot-divider.png' ) ?>
	    </div>      
	    <p><?php __( 'Homeowners use SaveBigBread to get free quotes from rebate program authorized contractors. Only select contractors can offer all of the rebates to you.' ) ?></p>
	    
	    <h3><?php __( '3. Redeem a rebate' ) ?></h3>
	    <div class="green-dot-divider">
	      <?php echo $this->Html->image( 'green-dot-divider.png' ) ?>
	    </div>
	    <p><?php __( 'Tell us about your purchase, send us your invoice and we\'ll handle the rest for you.' ) ?></p>

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
	    
	    <div class="signup-button"><?php echo $this->Html->link( __( 'Sign up free &rsaquo;', true ), array( 'controller' => 'users', 'action' => 'register' ), array( 'escape' => false ) ) ?></div>
	
	    <!--<div id="blog-link">
	      <h3><?php echo $this->Html->link( __( 'Read our blog &rsaquo;', true ), 'http://www.savebigbread.com', array( 'escape' => false ) ) ?></h3>
	    </div><!-- /#blog-link -->
	  </div>   <!-- /#column-middle -->
	  
	  <div id="column-last" class="grid_3">
	    <div id="testimonials">
	      <div class="testimonial-item">
	        <div class="testimonial-quote">
	          <div class="testimonial-quote-mark">&ldquo;</div><?php __( 'SaveBigBread ...saved my $750 rebate.' ) ?><div class="testimonial-quote-mark">&rdquo;</div>
	        </div>
	        <div class="testimonial-source">
	          Owen B., Falls Church VA
	        </div>  
	      </div> <!-- /item -->
	
	      <div class="testimonial-item">
	        <div class="testimonial-quote">
	          <div class="testimonial-quote-mark">&ldquo;</div><?php __( 'SaveBigBread saved us $2,100 and made what could have been a painful process manageable.' ) ?><div class="testimonial-quote-mark">&rdquo;</div>
	        </div>
	        <div class="testimonial-source">
	          Barbara B., Falls Church VA
	        </div>  
	      </div> <!-- /item -->
	
	      <div class="testimonial-item">
	        <div class="testimonial-quote">
	          <div class="testimonial-quote-mark">&ldquo;</div><?php __( 'SaveBigBread found $1,800 as well as a qualified new contractor in one easy step.' ) ?><div class="testimonial-quote-mark">&rdquo;</div>
	        </div>
	        <div class="testimonial-source">
	          Vanna P., Vienna, VA
	        </div>  
	      </div> <!-- /item -->
	
	      <div class="testimonial-item">
	        <div class="testimonial-quote">
	          <div class="testimonial-quote-mark">&ldquo;</div><?php __( 'SaveBigBread found $800...I wouldn&#146;t have known to even ask!' ) ?><div class="testimonial-quote-mark">&rdquo;</div>
	        </div>
	        <div class="testimonial-source">
	          Scott H., Ashburn, VA
	        </div>  
	      </div> <!-- /item -->
	
	      <div class="testimonial-item">
	        <div class="testimonial-quote">
	          <div class="testimonial-quote-mark">&ldquo;</div><?php __( 'Thanks for being so prompt! My husband and I were impressed!' ) ?><div class="testimonial-quote-mark">&rdquo;</div>
	        </div>
	        <div class="testimonial-source">
	          Janet H. Falls Church, VA
	        </div>  
	      </div> <!-- /item -->
	    </div> <!-- /testimonials -->
	  </div> <!-- /#column-last -->
	</div> <!-- content-wrapper -->
  

</div> <!-- #content-bottom -->
