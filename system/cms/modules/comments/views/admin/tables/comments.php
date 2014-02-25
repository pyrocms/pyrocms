<?php if ( ! $comments->isEmpty()): ?>

    <table border="0" class="table-list" cellspacing="0">
        <thead>
            <tr>
                <th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')) ?></th>
                <th width="25%"><?php echo lang('comments:message_label') ?></th>
                <th width="25%"><?php echo lang('comments:item_label') ?></th>
                <th><?php echo lang('global:author') ?></th>
                <th width="80"><?php echo lang('comments:date_label') ?></th>
                <th width="<?php echo Settings::get('moderate_comments') ? 265 : 120 ?>"></th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <td colspan="7">
                    <div class="inner"><?php $this->load->view('admin/partials/pagination') ?></div>
                </td>
            </tr>
        </tfoot>

        <tbody>
            <?php foreach ($comments as $comment): ?>
                <tr>
                    <td><?php echo form_checkbox('action_to[]', $comment->id) ?></td>
                    <td>
                        <a href="<?php echo site_url('admin/comments/preview/'.$comment->id) ?>" rel="modal" target="_blank">
                            <?php if (strlen($comment->comment) > 30 ): ?>
                                <?php echo character_limiter((Settings::get('comment_markdown') and $comment->parsed > '') ? strip_tags($comment->parsed) : $comment->comment, 30) ?>
                            <?php else: ?>
                                <?php echo (Settings::get('comment_markdown') and $comment->parsed > '') ? strip_tags($comment->parsed) : $comment->comment ?>
                            <?php endif ?>
                        </a>
                    </td>

                    <td>
                        <strong><?php echo lang($comment->singular) ?: $comment->singular ?>: </strong>
                        <?php echo anchor($comment->cp_uri ?: $comment->uri, $comment->entry_title ?: '#'.$comment->entry_id) ?>
                    </td>

                    <td>

                        <?php if ($comment->user): ?>
                            <?php echo anchor('admin/users/edit/'.$comment->user_id, "{$comment->user->profile->first_name} {$comment->user->profile->last_name}") ?>
                        <?php else: ?>
                            <?php echo $comment->user_name ?>
                        <?php endif ?>

                    </td>

                    <td><?php echo format_date($comment->created_at) ?></td>

                    <td class="align-center buttons buttons-small">
                        <?php if (Settings::get('moderate_comments')): ?>
                            <?php if ($comment->is_active): ?>
                                <?php echo anchor('admin/comments/unapprove/'.$comment->id, lang('buttons:deactivate'), array('class' => 'button deactivate')) ?>
                            <?php else: ?>
                                <?php echo anchor('admin/comments/approve/'.$comment->id, lang('buttons:activate'), array('class' => 'button activate')) ?>
                            <?php endif ?>
                        <?php endif ?>

                        <?php echo mailto($comment->user_email, lang('global:email'), array('class' => 'button')) ?>
                        <?php echo anchor('admin/comments/edit/'.$comment->id, lang('global:edit'), array('class' => 'button edit')) ?>
                        <?php echo anchor('admin/comments/report/'.$comment->id, 'Report', array('class'=>'button edit')) ?>
                        <?php echo anchor('admin/comments/delete/'.$comment->id, lang('global:delete'), array('class'=>'confirm button delete')) ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

<?php else: ?>

    <div class="no_data"><?php echo lang('comments:no_comments') ?></div>

<?php endif;
