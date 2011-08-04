<div id="footerright">
  <?php # echo $this->Html->image( 'versing.png' ) ?>
  <?php # echo $this->Html->image( 'truste.png' ) ?>
  <?php # echo $this->Html->image( 'mcAfee.png' ) ?>
</div>
<div id="footerleft">
  <a href="#" ><?php echo $this->Html->image( 'poweredBy.png' ) ?></a>
  <p>
    <?php echo $this->Html->link( 'Why SaveBigBread.com', array( 'controller' => 'pages', 'action' => 'about' ) ) ?>
    | <?php echo $this->Html->link( 'Privacy & Security', array( 'controller' => 'pages', 'action' => 'privacy' ) ) ?>
    | <?php echo $this->Html->link( 'Terms of Use', array( 'controller' => 'pages', 'action' => 'terms' ) ) ?>
  </p>
  
  <p>&copy; 2009-<?php echo date( 'Y', time() ) ?> Federated Power, Inc.<?php echo Configure::read( 'Env.code' ) !== 'PRD' ? ' | ' . strtoupper( Configure::read( 'Env.name' ) ) : false ?></p>
</div>

<div class="printable">www.SaveBigBread.com</div>
