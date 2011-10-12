<meta charset="utf-8" />
<title><?php echo 'SaveBigBread.com' . ( !empty( $title_for_layout ) ? ' : ' . $title_for_layout : '' ) ?></title>

<?php echo $this->Html->meta( 'icon' ) . "\n" ?>

<?php echo $this->Html->css( '960.css' ) ?>
<?php echo $this->Html->css( 'jqueryui/themes/bigbread/jquery-ui-1.8.7.custom.css' ) ?>
<!-- Decent looking tooltips -->
<?php echo $this->Html->css( '/js/jquery/tipsy/tipsy.css' ) ?>

<?php echo $this->Html->css( 'screen', 'stylesheet', array( 'media' => 'screen' ) ) ?>
<?php echo $this->Html->css( 'print', 'stylesheet', array( 'media' => 'print' ) ) ?>

<?php echo $this->Html->script( 'lib/modernizr-1.7.min.js' ) . "\n" ?>
