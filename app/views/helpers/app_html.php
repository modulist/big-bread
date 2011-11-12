<?php
App::import( 'Helper', 'Html' );
class AppHtmlHelper extends HtmlHelper {
  /**
   * Cleans the generated URL of all prefixes before leveraging the standard
   * HtmlHelper::link() method to generate the link.
   *
   * @access  public
   * @see     HtmlHelper::link()
   */
  public function cleanLink( $title, $url = null, $options = array(), $confirmMessage = false ) {
    $prefixes = Router::prefixes();

    foreach( $prefixes as $prefix ) {
      $url[$prefix] = false;
    }

    return parent::link( $title, $url, $options, $confirmMessage );
  }
}