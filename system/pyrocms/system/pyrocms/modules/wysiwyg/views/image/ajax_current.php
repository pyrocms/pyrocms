<h4><?php echo @$title; ?></h4>

<span id="filepath">
    <?php foreach($folders as $folder): ?>
        &raquo; <?php echo $folder->title; ?>
    <?php endforeach; ?>
</span>