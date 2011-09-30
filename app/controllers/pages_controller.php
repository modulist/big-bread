<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @link http://book.cakephp.org/view/958/The-Pages-Controller
 */
class PagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 * @access public
 */
	var $name = 'Pages';

/**
 * Default helper
 *
 * @var array
 * @access public
 */
	var $helpers = array('Html', 'Session');

/**
 * This controller does not use a model
 *
 * @var array
 * @access public
 */
	var $uses = array();

/**
 * CALLBACKS
 */
public function beforeFilter() {
  parent::beforeFilter();
  
  $this->Auth->allow( '*' );
}

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @access public
 */
	function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
    
    if( $page == 'home' ) {
      $this->layout = 'default_landing';
      
      $this->loadModel( 'ZipCode' );
      $zip_code         = $this->Session->read( 'default_zip_code' );
      $total_savings    = $this->ZipCode->savings( $zip_code, false );
      $featured_rebates = $this->ZipCode->featured_rebates( $zip_code );
      $locale           = $this->ZipCode->locale( $zip_code );
      
      $this->set( compact( 'featured_rebates', 'locale', 'total_savings' ) );
    }
    
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}
  
  /**
   * Used for testing various bits and bobs.
   *
   * @return	void
   * @access	public
   */
  public function test() {
    $this->autoRender = false;
    
    $this->loadModel( 'TechnologyIncentive' );
    new PHPDump( $this->TechnologyIncentive->all( '21224', array( 'c48c7270-6f7f-11e0-be41-80593d270cc9', 'c48c6d7a-6f7f-11e0-be41-80593d270cc9' ), true) ); # Dishwasher, AC
  }
}
