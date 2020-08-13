<?php
namespace wittproj;

class Error {
  public function __construct($e, $headline= '', $trace=true) {
    $return = '<div class="container alert alert-danger">';
    $return .= '<p><b>'.$headline.'</b></p>';
    $return .= '<ul><li>'.$e->getMessage().'</li></ul>';
    if ($trace) { 
      $return.= '<pre>';
      $return .= print_r ($e->getTrace(), true);
      $return.= '</pre>';
    }
    $return .= '</div>';
    $this->alert = $return;
  }
}