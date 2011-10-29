<div class="footer-inner">
  <div class="footer-menu">
    <?php echo $this->Html->link( 'About us', array( 'controller' => 'pages', 'action' => 'about' ) ) ?>
    | <?php echo $this->Html->link( 'Privacy & Security', array( 'controller' => 'pages', 'action' => 'privacy' ) ) ?>
    | <?php echo $this->Html->link( 'Terms of Use', array( 'controller' => 'pages', 'action' => 'terms' ) ) ?>
    <?php if( $this->Session->check( 'Auth.User' ) ): ?>
      | <?php echo $this->Html->link( 'Customer Service', array( 'controller' => 'messages', 'action' => 'feedback' ) ) ?>
    <?php endif; ?>
  </div>
  <div class="copyright">
    <?php printf( __( '&copy; %s SaveBigBread %s', true ), date( 'Y', time() ), Configure::read( 'Env.code' ) !== 'PRD' ? ' | ' . strtoupper( Configure::read( 'Env.name' ) ) : false ) ?>
  </div>
</div>
