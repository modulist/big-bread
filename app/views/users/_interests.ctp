<?php $location_id = isset( $location_id ) ? $location_id : false ?>

<!-- my interests -->
<div id="my-interests" class="grid_9">
  <div class="my-interests-grid clearfix">
    <?php foreach( $watchable as $column => $groups ): ?>
      <div class="grid_3">
        <?php foreach( $groups as $group ): ?>
            <h4><?php echo h( $group[0]['TechnologyGroup']['title'] ) ?></h4>
            <ul>
              <?php foreach( $group as $technology ): ?>
                <li<?php echo in_array( $technology['Technology']['id'], $watched ) ? ' class="active"' : false ?>>
                  <?php echo $this->Html->link( h( $technology['Technology']['title'] ), array( 'controller' => 'users', 'action' => !in_array( $technology['Technology']['id'], $watched ) ? 'watch' : 'unwatch', 'Technology', $technology['Technology']['id'], $location_id ), array( 'data-watch-technology-id' => $technology['Technology']['id'] ) ) ?>
                </li>
              <?php endforeach; ?>
            </ul>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>
  </div><!-- /my interests grid -->
</div><!-- /my interests -->