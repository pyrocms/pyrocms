<?php $instance_id = isset($options['widget']) ? $options['widget']['instance_id'] : rand(2000, 3000); ?>

<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=false'></script>
<script type='text/javascript'>
    (function($)
    {
        $(document).ready(function()
        {
            var canvas<?php echo $instance_id; ?> = $('div#gmap_canvas<?php echo $instance_id; ?>');
            canvas<?php echo $instance_id; ?>.css('width',<?php echo '"' . $options['width'] . '"'; ?>);
            canvas<?php echo $instance_id; ?>.css('height',<?php echo '"' . $options['height'] . '"'; ?>);

            var geocoder<?php echo $instance_id; ?> = new google.maps.Geocoder();
            geocoder<?php echo $instance_id; ?>.geocode(
            {
               address : <?php echo '"' . $options['address'] . '"'; ?>
            }, function(results, status)
            {
                if ( status == google.maps.GeocoderStatus.OK)
                {
                    var latlng = results[0].geometry.location;
                    var map = new google.maps.Map(canvas<?php echo $instance_id; ?>.get(0),
                    {
                       zoom : <?php echo $options['zoom']; ?>,
                       center : latlng,
                       mapTypeId : google.maps.MapTypeId.ROADMAP,
                       mapTypeControl : true,
                       mapTypeControlOptions :
                       {
                           style : google.maps.MapTypeControlStyle.DROPDOWN_MENU
                       },
                       navigationControl : true,
                       navigationControlOptions :
                       {
                           style : google.maps.NavigationControlStyle.SMALL
                       },
					   streetViewControl: true
                    });

                    var marker = new google.maps.Marker(
                    {
                       map : map,
                       position : latlng
                    });

                    <?php if ( $options['description'] != '' ) : ?>

                        var info = new google.maps.InfoWindow(
                        {
                           content : <?php echo '"' . $options['description'] . '"'; ?>
                        });
                        google.maps.event.addListener(marker, 'click', function()
                        {
                            info.open(map, marker);
                        });

                    <?php endif; ?>
                }
            });
        });
    })(jQuery);
</script>

<div id='gmap_canvas<?php echo $instance_id; ?>'></div>