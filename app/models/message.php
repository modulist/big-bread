<?php

class Message extends AppModel {
	public $name = 'Message';

	public $belongsTo = array(
    'MessageTemplate',
		'Proposal' => array(
			'foreignKey' => 'foreign_key',
			'conditions' => array( 'Message.model' => 'Proposal' ),
		),
		'Recipient' => array(
			'className' => 'User',
			'foreignKey' => 'recipient_id',
		),
		'Sender' => array(
			'className' => 'User',
			'foreignKey' => 'sender_id',
		),
	);
  
  /**
   * CALLBACK METHODS
   */
  
  /**
   * CakePHP afterFind callback.
   *
   * @param   array $results
   * @return  array
   * @access  public
   */
	public function afterFind( $results ) {
		foreach( $results as $i => $result ) {
			/**
			 * Perform key replacement to set any variable text in
			 * relevant text fields.
			 */
			if( !empty( $result['MessageTemplate'] ) ) {
				$replaceable_fields = array( 'subject', 'body_text', 'body_html' );

				foreach( $replaceable_fields as $field ) {
					preg_match_all( '/%((\w+)\.([^%]+))%/', $result['MessageTemplate'][$field], $matches, PREG_SET_ORDER );
          
					foreach( $matches as $match ) {
						$results[$i]['MessageTemplate'][$field] = $this->replace(
							$results[$i]['MessageTemplate'][$field], // haystack
							$match,
							json_decode( $result['Message']['replacements'], true )
						);
					}
				}
			}
		}
		return $results;
	}
  
  /**
   * Replaces variable values in message content.
   * 
   * @param   $haystack
   * @param   $match
   * @param   $replacements
   * @return  string
   */
  private function replace( $haystack, $match, $replacements ) {
    $subject  = $match[0];
    $variable = $match[1];
    $model    = $match[2];
    $property = $match[3];
    
    switch( strtoupper ( $model ) ) {
      case 'CONFIG':
        return str_replace( $subject, Configure::read( $property ), $haystack );

      case 'CUSTOM':
        return str_replace( $subject, $keys[$property], $haystack );

      default:
        return str_replace( $subject, $replacements[$variable], $haystack );
    }
  }
  
  /**
   * PUBLIC METHODS
   */
  
  /**
   * Writes a message to the "queue".
   *
   * @param   string  $template_code  Send the code for usability
   * @param   string  $model
   * @param   uuid    $foreign_key
   * @param   uuid    $sender_id
   * @param   uuid    $recipient_id
   * @param   array   $replacements   
   * @return  boolean
   * @access  public
   */
  public function queue( $template_code, $model, $foreign_key, $sender_id, $recipient_id, $replacements ) {
    $queued       = true;
    $template_id  = $this->MessageTemplate->field( 'id', array( 'MessageTemplate.code' => $template_code ) );
    
    if( !empty( $template_id ) ) {
      $message = array(
        'message_template_id' => $template_id,
        'model'               => $model,
        'foreign_key'         => $foreign_key,
        'sender_id'           => $sender_id,
        'recipient_id'        => $recipient_id,
        'replacements'        => json_encode( $replacements ),
      );
      
      $queued = $this->save( $message );
    }
    else {
      $queued = false;
    }
    
    return $queued;
  }
}
