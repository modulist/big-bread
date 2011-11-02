<p><?php printf( __( 'Hi, %s:', true ), $recipient_first_name ) ?></p>

<p><?php printf( __( '%s has filled out your profile and identified $1,000s in savings for you.  You\'ll need to click on this link to get to the account that\'s been set up for you.', true ), $sender_name ) ?></p>

<p><?php __( 'SaveBigBread is the free and easy way to save on home improvement. We\'ve collected government, utility and manufacturer home improvement savings in one spot. We help you identify savings that are applicable to you, connect you with contractors authorized by program sponsors and help you fill out the paperwork that gets you for check.' ) ?></p>

<p><?php __( 'Save Big and Go Home - what\'s not to like?' ) ?></p>

<p><?php echo $this->Html->link( __( 'Register now and start saving.', true ), $this->Html->url( '/invite/' . $invite_code, true ) ) ?></p>

<p>
  <?php __( 'Regards,' ) ?><br />
  <?php __( 'Tony Maull,' ) ?><br />
  <?php __( 'CEO and President' ) ?><br /> 
</p>