	
	<? if(!empty($pagination['links'])): ?>
	
	<div class="paginate">
		<? /*
		<span class="prev disabled"><a href="#">&lt;&lt;</a></span>
		<span><a href="#">1</a></span>
		<span>...</span>
		<span><a href="#">4</a></span>
		<span class="current roundedBordersLite">5</span>
		<span><a href="#">6</a></span>
		<span>...</span>
		<span><a href="#">11</a></span>
		<span class="next"><a href="#">&gt;&gt;</a></span>
		*/?>
		<?=$pagination['links'];?>
	</div>
	
	<!-- Pages: </p> -->
	<? endif; ?>