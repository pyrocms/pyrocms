
<?php foreach($plugins as $group): ?>
	<?php foreach ($group as $plugin): ?>
		<div id="<?php echo $plugin['slug'] ?>">
			<section class="method-area">
				<?php if ($plugin['self_doc'] and $plugin['self_doc']): ?>
					<?php foreach ($plugin['self_doc'] as $method => $doc): ?>
						<div class="method">
							<h1><?php echo $plugin['slug'].':'.$method ?></h1>
							<p><?php echo htmlentities(isset($doc['description'][CURRENT_LANGUAGE]) ? $doc['description'][CURRENT_LANGUAGE] : isset($doc['description']['en']) ? $doc['description']['en'] : '') ?></p>
<pre>
<code>
<?php if (isset($doc['single']) and $doc['single']): ?>
{{ <?php echo $plugin['slug'].':'.$method ?> }}

<?php endif ?>
<?php if (isset($doc['double']) and $doc['double']): ?>

{{ <?php echo $plugin['slug'].':'.$method ?> }}
    <?php echo (strpos($doc['variables'], '|') !== false ? '{{ '.str_replace('|', " }}\n    {{ ", $doc['variables']).' }}': $doc['variables'])."\n" ?>
{{ /<?php echo $plugin['slug'].':'.$method ?> }}
<?php endif; ?>
</code>
</pre>
							<?php if (isset($doc['attributes']) and $doc['attributes']): ?>
								<table cellpadding="0" cellspacing="0">
									<tbody>
										<tr>
											<th>Name</th>
											<th>Type</th>
											<th>Flags</th>
											<th>Default</th>
											<th>Required</th>
										</tr>
										<?php foreach ($doc['attributes'] as $attribute => $details): ?>
											<tr>
												<td><?php echo $attribute ?></td>
												<td><?php echo (isset($details['type']) ? str_replace('|', ' | ', $details['type']) : '') ?></td>
												<td><?php echo (isset($details['flags']) ? str_replace('|', ' | ', $details['flags']) : '') ?></td>
												<td><?php echo (isset($details['default']) and is_scalar($details['default']) and $details['default'] !== '') ? $details['default'] : lang('global:check-none') ?></td>
												<td><?php echo (isset($details['required']) and $details['required']) ? lang('global:yes') : lang('global:no') ?></td>
											</tr>
										<?php endforeach ?>
									</tbody>
								</table>
							<?php endif; ?>
						</div>

						<hr>
					<?php endforeach; ?>
				<?php endif ?>
			</section>
		</div>
	<?php endforeach; ?>
<?php endforeach; ?>