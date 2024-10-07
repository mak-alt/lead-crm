<template>
    <div class="modal fade" id="deletemodal" ref="deleteModal" aria-hidden="true" aria-labelledby="..." tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <lord-icon
                        src="https://cdn.lordicon.com/tdrtiskw.json"
                        trigger="loop"
                        colors="primary:#f7b84b,secondary:#405189"
                        style="width:130px;height:130px">
                    </lord-icon>
                    <div class="mt-4 pt-4">
                        <h4>Are you sure you want to delete this?</h4>
                        <p class="text-muted">This action cannot be undo</p>
                        <!-- Toogle to second dialog -->
                        <button class="btn btn-warning" type="submit">
                            Continue
                        </button>
                        <button type="button" class="close" 
                            @click="$emit('close')"> X 
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        // data () {
        //     return {
        //        isModalVisible: false,
        //     };
        // },
        // methods: {
        //     showModal() {
        //        this.isModalVisible = true;
        //     },
        //     closeModal() {
        //        this.isModalVisible = false;
        //     }
        // },
    }
</script>