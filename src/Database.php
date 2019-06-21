<?php
namespace wittproj;

use \atk4\dsql\Query;

class Database {
  public function __construct () {
    $this->c = \atk4\dsql\Connection::connect(DSN,USER,PASS);
  }

  public function submitFile($filename,$sender,$subject) {
    $this->initializeQuery();
    $this->q->table('submissions')
      ->set('time_received',date('Y-m-d H:i:s'))
      ->set('sender',$sender)
      ->set('subject',$subject)
      ->set('filename',$filename)
      ->insert();
  }

  public function logError($content=null,$sender=null,$subject=null) {
    $this->initializeQuery();
    $this->q->table('error_log')
      ->set('time_received',date('Y-m-d H:i:s'))
      ->set('sender',$sender)
      ->set('content',$content)
      ->insert();
  }

  public function countEntries($table='submissions') {
    $this->initializeQuery();
    $this->q->table($table)->field('count(*)');
    $row = $this->q->getRow();
    return $row['count(*)'];
  }

  public function getFileinfo($table,$order=null) {
    $this->initializeQuery();
    $this->q->table($table);
    if (! is_null($order)) {
      $this->q->order($order);
    }
    return $this->q->get();
  }

  public function initializeQuery() {
    $this->q = $this->c->dsql();
  }
}
?>