<?php
$items = array
(
  new SpawTbButton("core", "cut", "isStandardFunctionEnabled", "", "standardFunctionClick", SPAW_AGENT_IE, true),
  new SpawTbButton("core", "copy", "isStandardFunctionEnabled", "", "standardFunctionClick", SPAW_AGENT_IE, true),
  new SpawTbButton("core", "paste", "isStandardFunctionEnabled", "", "standardFunctionClick", SPAW_AGENT_IE, true),
  new SpawTbImage("core", "separator", SPAW_AGENT_IE),
  new SpawTbButton("core", "undo", "isStandardFunctionEnabled", "", "standardFunctionClick"),
  new SpawTbButton("core", "redo", "isStandardFunctionEnabled", "", "standardFunctionClick"),
  new SpawTbImage("core", "separator"),
);
?>
