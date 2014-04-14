<script type="text/javascript">
    $(document).ready(function () {

        var $select = $('select.<?php echo $jquerySelector; ?>');

        $select.selectize({
            maxItems: null,
            loadThrottle: 100,
            create: false,
            valueField: <?php echo json_encode($valueField); ?>,
            searchField: <?php echo json_encode($searchFields); ?>,
            plugins: ['restore_on_backspace'],

            <?php if ($value): ?>
            options: <?php echo $value; ?>,
            <?php endif; ?>

            render: {
                item: function (item, escape) {
                    return <?php echo $itemTemplate; ?>
                },
                option: function (item, escape) {
                    return <?php echo $optionTemplate; ?>
                }
            },
            load: function (term, callback) {
                $.ajax({
                    type: 'POST',
                    url: SITE_URL + 'streams_core/public_ajax/field/relationship/search',
                    data: {
                        'relation_class': '<?php echo addslashes($relationClass); ?>',
                        'term': encodeURIComponent(term)
                    },
                    success: function (results) {

                        var json = $.parseJSON(results);

                        callback(json);
                    }
                });
            },
            onInitialize: function () {
                <?php if ($value): ?>
                this.setValue(<?php echo json_encode(array_keys($value->lists('id', 'id'))); ?>);
                <?php endif; ?>
            }
        });
    });
</script>
