<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=false'></script>
<script type='text/javascript'>
    (function($)
    {
        $(document).ready(function()
        {
            var canvas = $('div#gmap_canvas');
            canvas.css('width',<?php echo '"' . $options['width'] . '"'; ?>);
            canvas.css('height',<?php echo '"' . $options['height'] . '"'; ?>);
            
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode(
            {
               address : <?php echo '"' . $options['address'] . '"'; ?> 
            }, function(results, status)
            {
                if ( status == google.maps.GeocoderStatus.OK)
                {
                    var latlng = results[0].geometry.location;
                    var map = new google.maps.Map(canvas.get(0), 
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

<div id='gmap_canvas'></div>