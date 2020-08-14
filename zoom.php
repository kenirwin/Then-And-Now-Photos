<?php
  /* 
     code from: https://www.w3schools.com/howto/howto_js_image_zoom.asp
  */
include('config.php');
$src_img = GROUP_IMAGE_FILE;
$year = GROUP_IMAGE_YEAR;
$orig_width = GROUP_IMAGE_WIDTH; 
$lens_width = GROUP_LENS_WIDTH;
$lens_height = GROUP_LENS_HEIGHT;


?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include('bootstrap.php'); ?>
<style>
   * {box-sizing: border-box;}

   .img-zoom-container {
 position: relative;
    }

   .img-zoom-lens {
 position: absolute;
 border: 1px solid #d4d4d4;
     /*set the size of the lens:*/
    width: <?php echo $lens_width; ?>px;
height:  <?php echo $lens_height; ?>px;
    }

   .img-zoom-result {
 border: 1px solid #d4d4d4;
	/*set the size of the result div:*/
	width: 300px;
 height: 400px;
    }
</style>
<script>
function imageZoom(imgID, resultID) {
  var img, lens, result, cx, cy;
  img = document.getElementById(imgID);
  result = document.getElementById(resultID);
  /*create lens:*/
  lens = document.createElement("DIV");
  lens.setAttribute("class", "img-zoom-lens");
  /*insert lens:*/
  img.parentElement.insertBefore(lens, img);
  /*calculate the ratio between result DIV and lens:*/
  cx = result.offsetWidth / lens.offsetWidth;
  cy = result.offsetHeight / lens.offsetHeight;
  /*set background properties for the result DIV:*/
  result.style.backgroundImage = "url('" + img.src + "')";
  result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
  /*execute a function when someone moves the cursor over the image, or the lens:*/
  bindFunctions();

  function bindFunctions () {
    lens.addEventListener("mousemove", moveLens);
    img.addEventListener("mousemove", moveLens);
    /*and also for touch screens:*/
    lens.addEventListener("touchmove", moveLens);
    img.addEventListener("touchmove", moveLens);
    lens.addEventListener("click", processClick);
  }
  function processClick(e) {
    var coords = getCursorPos();
    window.location.href='extract.php?x='+coords['x']+'&y='+coords['y']+'&lens_width='+<?php echo $lens_width;?>+'&lens_height='+<?php echo $lens_height;?>+'&year=<?php echo $year;?>';
    lens.removeEventListener("touchmove", moveLens);
    lens.removeEventListener("mousemove", moveLens);
    img.removeEventListener("touchmove", moveLens);
    img.removeEventListener("mousemove", moveLens);
    lens.removeEventListener("click", processClick);
  }

  function moveLens(e) {
    var pos, x, y;
    /*prevent any other actions that may occur when moving over the image:*/
    e.preventDefault();
    /*get the cursor's x and y positions:*/
    pos = getCursorPos(e);
    /*calculate the position of the lens:*/
    x = pos.x - (lens.offsetWidth / 2);
    y = pos.y - (lens.offsetHeight / 2);
    /*prevent the lens from being positioned outside the image:*/
    if (x > img.width - lens.offsetWidth) {x = img.width - lens.offsetWidth;}
    if (x < 0) {x = 0;}
    if (y > img.height - lens.offsetHeight) {y = img.height - lens.offsetHeight;}
    if (y < 0) {y = 0;}
    /*set the position of the lens:*/
    lens.style.left = x + "px";
    lens.style.top = y + "px";
    /*display what the lens "sees":*/
    result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
  }
  function getCursorPos(e) {
    var a, x = 0, y = 0;
    e = e || window.event;
    /*get the x and y positions of the image:*/
    a = img.getBoundingClientRect();
    /*calculate the cursor's x and y coordinates, relative to the image:*/
    x = e.pageX - a.left;
    y = e.pageY - a.top;
    /*consider any page scrolling:*/
    x = x - window.pageXOffset;
    y = y - window.pageYOffset;
    return {x : x, y : y};
  }
  }
</script>
</head>
<body>

<?php
include('nav.php');
?>
<div class="container">
<h1>Image Zoom</h1>

<p>Mouse over the image:</p>

<div class="img-zoom-container">
  <img id="myimage" src="<?php echo $src_img;?>" width="<?php echo $orig_width;?>" >
  <div id="myresult" class="img-zoom-result"></div>
</div>
</div>

<script>
   // Initiate zoom effect:
   imageZoom("myimage", "myresult");
</script>

</body>
</html>
