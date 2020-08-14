<nav class="navbar navbar-expand-md navbar-light bg-light mb3">
<div class="container">
   <a href="index.php" class="navbar-brand"><h2><i class="fa fa-columns" aria-hidden="true"></i><span class="sr-only">Homecoming Photo Pairing App Home</span></h2></a>
<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav">
<span class="navbar-toggler-icon">
</button>

<?php
   if (preg_match('/path=extracts/',$_SERVER['REQUEST_URI'])) {
     $page3 = "active"; $page1 = $page2 = "";
   }
   elseif (preg_match('/zoom.php/',$_SERVER['REQUEST_URI'])) {
     $page2 = "active"; $page1 = $page3 = "";   
   }
   else { 
     $page1 = "active"; $page2 = $page3= "";
   }

?>

<div class="collapse navbar-collapse" id="navbarNav">
<ul class="navbar-nav">
   <li><a href="index.php" class="nav-link mr-2 <?php echo $page1; ?>">Pair with Yearbook Photos</a></li>
   <li><a href="zoom.php" class="nav-link mr-2 <?php echo $page2; ?>">Extract from Group Photos</a></li>
   <li><a href="index.php?path=extracts" class="nav-link mr-2 <?php echo $page3; ?>">Pair Extracts of Groups</a></li>
</ul>
</div>

</div>
</nav>