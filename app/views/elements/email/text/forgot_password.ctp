<?php __( 'A little birdy told us that you forgot your password. Well, we\'ve reset it for you. Just access the site using the link below and enter a new password to restore your access to SaveBigBread.com' ) ?>

<?php echo $this->Html->url( array( 'controller' => 'users', 'action' => 'invite', $invite_code ), true ) ?>

<?php printf( __( 'If you didn\'t request this change, %s.', true ), $this->Html->link( __( 'please let us know', true ), array( 'controller' => 'contacts' )  ) ) ?>
