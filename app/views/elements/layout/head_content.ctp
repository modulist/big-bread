<meta charset="utf-8" />
<title><?php echo 'SaveBigBread.com' . ( !empty( $title_for_layout ) ? ' : ' . $title_for_layout : '' ) ?></title>

<?php echo $this->Html->meta( 'icon' ) . "\n" ?>
<!-- add in the 960.gs grid system -->
<?php echo $this->Html->css( '/css/960.css' ) ?>

<?php echo $this->Html->css( 'screen', 'stylesheet', array( 'media' => 'screen' ) ) ?>
<?php echo $this->Html->css( 'print', 'stylesheet', array( 'media' => 'print' ) ) ?>

<!-- Fancybox creates a nice looking modal -->
<?php echo $this->Html->css( '/js/jquery/fancybox/jquery.fancybox-1.3.4.css' ) ?>
<!-- Decent looking tooltips -->
<?php echo $this->Html->css( '/js/jquery/tipsy/tipsy.css' ) ?>

<?php echo $this->Html->script( 'lib/modernizr-1.7.min.js' ) . "\n" ?>
