<?php $this->load->helper('date');?>      
<?php echo form_open('admin/news/action');?>
	<table border="0" class="listTable">    
		<thead>
			<tr>
				<th><?php echo form_checkbox('action_to_all');?></th>
				<th><a href="#"><?php echo lang('news_post_label');?></a></th>
				<th class="width-10"><a href="#"><?php echo lang('news_category_label');?></a></th>
				<th class="width-10"><a href="#"><?php echo lang('news_date_label');?></a></th>
				<th class="width-5"><a href="#"><?php echo lang('news_status_label');?></a></th>
				<th class="width-10"><span><?php echo lang('news_actions_label');?></span></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="6">
					<div class="inner"><?php $this->load->view('admin/fragments/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php if (!empty($news)): ?>
				<?php foreach ($news as $article): ?>
					<tr>
						<td><input type="checkbox" name="action_to[]" value="<?php echo $article->id;?>" /></td>
						<td><?php echo $article->title;?></td>
						<td><?php echo $article->category_title;?></td>
						<td><?php echo date('M d, Y', $article->created_on);?></td>
						<td><?php echo ucfirst($article->status);?></td>
						<td>
							<?php if( $article->status == 'live' ): ?>
								<?php echo anchor('news/' .date('Y/m', $article->created_on) .'/'. $article->slug, lang('news_view_label'), 'target="_blank"') . ' | '; ?>
							<?php endif; ?>
							<?php echo anchor('admin/news/preview/'. $article->slug, lang('news_preview_label'), 'rel="modal" target="_blank"'); ?><br />
							<?php echo anchor('admin/news/edit/' . $article->id, lang('news_edit_label'));?> | 
							<?php echo anchor('admin/news/delete/' . $article->id, lang('news_delete_label'), array('class'=>'confirm')); ?>
						</td>
					</tr>
			<?php endforeach; ?>
		<?php else: ?>
				<tr>
					<td colspan="6"><?php echo lang('news_no_articles');?></td>
				</tr>
		<?php endif; ?>
		</tbody>	
	</table>
	<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete', 'publish') )); ?>
<?php echo form_close();?>
