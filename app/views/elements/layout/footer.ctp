<div class="footer-inner">
  <div class="footer-menu">
    <?php echo $this->Html->link( 'About us', array( 'controller' => 'pages', 'action' => 'about' ) ) ?>
    | <?php echo $this->Html->link( 'Privacy & Security', array( 'controller' => 'pages', 'action' => 'privacy' ) ) ?>
    | <?php echo $this->Html->link( 'Terms of Use', array( 'controller' => 'pages', 'action' => 'terms' ) ) ?>
    | <?php echo $this->Html->link( 'Customer Service', array( 'controller' => 'messages', 'action' => 'feedback' ) ) ?>
  </div>
  <div class="copyright">
  	&copy; 2009-<?php echo date( 'Y', time() ) ?> SaveBigBread <?php echo Configure::read( 'Env.code' ) !== 'PRD' ? ' | ' . strtoupper( Configure::read( 'Env.name' ) ) : false ?>
  </div>
</div>
