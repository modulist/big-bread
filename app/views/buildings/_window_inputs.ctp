<label>Window Pane Type</label>
<?php echo $this->Form->input( 'BuildingWindowSystem.0.window_pane_type_id', array( 'type' => 'radio', 'legend' => false, 'empty' => true ) ) ?>
<?php echo $this->Form->input( 'BuildingWindowSystem.0.tinted' ) ?>
<?php echo $this->Form->input( 'BuildingWindowSystem.0.low_e' ) ?>
<?php echo $this->Form->input( 'BuildingWindowSystem.0.frame_material_id', array( 'empty' => true ) ) ?>
<?php echo $this->Form->input( 'Building.window_percent_average', array( 'label' => __( 'Number of Average Size Windows (6-8 sf)', true ), 'placeholder' => __( 'Example: 10', true ) ) ) ?>
<?php echo $this->Form->input( 'Building.window_percent_small', array( 'label' => __( 'Number of Small Windows (less than 6 sf)', true ), 'placeholder' => __( 'Example: 5', true ) ) ) ?>
<?php echo $this->Form->input( 'Building.window_percent_large', array( 'label' => __( 'Number of Large Windows (more than 8 sf)', true ), 'placeholder' => __( 'Example: 2', true ) ) ) ?>
<?php echo $this->Form->input( 'Building.window_wall' ) ?>
<?php echo $this->Form->input( 'Building.window_wall_sf', array( 'label' => __( 'Estimated Size (sf)', true ), 'placeholder' => __( 'Example: 80', true ) ) ) ?>
<?php echo $this->Form->radio( 'Building.window_wall_side', array( __( 'North', true ), __( 'South', true ), __( 'East', true ), __( 'West', true ) ), array( 'legend' => false ) ) ?>
<?php echo $this->Form->input( 'Building.skylight_count', array( 'label' => __( 'Number of Skylights', true ), 'placeholder' => __( 'Example: 5', true ) ) ) ?>
<?php echo $this->Form->input( 'Building.shading_type_id', array( 'label' => __( 'Sun Cover (lot &amp; interior)', true ), 'empty' => true ) ) ?>
