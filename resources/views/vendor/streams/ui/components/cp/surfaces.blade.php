{{-- <div x-data="window.streams.core.app.surfaces()"> --}}
<div _x-data="surfaces()">
    
    <div class="absolute top-0 left-0 h-screen w-screen bg-white dark:bg-black z-40 border-8 border-black dark:border-white overflow-scroll" x-show="enabled" x-cloak>
        
        <div class="text-2xl text-black dark:text-white cursor-pointer fixed top-0 right-0" @click="enabled === true ? disableSurfaces() : enableSurfaces();"
        x-on:load-surface.window="loadSurface($event.detail);"
        x-on:enable-surfaces.window="enableSurfaces();"
        x-on:disable-surfaces.window="disableSurfaces()"
        >Close</div>

        <div class="surfaces__stack" x-show="enabled">
            <div x-html="content"></div>
        </div>

    </div>

</div>

<script>
    function surfaces() {
            return {
                
                content: '',
                enabled: false,

                enableSurfaces() {
                    
                    this.enabled = true;

                    return this;
                },

                disableSurfaces() {
                    
                    this.enabled = false;

                    return this;
                },

                loadSurface(params) {

                    if (!this.enabled) {
                        this.enableSurfaces();
                    }

                    // Check if target is a selector
                    if (params.target.includes('#') || params.target.includes('.')) {

                        this.content = document.querySelector(params.target).innerHTML;

                        return;

                    } else {

                        window.streams.core.axios.get(params.target).then((response) => {
                            this.content = response.data;
                        });

                        return;
                    }
                }
            };
        }
</script>
