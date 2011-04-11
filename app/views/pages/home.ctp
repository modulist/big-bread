<div class="intro">
  <?php # TODO: Remove inline style ?>
  <?php echo $this->Html->image( 'laptop_hm.png', array( 'width' => 564, 'height' => 416, 'alt' => 'laptop', 'style' => 'float: right;' ) ) ?>
    <p class="introbigtext">
      <span class="green">$2 billion</span> in <span class="orange">rebates</span> and 
      <span class="orange">credits </span>that<br />help you <span class="orange">improve</span> your 
      <span class="orange">home</span>.
    </p>
    <p>
      BigBread.net brings together all the energy efficiency, home improvement rebates that help you lower your home maintenance costs and lower your monthly utility bills.
    </p>
    <br />
    <?php echo $this->Html->link( __( 'Register now for your rebates!', true ), Router::url( '/register' ), array( 'class' => 'button' ) ) ?>
    <p class="link-action">If you are already registered, <?php echo $this->Html->link( 'Login', Router::url( '/login' ) ) ?>.</p>
</div>

<div class="clear"></div>

<div class="introcolumn">
    <h2>Private</h2>
    <p>Respond to personalized offers that work for you</p>
    <p>No phone calls</p>
    <p>No public disclosure</p>
</div>
<div class="introcolumn">
    <h2>Secure</h2>
    <p>Latest data security techniques</p>
    <p>Encrypted data</p>
</div>
<div class="introcolumn">
    <h2>Comprehensive</h2>
    <p>We provide federal, state, local, utility, and supplier rebates and coupons</p>
    <p>We help you determine how you can take multiple rebates for substantial savings</p>
</div>

<div class="clear"></div>
