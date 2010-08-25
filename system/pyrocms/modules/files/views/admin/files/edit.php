<script type="text/javascript">
(function($) {
	$(function() {
		$("#closebox").click(function() {
			parent.jQuery.colorbox.close();
			return false;
		});
		$('#closenew').click(function() {
			parent.$('#colorbox').close();
			return false;
		});
	});
})(jQuery);
</script>
<a href="#" id="closebox">Close</a>
<a href="#" id="closenew"> Close 2</a>