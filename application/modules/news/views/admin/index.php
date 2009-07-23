<? $this->load->helper('date');?>      
<?= form_open('admin/news/action');?>
	<table border="0" class="listTable">    
		<thead>
			<tr>
				<th class="first"><div></div></th>
				<th><a href="#"><?=lang('news_post_label');?></a></th>
				<th class="width-10"><a href="#"><?=lang('news_category_label');?></a></th>
				<th class="width-10"><a href="#"><?=lang('news_date_label');?></a></th>
				<th class="width-5"><a href="#"><?=lang('news_status_label');?></a></th>
				<th class="last width-10"><span><?=lang('news_actions_label');?></span></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="6">
					<div class="inner"><? $this->load->view('admin/fragments/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<? if (!empty($news)): ?>
				<? foreach ($news as $article): ?>
					<tr>
						<td><input type="checkbox" name="action_to[]" value="<?=$article->id;?>" /></td>
						<td><?=$article->title;?></td>
						<td><?=$article->category_title;?></td>
						<td><?=date('M d, Y', $article->created_on);?></td>
						<td><?=ucfirst($article->status);?></td>
						<td>
							<? if( $article->status == 'live' ): ?>
								<?= anchor('news/' .date('Y/m', $article->created_on) .'/'. $article->slug, lang('news_view_label'), 'target="_blank"') . ' | '; ?>
							<? endif; ?>
							<?= anchor('admin/news/preview/'. $article->slug, lang('news_preview_label'), 'rel="modal" target="_blank"'); ?><br />
							<?= anchor('admin/news/edit/' . $article->id, lang('news_edit_label'));?> | 
							<?= anchor('admin/news/delete/' . $article->id, lang('news_delete_label'), array('class'=>'confirm')); ?>
						</td>
					</tr>
			<? endforeach; ?>
		<? else: ?>
				<tr>
					<td colspan="6"><?=lang('news_no_articles');?></td>
				</tr>
		<? endif; ?>
		</tbody>	
	</table>
	<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete', 'publish') )); ?>
<?=form_close();?>
