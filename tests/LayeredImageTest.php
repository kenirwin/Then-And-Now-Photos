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
  public function testPlacementsStartAtZero() : void
  {
    $this->assertEquals(0, $this->img->placements);
    $this->assertEquals(array(), $this->img->placed);
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
  public function testGetDimensionsCalculates() : void
  {
    $response = $this->img->getDimensions(__DIR__ .  '/testPortraitLeft.png', 200, 400, false); // original is 260 x 300
    $this->assertEquals(200, $response['width']);
    $this->assertEquals(230, $response['height']);
    $this->assertEquals(260, $response['width_orig']);
    $this->assertEquals(300, $response['height_orig']);
  }
  public function testPlaceFileCreatesImage() : void
  {
    $this->img->setBackground(__DIR__ . '/testBackground.png');
    $this->img->placeImage(__DIR__ . '/testPortraitLeft.png', 100, 100, null, null, 0);
    $this->assertEquals(1, $this->img->placements);
    $this->assertEquals('resource',gettype($this->img->placed[0]));
  }
  public function testPlacingFileChangesImage() : void
  {
    /*
    $this->img->setBackground(__DIR__ . '/testBackground.png');
    $before = $this->returnBinary($this->img->image);
    $this->img->placeImage(__DIR__ . '/testPortraitLeft.png', 100, 100, null, null, 0);
    $after = $this->returnBinary($this->img->image);
    $this->assertNotEquals($before,$after);
    */
  }

}
			    

