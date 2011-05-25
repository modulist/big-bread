<p><?php printf( __( 'Hi, and welcome to BigBread.net. %s has completed a home survey and is inviting you to view the results.', true ), $this->Session->read( 'Auth.User.first_name' ) ) ?></p>
<p><?php __( 'You\'re one step away from saving hundreds of dollars on the repair of your home.  Please click on the enclosed link so you can register and get access to the savings we have waiting for you.  Whether you set up your account now or later, you\'ll need to get to us by clicking this link.' ) ?></p>
<p><?php __( 'We\'re looking forward to your visit.' ) ?></p>

<p><?php echo $this->Html->link( __( 'Register now and start saving.', true ), $this->Html->url( array( 'controller' => 'users', 'action' => 'invite', $invite_code ), true ) ) ?></p>

<p><?php echo $this->Html->image( 'logo-email.png', array( 'url' => 'http://bigbread.net' ) ) ?></p>
