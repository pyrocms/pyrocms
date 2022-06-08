{{-- {!! Assets::tag('/vendor/streams/core/js/index.js') !!}
{!! Assets::tag('/vendor/streams/api/js/index.js') !!} --}}
{!! Assets::tag('/vendor/streams/ui/js/index.js') !!}

{!! Assets::collection('scripts')->tags() !!}

<script>

    // streams.serviceProviders = window.streams.serviceProviders || [
    //     streams.core.StreamsServiceProvider,
    //     streams.ui.UiServiceProvider,
    //     streams.api.ApiServiceProvider,
    // ];

    // streams.core.app.bootstrap({
    //     providers: streams.serviceProviders
    // }).then(app => {
    //     return app.boot();
    // }).then(app => {
    //     return app.start();
    // });

</script>
