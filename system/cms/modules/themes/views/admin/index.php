<section class="title">
	<h4><?php echo $module_details['name']; ?></h4>
</section>

<section class="item">
	<?php if ($themes): ?>
	
		<?php echo form_open('admin/themes/set_default'); ?>
		<?php echo form_hidden('method', $this->method); ?>
		<table>
			<thead>
				<tr>
					<th width="50px" class="align-center"><?php echo lang('themes.default_theme_label'); ?></th>
					<th width="15%"><?php echo lang('themes.theme_label'); ?></th>
					<th><?php echo lang('global:description'); ?></th>
					<th width="15%"><?php echo lang('global:author'); ?></th>
					<th width="50px" class="align-center"><?php echo lang('themes.version_label'); ?></th>
					<th width="250px"></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="6">
						<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach($themes as $theme): ?>
				<tr>
					<td class="align-center"><input type="radio" name="theme" value="<?php echo $theme->slug; ?>"
					<?php echo isset($theme->is_default) ? 'checked="checked" ' : ''; ?>/>
					</td>
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
	
					<td class="align-center"><?php echo $theme->version; ?></td>
					<td class="actions">
						<a href="<?php echo $theme->screenshot; ?>" rel="screenshots" title="<?php echo $theme->name; ?>" class="button modal"><?php echo lang('buttons.preview'); ?></a>
						<?php echo anchor('admin/themes/options/' . $theme->slug, lang('themes.options'), 'title="'.$theme->name.'" class="button options modal"'); ?>
						<?php if($theme->slug != 'admin_theme') { echo anchor('admin/themes/delete/' . $theme->slug, lang('buttons.delete'), 'class="confirm button delete"'); } ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<div>
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )); ?>
		</div>
		
		<?php echo form_close(); ?>
	
	<?php else: ?>
		<div class="blank-slate">
			<p><?php echo lang('themes.no_themes_installed'); ?></p>
		</div>
	<?php endif; ?>
</section>