		<?php echo form_open('admin/themes/set_default'); ?>

			<?php if(!empty($themes)): ?>
	<table>
		<thead>
			<tr>
				<th>Default</th>
				<th>Name</th>
				<th>Description</th>
				<th>Author</th>
				<th>Version</th>
				<th><?php echo lang('action_label'); ?></th>
			</tr>
		</thead>
		<tbody>
				<?php foreach($themes as $theme): ?>
			<tr>
				<td><input type="radio" name="theme" value="<?php echo $theme->slug; ?>" <?php echo $this->settings->default_theme == $theme->slug ? 'checked="checked" ' : ''; ?>/></td>
				<td><?php if (!empty($theme->website)): ?>
								<?php echo anchor($theme->website, $theme->name, array('target'=>'_blank')); ?>
							<?php else: ?>
								<?php echo $theme->name; ?>
							<?php endif; ?></td>
				<td><?php echo $theme->description; ?></td>
				<td><?php if ($theme->author_website): ?>
								<?php echo anchor($theme->author_website, $theme->author, array('target'=>'_blank')); ?>
							<?php else: ?>
								<?php echo $theme->author; ?>
							<?php endif; ?></td>

				<td><?php echo $theme->version; ?></td>
				<td><a href="<?php echo $theme->screenshot; ?>" rel="screenshots" title="<?php echo $theme->name; ?>" class="minibutton">Preview</a>  <a href="#"  class="minibutton">Delete</a></td>
			</tr>
				<?php endforeach; ?>
		</tbody>
	</table>
	<script type="text/javascript">
		jQuery(function($) {
			$("a[rel='screenshots']").colorbox({width: "40%", height: "50%"});
		});
	</script>

			<?php else: ?>
				<div class="blank-slate">
					<h2><?php echo lang('themes.no_themes_installed'); ?></h2>
				</div>
			<?php endif; ?>
		
		<div class="float-right">
			<button type="submit" name="btnAction">Save</button>
		</div>
		
		<?php echo form_close(); ?>
		
