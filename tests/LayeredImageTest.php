<?php
namespace wittproj\test;
error_reporting(E_ALL);
ini_set('display_errors', 1);

require (dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php'); 

use PHPUnit\Framework\TestCase;
use wittproj\LayeredImage;

class LayeredImageTest extends TestCase {

  public function setUp() : void
  {
    $this->img = new LayeredImage();
  }
  
  public function tearDown() : void
  {
    unset($this->img);
  }
  public function returnBinary($resource) {
    ob_start();
    imagepng($resource);
    $binary = ob_get_contents();
    ob_end_clean();
    return $binary;
  }
  public function testBackgroundHasDimensions() : void
  {
    $this->img->setBackground(__DIR__ . '/testBackground.png');
    $this->assertEquals(600, $this->img->width);
    $this->assertEquals(600, $this->img->height);
  }
  public function testBackgroundSetsImageVar() : void 
  {
    $this->img->setBackground(__DIR__ . '/testBackground.png');
    $this->assertEquals('resource',gettype($this->img->image));
  }
  public function testCoverDiffFromBackground() : void
  {
    $this->img->setBackground(__DIR__ . '/testBackground.png');
    $before = $this->returnBinary($this->img->image);
    $this->img->setCover(__DIR__ . '/testCover.png');
    $after = $this->returnBinary($this->img->image);
    $this->assertNotEquals($before,$after);
  }
  
}
			    

