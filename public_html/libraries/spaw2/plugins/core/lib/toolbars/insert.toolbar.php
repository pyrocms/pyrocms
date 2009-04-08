<?php
$items = array
(
  new SpawTbButton("core", "insertorderedlist", "isStandardFunctionEnabled", "isStandardFunctionPushed", "standardFunctionClick", SPAW_AGENT_ALL, true),
  new SpawTbButton("core", "insertunorderedlist", "isStandardFunctionEnabled", "isStandardFunctionPushed", "standardFunctionClick", SPAW_AGENT_ALL, true),
  new SpawTbImage("core", "separator"),
  new SpawTbButton("core", "hyperlink", "isInDesignMode", "", "hyperlinkClick", SPAW_AGENT_ALL, true),
  new SpawTbButton("core", "unlink", "isStandardFunctionEnabled", "", "standardFunctionClick", SPAW_AGENT_ALL, true),
  new SpawTbButton("core", "image", "isInDesignMode", "", "imageClick", SPAW_AGENT_ALL, true),
  new SpawTbButton("core", "image_prop", "isInDesignMode", "", "imagePropClick", SPAW_AGENT_ALL, true),
  new SpawTbButton("core", "flash_prop", "isInDesignMode", "", "flashPropClick"),
  new SpawTbButton("core", "inserthorizontalrule", "isStandardFunctionEnabled", "", "insertHorizontalRuleClick"),
  new SpawTbImage("core", "separator"),
);
?>
