<?php

class TechnologyGroup extends AppModel {
	public $name       = 'TechnologyGroup';
	
	public $hasMany = array(
		'Technology' => array(
			'className'  => 'Technology',
		),
	);
  
  /**
   * Determines the number of incentives available for each group
   * for a given zip code.
   *
   * @param 	$zip_code
   * @param   $group_id   Optional. If passed and valid, returns the
   *                      number of incentives for that group only.
   *                      If null, returns all.
   * @return	array
   * @access	public
   * @see     AppModel::afterFind()
   *          Formats the aggregate value so that it appears in the
   *          TechnologyGroup properties as "incentive_count"
   */
  static public function incentive_count( $zip_code, $group_id = null ) {
    $counts = ClassRegistry::init( 'TechnologyGroup' )->find(
      'all',
      array(
        'contain' => false,
        'fields'  => array(
          'TechnologyGroup.id',
          'TechnologyGroup.name',
          'COUNT( TechnologyIncentive.id) incentive_count',
        ),
        'group'   => array(
          'TechnologyGroup.id',
          'TechnologyGroup.name',
        ),
        'conditions' => array(
          'TechnologyIncentive.is_active' => 1,
          'Incentive.excluded' => 0,
          'OR' => array(
            'Incentive.expiration_date' => null, 
            'Incentive.expiration_date >= ' => date( DATE_FORMAT_MYSQL ),
          ),
          'OR' => TechnologyIncentive::geo_scope_conditions( $zip_code ),
        ),
        'joins' => array(
          array(
            'table'      => 'technologies',
            'alias'      => 'Technology',
            'type'       => 'inner', 
            'foreignKey' => false,
            'conditions' => 'TechnologyGroup.id = Technology.technology_group_id'
          ),
          array(
            'table'      => 'technology_incentives',
            'alias'      => 'TechnologyIncentive',
            'type'       => 'inner', 
            'foreignKey' => false,
            'conditions' => 'Technology.id = TechnologyIncentive.technology_id'
          ),
          array(
            'table'      => 'incentive',
            'alias'      => 'Incentive',
            'type'       => 'inner', 
            'foreignKey' => false,
            'conditions' => 'TechnologyIncentive.incentive_id = Incentive.id'
          ),
        ),
      )
    );
    
    $counts = Set::combine( $counts, '{n}.TechnologyGroup.id', '{n}.TechnologyGroup' );
    
    return empty( $group_id )
      ? $counts
      : $counts[$group_id]['incentive_count'];
  }
}
