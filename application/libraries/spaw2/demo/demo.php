<?php
include("../spaw.inc.php");
$spaw1 = new SpawEditor("spaw1");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>SPAW Editor Demo</title>
  </head>
  <body>
  <p>This is not a feature demonstration of SPAW Editor. This script is included
  for the only purpose of testing your configuration. If you can see and operate
  an instance of SPAW Editor below then your editor is properly configured</p>
  <p>For extended feature demonstration visit <a href="http://www.solmetra.com/en/disp.php/en_products/en_spaw/en_spaw_demo">our demo page at solmetra.com</a><p>
  <form method="post">
  <?php
  $spaw1->show();
  ?>
  </form>
  </body>
</html>
