<template>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="createsubtaskcanvas" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header bg-light">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Sub Tasks</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <!--end offcanvas-header-->
        <form action="#" class="d-flex flex-column justify-content-end h-100">
            <slot name="content"></slot>
        </form>
    </div>
</template>

<style scoped>
    .offcanvas.offcanvas-end{
        width: 50%;
    }
</style>

<script>
    export default {
    }
</script>