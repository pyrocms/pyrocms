<script type="text/javascript">
    const APPLICATION_URL = "{{ request()->root() }}";
    const APPLICATION_REFERENCE = "{{ env('APPLICATION_REFERENCE') }}";
    const APPLICATION_DOMAIN = "{{ env('APPLICATION_DOMAIN') }}";

    const CSRF_TOKEN = "{{ csrf_token() }}";
    const APP_DEBUG = "{{ config('app.debug') }}";
    const APP_URL = "{{ config('app.url') }}";
    const REQUEST_ROOT = "{{ request()->root() }}";
    const REQUEST_ROOT_PATH = "{{ \Illuminate\Support\Arr::get(parse_url(request()->root()), 'path') }}";
    const TIMEZONE = "{{ config('app.timezone') }}";
    const LOCALE = "{{ config('app.locale') }}";
</script>
