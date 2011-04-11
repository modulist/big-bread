<div id="footerright">
  <a href="#" ><?php echo $this->Html->image( 'versing.png' ) ?></a>
  <a href="#" ><?php echo $this->Html->image( 'truste.png' ) ?></a>
  <a href="#" ><?php echo $this->Html->image( 'mcAfee.png' ) ?></a>
</div>
<div id="footerleft">
  <a href="#" ><?php echo $this->Html->image( 'poweredBy.png' ) ?></a>
  <p>
    <?php echo $this->Html->link( 'Why BigBread.net', array( 'controller' => 'pages', 'action' => 'about' ) ) ?>
    | <?php echo $this->Html->link( 'Privacy & Security', array( 'controller' => 'pages', 'action' => 'privacy' ) ) ?>
    | <?php echo $this->Html->link( 'Terms of Use', array( 'controller' => 'pages', 'action' => 'terms' ) ) ?>
  </p>
  
    <p>© 2009-<?php echo date( 'Y', time() ) ?> Federated Power, Inc. | Beta 1.0</p>
</div>
