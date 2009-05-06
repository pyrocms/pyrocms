<!-- TinyMCE -->
<?= js('tiny_mce/tiny_mce.js'); ?>

<script type="text/javascript">

	// Basic options
	tinyMCE.init({
		
		mode : "specific_textareas",
		editor_selector : "wysiwyg-simple",
		editor_class : "wysiwyg-simple",
		theme : "basic"
			
    });


	// General options
    tinyMCE.init({

    	mode : "specific_textareas",
		editor_selector : "wysiwyg-advanced",
		editor_class : "wysiwyg-advanced",

		width : 650,
		constrain_menus : true,
		
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,advhr,advimage,advlink,emotions,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,fullscreen,noneditable,visualchars,xhtmlxtras,template",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,blockquote,|,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,undo,redo,|,search,replace,|,bullist,numlist,|,outdent,indent,|,insertdate,inserttime,|,forecolor,backcolor",
		theme_advanced_buttons3 : "image,anchor,link,unlink,|,charmap,emotions,media,advhr,|,print,preview,|,ltr,rtl,|,code,|,fullscreen",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		//content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		//template_external_list_url : "lists/template_list.js",
		//external_link_list_url : "lists/link_list.js",
		//external_image_list_url : "lists/image_list.js",
		//media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		/*template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}*/
    });
	
</script>
<!-- /TinyMCE -->
