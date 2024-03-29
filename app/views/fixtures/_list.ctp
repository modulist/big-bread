<?php $fixtures = isset( $fixtures ) ? $fixtures : array() ?>

<table class="current-equipment">
  <?php if( !empty( $fixtures ) ): ?>
    <?php foreach( $fixtures as $i => $fixture) : ?>
      <tr class="<?php echo $i % 2 == 0 ? 'even' : 'odd' ?>">
        <td class="model-name">
          <?php echo !empty( $fixture['Fixture']['name'] ) ? h( $fixture['Fixture']['name'] ) : h( Inflector::singularize( $fixture['Technology']['title'] ) ) ?>
        </td>
        <td class="add-edit">
          <?php echo $this->Html->link( __( 'edit', true ), array( 'controller' => 'fixtures', 'action' => 'edit', $fixture['Fixture']['id'] ), array( 'class' => 'edit-button' ) ) ?>
          |
          <?php echo $this->Html->link( __( 'remove', true ), array( 'controller' => 'fixtures', 'action' => 'retire', $fixture['Fixture']['id'] ), array( 'class' => 'remove-button', 'confirm' => sprintf( __( 'Are you sure you want to retire this %s?', true ), strtolower( Inflector::singularize( $fixture['Technology']['title'] ) ) ) ) ) ?>
        </td>
      </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td><?php __( 'No equipment has been added.' ) ?></td>
    </tr>
  <?php endif; ?>
</table>