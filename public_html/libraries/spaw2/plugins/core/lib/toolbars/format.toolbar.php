<?php
$items = array
(
  new SpawTbButton("core", "bold", "isStandardFunctionEnabled", "isStandardFunctionPushed", "standardFunctionClick"),
  new SpawTbButton("core", "italic", "isStandardFunctionEnabled", "isStandardFunctionPushed", "standardFunctionClick"),
  new SpawTbButton("core", "underline", "isStandardFunctionEnabled", "isStandardFunctionPushed", "standardFunctionClick"),
  new SpawTbButton("core", "strikethrough", "isStandardFunctionEnabled", "isStandardFunctionPushed", "standardFunctionClick"),
  new SpawTbImage("core", "separator"),
  new SpawTbButton("core", "justifyleft", "isStandardFunctionEnabled", "isStandardFunctionPushed", "standardFunctionClick", SPAW_AGENT_ALL, true),
  new SpawTbButton("core", "justifycenter", "isStandardFunctionEnabled", "isStandardFunctionPushed", "standardFunctionClick", SPAW_AGENT_ALL, true),
  new SpawTbButton("core", "justifyright", "isStandardFunctionEnabled", "isStandardFunctionPushed", "standardFunctionClick", SPAW_AGENT_ALL, true),
  new SpawTbButton("core", "justifyfull", "isStandardFunctionEnabled", "isStandardFunctionPushed", "standardFunctionClick", SPAW_AGENT_ALL, true),
  new SpawTbImage("core", "separator"),
  new SpawTbButton("core", "indent", "isStandardFunctionEnabled", "isStandardFunctionPushed", "standardFunctionClick", SPAW_AGENT_ALL, true),
  new SpawTbButton("core", "outdent", "isStandardFunctionEnabled", "isStandardFunctionPushed", "standardFunctionClick", SPAW_AGENT_ALL, true),
  new SpawTbImage("core", "separator"),
  new SpawTbButton("core", "fore_color", "isForeColorEnabled", "", "foreColorClick", SPAW_AGENT_ALL, true),
  new SpawTbButton("core", "bg_color", "isBgColorEnabled", "", "bgColorClick", SPAW_AGENT_ALL, true),
  new SpawTbImage("core", "separator"),
  new SpawTbButton("core", "superscript", "isStandardFunctionEnabled", "isStandardFunctionPushed", "standardFunctionClick"),
  new SpawTbButton("core", "subscript", "isStandardFunctionEnabled", "isStandardFunctionPushed", "standardFunctionClick"),
  new SpawTbImage("core", "separator"),
);
?>
