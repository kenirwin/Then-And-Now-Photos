<?php
namespace wittproj\test;
error_reporting(E_ALL);
ini_set('display_errors', 1);

require (dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php'); 

use PHPUnit\Framework\TestCase;
use \atk4\dsql\Query;
use wittproj\Database;

define ('DSN','sqlite::memory:');
define ('USER',null);
define ('PASS',null);

class DatabaseTest extends TestCase {

  public function setUp() : void
  {
    $this->db = new Database();
    $this->createTables();
  }
  
  public function tearDown() : void
  {
    unset($this->db);
  }

  public function testCountEntries() : void
  {
    $count = $this->db->countEntries();
    $this->assertEquals(1, $count);
  }
  public function testSubmitFileData () : void
  {
    $this->db->submitFile('testfilename.png','test_sender','test_subject');
    $count = $this->db->countEntries();
    $this->assertEquals(2, $count);
  }
  public function testLogError() : void
  {
    $this->db->logError('Error message','sender@garbage.com','Test Subject');
    $count = $this->db->countEntries('error_log');
    $this->assertEquals(2, $count);
  }
  public function testGetFileInfo() : void
  {
    $data = $this->db->getFileinfo();
    $this->assertEquals('testfile.png',$data[0]['filename']);
  }
  

  private function createTables() {
    $create_submissions = "CREATE TABLE `submissions` (
`id` INTEGER,
`time_received` DATETIME,
`sender` VARCHAR(255),
`subject` VARCHAR(255),
`filename` VARCHAR(255),
PRIMARY KEY(`id`)
);
";

    $create_error_log = "CREATE TABLE `error_log` (
`id` INTEGER,
`sender` VARCHAR(255),
`time_received` DATETIME,
`content` LONGTEXT,
PRIMARY KEY(`id`)
);
";
    $submissions_data = "
INSERT INTO `submissions` (`time_received`,`sender`,`subject`,`filename`)
VALUES
('2019-06-14 12:59:03','sample@garbage.com','Test Number 1','testfile.png')
";

    $error_data =  "
INSERT INTO `error_log` (`time_received`,`sender`,`content`)
VALUES
('2019-06-14 12:59:03','sample@garbage.com','Error loading file')
";
    $this->executeQuery($create_submissions);
    $this->executeQuery($create_error_log);
    $this->executeQuery($submissions_data);
    $this->executeQuery($error_data);
  }

  public function executeQuery($query) {
    $this->db->initializeQuery();
    $this->db->q->Expr($query)->execute($this->db->c);
  }

}
			    

