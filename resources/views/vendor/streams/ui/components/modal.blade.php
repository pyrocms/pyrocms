<div x-data="{
                
    visible: false,
    content: '',

    showModal() {
        
        this.visible = true;

        return this;
    },

    hideModal() {
        
        this.visible = false;

        return this;
    },

    loadModal(params) {

        if (!this.visible) {
            this.showModal();
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
}" x-on:keydown.escape.window="visible = false">

    <div class="fixed top-0 left-0 h-screen w-screen z-40 inset-0 overflow-y-auto" x-show="visible" x-cloak>

        <div
            x-on:load-modal.window="loadModal($event.detail);"
            x-on:show-modal.window="showModal();"
            x-on:hide-modal.window="hideModal();"
            class="absolute top-0 left-0 h-screen w-screen bg-dark opacity-50"></div>

        <div class="flex flex-col items-center justify-center h-screen w-screen">

            <div class="absolute w-1/2 align-top overflow-scroll bg-white rounded-lg text-left shadow-xl max-h-screen">
                <div class="text-2xl text-buttons cursor-pointer"
                >
                    <span @click="visible === true ? hideModal() : showModal();"> (CLOSE)</span>
                    <span>{{ $modal->text ?: 'Title Here' }}</span>
                </div>
            </div>

        </div>

    </div>
</div>

{{-- <script>
    function modal() {
            return ;
        }
</script> --}}
