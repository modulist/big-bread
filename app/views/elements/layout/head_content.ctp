<meta charset="utf-8" />
<title><?php echo 'SaveBigBread.com' . ( !empty( $title_for_layout ) ? ' : ' . $title_for_layout : '' ) ?></title>

<?php echo $this->Html->meta( 'icon' ) . "\n" ?>
<?php echo $this->Html->meta( 'description', __( 'SaveBigBread is the free and easy way to save $1,000s on air conditioning and furnace replacement and getting competing quotes from contractors authorized to provide rebates.', true ) ) . "\n" ?>
<?php echo $this->Html->meta( 'keywords', 'contractor, ac, energy star rebates, furnace, air conditioner repair, furnace repair, air conditioning' ) ?>

<?php echo $this->Html->css( '960.css' ) ?>
<?php echo $this->Html->css( 'jqueryui/themes/bigbread/jquery-ui-1.8.7.custom.css' ) ?>
<!-- Decent looking tooltips -->
<?php echo $this->Html->css( '/js/jquery/tipsy/tipsy.css' ) ?>

<?php echo $this->Html->css( 'screen', 'stylesheet', array( 'media' => 'screen' ) ) ?>
<?php echo $this->Html->css( 'print', 'stylesheet', array( 'media' => 'print' ) ) ?>

<!--[if lt IE 8]>
<?php echo $this->Html->css( 'ie7', 'stylesheet', array( 'media' => 'screen, projection' ) ) . "\n" ?>
<![endif]-->
 
<!--[if lte IE 8]>
<?php echo $this->Html->css( 'ie', 'stylesheet', array( 'media' => 'screen, projection' ) ) . "\n" ?>
<![endif]-->
 
<?php echo $this->Html->script( 'lib/modernizr-1.7.min.js' ) . "\n" ?>
