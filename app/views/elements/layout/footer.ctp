<div class="footer-inner">
  <div class="footer-menu">
    <?php echo $this->Html->link( 'Why SaveBigBread.com', array( 'controller' => 'pages', 'action' => 'about' ) ) ?>
    | <?php echo $this->Html->link( 'Privacy & Security', array( 'controller' => 'pages', 'action' => 'privacy' ) ) ?>
    | <?php echo $this->Html->link( 'Terms of Use', array( 'controller' => 'pages', 'action' => 'terms' ) ) ?>
  </div>
  <div class="copyright">
  	&copy; 2009-<?php echo date( 'Y', time() ) ?> Federated Power, Inc.<?php echo Configure::read( 'Env.code' ) !== 'PRD' ? ' | ' . strtoupper( Configure::read( 'Env.name' ) ) : false ?>
  </div>
</div>

<div class="printable">www.SaveBigBread.com</div>
