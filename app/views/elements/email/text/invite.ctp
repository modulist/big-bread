<?php printf( __( 'Hi, and welcome to SaveBigBread.com. %s has completed a home survey and is inviting you to view the results.', true ), $this->Session->read( 'Auth.User.first_name' ) ) ?>

<?php __( 'You\'re one step away from saving hundreds of dollars on the repair of your home.  Please click on the enclosed link so you can register and get access to the savings we have waiting for you.  Whether you set up your account now or later, you\'ll need to get to us by clicking this link.' ) ?>

<?php __( 'We\'re looking forward to your visit.' ) ?>

<?php echo $this->Html->url( '/invite/' . $invite_code, true ) ?>
