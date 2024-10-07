<template>
    <div class="modal fade" id="createteammodal" aria-hidden="true" aria-labelledby="..." tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create New Team In {{ website.name }}</h4>
                </div>
                <div class="modal-body">
                    <slot name="content"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            website: Object 
        },
        mounted() {
            // console.log(this.currentWebsite);
        }
    }
</script>