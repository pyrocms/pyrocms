<?php
if (isset($options["widget"])) {   // for use with widget instances
  $instanceId = $options["widget"]["instance_id"];
}
else {
  $instanceId = rand(2000,3000);   // for use with widget area
}
?>
<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=false'></script>
<script type='text/javascript'>
    (function($)
    {
        $(document).ready(function()
        {
            var canvas<?php echo $instanceId; ?> = $('div#gmap_canvas<?php echo $instanceId; ?>');
            canvas<?php echo $instanceId; ?>.css('width',<?php echo '"' . $options['width'] . '"'; ?>);
            canvas<?php echo $instanceId; ?>.css('height',<?php echo '"' . $options['height'] . '"'; ?>);

            var geocoder<?php echo $instanceId; ?> = new google.maps.Geocoder();
            geocoder<?php echo $instanceId; ?>.geocode(
            {
               address : <?php echo '"' . $options['address'] . '"'; ?>
            }, function(results, status)
            {
                if ( status == google.maps.GeocoderStatus.OK)
                {
                    var latlng = results[0].geometry.location;
                    var map = new google.maps.Map(canvas<?php echo $instanceId; ?>.get(0),
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

<div id='gmap_canvas<?php echo $instanceId; ?>'></div>