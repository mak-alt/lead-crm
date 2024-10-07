<template>
    <div :class="$attrs.class" v-for="stage in leadstages" :key="stage.id">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-medium text-muted mb-0">{{ stage.name }}</p>
                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" :data-target="stage.leads_count">{{ stage.leads_count }}</span></h2>
                    </div>
                </div>
            </div><!-- end card body -->
        </div> <!-- end card-->
    </div>
    <!--end col-->
</template>

<script>
    export default {
        inheritAttrs: false,
        props: {
            leadstages: Object 
        }
    }
</script>