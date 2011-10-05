<?php $this->set( 'title_for_layout', __( 'Welcome', true ) ) ?>
 
<div id="content-bottom" class="content-bottom grid_10 clearfix">
  <div id="column-first" class="grid_3">
    <h3><?php __( '*Here&#146;s how it works:' ) ?></h3>
    <div class="green-dot-divider">
      <?php echo $this->Html->image( 'green-dot-divider.png' ) ?>
    </div>     
    
    <p><?php __( 'There are $2 billion in energy credits and rebates available from utilities as well as federal, state, and local governments' ) ?></p>   
    <p><?php printf( __( 'Here are just some of the available rebates for HVAC systems in %s:', true ), '<br /><span class="rebate-city">' . h( $locale['ZipCode']['city'] ) . ', ' . h( $locale['ZipCode']['state'] ) . '</span>' ) ?></p>
    <table class="rebates-preview">
      <?php $i = 0 ?>
      <?php foreach( $featured_rebates as $name => $amount ): ?>
        <tr class="<?php echo $i++ % 2 === 0 ? 'even' : 'odd' ?>">
          <td class="rebate-source" title="<?php echo h( preg_replace( '/-.+$/', '', $name ) ) ?>"><?php echo h( $this->Text->truncate( preg_replace( '/\s*-.+$/', '', $name ), 25, array( 'ending' => '...', 'exact' => false ) ) ) ?></td>
          <td class="rebate-amount"><?php echo $this->Number->format( $amount, array( 'before' => '$', 'places' => 2 ) ) ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
    <p><?php __( 'Enter our site and find more ways to save through rebates' ) ?></p>
  </div>    <!-- /#column-first -->
  
  <div id="column-middle" class="grid_3">
    <h3><?php __( 'Find a contractor' ) ?></h3>
    <div class="green-dot-divider">
      <?php echo $this->Html->image( 'green-dot-divider.png' ) ?>
    </div>      
    <p><?php __( 'Big Bread can help you get quotes from contractors in your area &ndash; free of charge' ) ?></p>
    
    <h3><?php __( 'Redeem a rebate' ) ?></h3>
    <div class="green-dot-divider">
      <?php echo $this->Html->image( 'green-dot-divider.png' ) ?>
    </div>
    <p><?php __( 'Tell us about your purchase and upload a scan of the invoice, and we&#146;ll handle the rest for you.' ) ?></p>

    <div class="green-dot-divider">
      <?php echo $this->Html->image( 'green-dot-divider.png' ) ?>
    </div>
    
    <div id="blog-link">
      <h3><?php echo $this->Html->link( __( 'Read our blog &rsaquo;', true ), 'http://www.savebigbread.com', array( 'escape' => false ) ) ?></h3>
    </div><!-- /#blog-link -->
  </div>   <!-- /#column-middle -->
  
  <div id="column-last" class="grid_3">
    <div id="testimonials">
      <div class="testimonial-item">
        <div class="testimonial-quote">
          <div class="testimonial-quote-mark">&ldquo;</div><?php __( 'I never knew you could save this much!' ) ?><div class="testimonial-quote-mark">&rdquo;</div>
        </div>
        <div class="testimonial-source">
          Annette B., Washington, DC
        </div>  
      </div> <!-- /item -->
      
      <div class="testimonial-item">
        <div class="testimonial-quote">
          <div class="testimonial-quote-mark">&ldquo;</div><?php __( 'Before BigBread, I&#146;d  leave so much money on the table...' ) ?><div class="testimonial-quote-mark">&rdquo;</div>
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
</div> <!-- #content-bottom -->
