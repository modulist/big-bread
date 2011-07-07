<?php

App::import( 'Core', 'Controller' );
App::import( 'Component', 'SwiftMailer' );
    
/**
 * Validates key links in the system and emails a report.
 * Usage: ./cake/console/cake -app <path to app/ directory> validate_links
 */
class ValidateLinksShell extends Shell {
	public $uses = array( 'TechnologyIncentive' );
  public $tasks = array( 'Daemon' );
  
  # Support email functionality. @see this::send_report().
  public $Controller  = null;
  public $SwiftMailer = null;
  
  private $csv             = null;
  private $email_report_to = 'wamaull@federatedpower.com';
  private $fields          = array( 'Incentive ID', 'Link Type', 'Link', 'Status' );
  private $summary         = array(
    'incentive_count' => 0,
    'link_count'      => 0,
    'status_counts'   => array(),
  );

  public function startup() {
    parent::startup();
    
    echo "Beginning link validation at " . date( 'm/d/Y H:i:s' ) . "\n";
    $this->Daemon->execute( 'validate_links' );
    
    $this->Controller  = new Controller();
    $this->SwiftMailer = new SwiftMailerComponent();
    $this->SwiftMailer->initialize( $this->Controller );
    
    $this->csv = new File( TMP . DS . 'links.' . date( 'Ymd' ) . '.csv' );
  }

	public function main() {
    $links = array();
    echo " --> Retrieving technology incentive links...\n";
    $links = $this->get_technology_incentive_links( $links );
    echo " <-- Complete. Retrieved " . count( $links ) . " links.\n";
    
    $this->summary['link_count'] = count( $links );
    
    # Validate the links and update the 'Status' key
    echo " --> Validating links...\n";
    $links = $this->validate_links( $links );
    echo " <-- Complete (" . date( 'm/d/Y H:i:s' ) . ")\n";
    
    # Write link data to a file that will be attached to an email
    echo " --> Creating CSV to send...\n";
    $this->create_email_attachment( $links );
    echo " <-- Complete (" . date( 'm/d/Y H:i:s' ) . ").\n";
    
    # Send the link validation report
    echo " --> Sending the report...\n";
    $this->send_report();
    echo " <-- Complete (" . date( 'm/d/Y H:i:s' ) . ").\n";
	}
  
  /**
   * Validates each link by sending a HEAD request.
   *
   * @param 	$links
   * @return	array		An updated links array
   * @access	public
   */
  public function validate_links( $links ) {
    $this->HttpSocket = ClassRegistry::init( 'HttpSocket', 'Core' );
    
    foreach( $links as $i => $link ) {
      echo " ----> Validating " . $link['Link'] . " (" . $link['Link Type'] . ")\n";
      echo " ----> Process: " . shell_exec( 'ps -ef | grep -e "validate_links$" | head -n 1 | sed "s/\s*$//"' );
      $request = array(
        'method' => 'HEAD',
        'uri' => $link['Link'],
        'version' => '1.1',
        'timeout' => 60,
        'header' => array(
          'Connection' => 'close',
          'User-Agent' => 'CakePHP'
        ),
      );
      
      if( $this->HttpSocket->request( $request ) !== false ) {
        $status_code = $this->HttpSocket->response['status']['code'];
        $links[$i]['Status'] = $status_code;
        $links[$i]['Error']  = null;
      
        if( !array_key_exists( $status_code, $this->summary['status_counts'] ) ) {
          $this->summary['status_counts'][$status_code] = 0;
        }
        else {
          $this->summary['status_counts'][$status_code]++;
        }
        
        echo " ------> Status: " . $status_code . "\n";
      }
      else {
        $links[$i]['Status'] = 'ERR';
        $links[$i]['Error']  = 'An error occurred when requesting this URL.';
        
        echo " ------> An error occurred when requesting this URL.\n";
      }
      
      echo " ------> " . ( round( ( $i / count( $links ) ) * 100 ) ) . "% complete (" . $i . " of " . count( $links ) . ")\n";
      echo " ------> Current timestamp: " . date( 'm/d/Y H:i:s' ) . "\n";
      
      echo " <---- Complete.\n";
    }
    
    return $links;
  }
  
  private function get_technology_incentive_links( $results ) {
    # Maps the file fields ($this->fields) to this result set
    /*
    $field_map = array(
      'Incentive ID' => 'incentive_id',
      'Link Type'    => ,
      'Link'         => ,
      'Status'       => ,
    );
    */
    $tech_incentives = $this->TechnologyIncentive->find(
      'all',
      array(
        'contain' => array( 'Incentive', 'Technology' ),
        'fields'  => array(
          'Incentive.incentive_id',
          'Technology.incentive_tech_id',
          'Technology.name',
          'TechnologyIncentive.weblink',
          'TechnologyIncentive.rebate_link',
          'TechnologyIncentive.contr_link',
        ),
        'conditions' => array(
          'Incentive.excluded' => 0,
          'TechnologyIncentive.is_active' => 1, /*
          'OR' => array(
            'NOT' => array( 'TechnologyIncentive.weblink' => null ),
            'NOT' => array( 'TechnologyIncentive.rebate_link' => null ),
            'NOT' => array( 'TechnologyIncentive.contr_link' => null ),
          ) */
        ),
        # 'limit' => 50, # for testing
      )
    );
    
    $this->summary['incentive_count'] += count( $tech_incentives );
    
    $link_fields = array(
      'Web Link'     => 'weblink',
      'Rebate Link'  => 'rebate_link',
      'Control Link' => 'contr_link',
    );
    foreach( $tech_incentives as $incentive ) {
      $record = array(
        'Incentive ID' => $incentive['Incentive']['incentive_id'],
        'Technology'   => $incentive['Technology']['incentive_tech_id'] . ' (' . $incentive['Technology']['name'] . ')'
      );
      
      foreach( $link_fields as $title => $field ) {
        if( empty( $incentive['TechnologyIncentive'][$field] ) ) {
          continue;
        }
        
        $record['Link Type']  = $title;
        $record['Link']       = $incentive['TechnologyIncentive'][$field];
        $record['Status']     = null;
        
        array_push( $results, $record );
      }
    }
    
    return $results;
  }
  
  /**
   * Writes the parsed link data to a file.
   *
   * @param 	$links
   * @return	void
   * @access	public
   */
  public function create_email_attachment( $links ) {
    if( $this->csv->exists() ) {
      $this->csv->delete(); # Delete any existing file
    }
    
    # Write header row
    $this->csv->append( join( ', ', array_keys( $links[0] ) ) );
    $this->csv->append( "\n" );
    
    foreach( $links as $link ) {
      $this->csv->append( '"' . join( '","', array_values( $link ) ) . '"' );
      $this->csv->append( "\n" );
    }
  }
  
  /**
   * Sends the link validation email with attachment.
   *
   * @return	void
   * @access	public
   */
  public function send_report() {
    /** 
    $this->SwiftMailer->smtpType = 'tls'; 
    $this->SwiftMailer->smtpHost = 'smtp.gmail.com'; 
    $this->SwiftMailer->smtpPort = 465; 
    $this->SwiftMailer->smtpUsername = 'my_email@gmail.com'; 
    $this->SwiftMailer->smtpPassword = 'hard_to_guess'; 
    */
    $this->SwiftMailer->sendAs   = 'text';
    $this->SwiftMailer->from     = Configure::read( 'email.do_not_reply_address' ); 
    $this->SwiftMailer->fromName = 'BIGBREAD.net Link Validator';
    $this->SwiftMailer->to       = Configure::read( 'email.redirect_all_email_to' )
        ? Configure::read( 'email.redirect_all_email_to' )
        : Configure::read( 'email.default_recipient' );
    $this->SwiftMailer->attachments = array(
      $this->csv->pwd(),
    );
    
    $this->set( 'summary', $this->summary );
    
    try { 
      if( !$this->SwiftMailer->send( 'link_validation', 'BIGBREAD.net Link Validation (' . date( 'm/d/Y' ) . ')', 'native' ) ) {
        foreach($this->SwiftMailer->postErrors as $failed_send_to) { 
          $this->log( 'Failed to send link validation email to ' . $failed_send_to . '.' ); 
        }
      } 
    } 
    catch( Exception $e ) { 
      $this->log( 'Failed to send email: ' . $e->getMessage() ); 
    } 
  }
  
  /**
   * Sets a view variable to the dummy controller.
   *
   * @param 	$name
   * @param   $value
   * @return	void
   * @access	public
   */
  public function set( $name, $value ) {
    $this->Controller->set( $name, $value );
  }
}
