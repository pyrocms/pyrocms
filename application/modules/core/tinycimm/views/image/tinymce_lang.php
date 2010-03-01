tinyMCE.addI18n('en.tinycimm',{
	<?php 
	foreach($dialog_lang as $key => $value){
		echo $key.": '{$value}',\n";
	}?>
});
