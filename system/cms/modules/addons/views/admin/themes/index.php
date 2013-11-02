<div class="p n-p-b">
	<?php file_partial('notices'); ?>
</div>

<div class="p">

	<div class="p-b">
		<?php file_partial('notices'); ?>
	</div>

	<!-- .panel -->
	<section class="panel panel-default">
	
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo lang('addons:plugins:core_field_types') ?></h3>
		</div>

		<!-- .panel-content -->
		<div class="panel-content">


			<?php if ($themes): ?>

				<?php echo form_open('admin/addons/themes/set_default') ?>
				<?php echo form_hidden('method', $this->method) ?>
				<table class="table table-hover n-m">
					<thead>
						<tr>
							<th width="50px" class="align-center"><?php echo lang('addons:themes:default_theme_label') ?></th>
							<th width="15%"><?php echo lang('addons:themes:theme_label') ?></th>
							<th class="collapse"><?php echo lang('global:description') ?></th>
							<th class="collapse" width="15%"><?php echo lang('global:author') ?></th>
							<th width="50px" class="align-center"><?php echo lang('addons:themes:version_label') ?></th>
							<th width="250px"></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($themes as $theme): ?>
						<?php if($theme->type != 'admin'): ?>
						<tr>
							<td class="align-center"><input type="radio" name="theme" value="<?php echo $theme->slug ?>"
								<?php echo isset($theme->is_default) ? 'checked' : '' ?> />
							</td>
							<td>
								<?php if ( ! empty($theme->website)): ?>
									<?php echo anchor($theme->website, $theme->name, array('target'=>'_blank')) ?>
								<?php else: ?>
									<?php echo $theme->name ?>
								<?php endif ?>
							</td>
							<td class="collapse"><?php echo $theme->description ?></td>
							<td class="collapse">
								<?php if ($theme->author_website): ?>
									<?php echo anchor($theme->author_website, $theme->author, array('target'=>'_blank')) ?>
								<?php else: ?>
									<?php echo $theme->author ?>
								<?php endif ?>
							</td>

							<td class="align-center"><?php echo $theme->version ?></td>
							<td class="text-right">
								<?php echo isset($theme_options) ? anchor('admin/addons/themes/options/'.$theme->slug, lang('addons:themes:options'), 'title="'.$theme->name.'" class="btn-sm btn-default"') : '' ?>
								<a href="<?php echo $theme->screenshot ?>" rel="screenshots" title="<?php echo $theme->name ?>" class="btn-sm btn-default modal"><?php echo lang('buttons:preview') ?></a>
								<?php if ($theme->slug != 'admin_theme') { echo anchor('admin/addons/themes/delete/'.$theme->slug, lang('buttons:delete'), 'class="confirm btn-sm btn-danger"'); } ?>
							</td>
						</tr>
						<?php endif; ?>
						<?php endforeach ?>
					</tbody>
				</table>

	
				<div class="panel-footer">
					<button type="submit" name="btnAction" value="save" class="btn-sm btn-success">
						<span><?php echo lang('buttons:save'); ?></span>
					</button>
				</div>

				<?php echo form_close() ?>

			<?php else: ?>
				<div class="blank-slate">
					<p><?php echo lang('addons:themes:no_themes_installed') ?></p>
				</div>
			<?php endif ?>


		</div>
		<!-- /.panel-content -->

	</section>
	<!-- /.panel -->


</div>