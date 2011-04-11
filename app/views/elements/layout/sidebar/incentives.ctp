<div id="tips">
    <div id="tiptop"> </div>
    <div id="tip">
      <h3 class="savings"><?php __( 'Helpful Tip' ) ?></h3>
    <p>"<?php __( 'As a minimum, combine the Federal Tax Credit with your state or utility rebate.  In some cases, you can take the federal, state and utility rebate together.' ) ?>"</p>
  </div>
  <div id="tipbtm"> </div>
</div>

<?php if( !empty( $buildings ) ): ?>
  <table id="address">
  <thead>
    <tr>
      <th scope="col"><?php __( 'Address' ) ?></th>
      <th scope="col"><?php __( 'Date' ) ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach( $buildings as $building ): ?>
      <tr>
        <td class="adrs">
          <?php echo h( $building['Address']['address_1'] ) ?><br />
          <?php if( !empty( $building['Address']['address_2'] ) ): ?>
            <?php echo h( $building['Address']['address_2'] ) ?><br />
          <?php endif; ?>
          <?php echo h( $building['Address']['ZipCode']['city'] ) . ', ' . h( $building['Address']['ZipCode']['state'] ) . ' ' . h( $building['Address']['zip_code'] ) ?>
        </td>
        <td class="date"><?php echo date( 'm/d/Y', strtotime( $building['Building']['created'] ) ) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
  </table>
<?php endif; ?>

<div id="getstart">
  <h2><?php __( 'Let\'s Get Started' ) ?></h2>
  <?php echo $this->Html->image( 'DownloadQ.png', array( 'url' => '/files/questionnaire.pdf' ) ) ?>
</div>
