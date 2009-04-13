<h2>Newsletter</h2>

<p>Subscribe to our newsletter to recieve emails and useful news articles.</p>

<?=form_open('newsletters/subscribe'); ?>

<p><label for="email">Email:</label>
<?=form_input(array('name'=>'email', 'value'=>'user@example.com', 'size'=>20, 'onfocus'=>"this.value=''")); ?>
</p>

<p><?=form_submit('btnSignup', 'Subscribe') ?></p>

<?=form_close(); ?>