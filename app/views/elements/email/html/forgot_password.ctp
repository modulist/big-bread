<p>A little birdy told us that you forgot your password. Well, we've reset it for you. Just access the site using the link below and enter a new password to restore your access to BigBread.net</p>

<p><?php echo $this->Html->url( array( 'controller' => 'users', 'action' => 'register', $invite_code ), true ) ?></p>

<p>If you didn't request this change, <?php echo $this->Html->link( __( 'please let us know', true ), $this->Html->url( '/contact', true ) ) ?>.</p>
