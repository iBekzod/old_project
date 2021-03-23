<input type="hidden"  name="longitude" value="">
<input type="hidden"  name="latitude" value="">
<div id="map_canvas">

</div>

<script type="text/javascript">
    function add_new_address(){
        $('#new-address-modal').modal('show');
    }

    $('.new-email-verification').on('click', function() {
        $(this).find('.loading').removeClass('d-none');
        $(this).find('.default').addClass('d-none');
        var email = $("input[name=email]").val();

        $.post('{{ route('user.new.verify') }}', {_token:'{{ csrf_token() }}', email: email}, function(data){
            data = JSON.parse(data);
            $('.default').removeClass('d-none');
            $('.loading').addClass('d-none');
            if(data.status == 2)
                AIZ.plugins.notify('warning', data.message);
            else if(data.status == 1)
                AIZ.plugins.notify('success', data.message);
            else
                AIZ.plugins.notify('danger', data.message);
        });
    });

    function initialize() {

        var map_canvas = document.getElementById('map_canvas');

        // Initialise the map
        var map_options = {
            center: location,
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(map_canvas, map_options)

        // Put all locations into array
        var locations = [
            @foreach($addresses as $location)
                [ {{ $location->latitude }}, {{ $location->longitude }} ]
            @endforeach

        ];

        for (i = 0; i < locations.length; i++) {
            var location = new google.maps.LatLng(locations[i][0], locations[i][1]);
            var marker = new google.maps.Marker({
                position: location,
                map: map,
            });
        }

        marker.setMap(map); // Probably not necessary since you set the map above

    }
</script>
