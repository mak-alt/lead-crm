<template>
    <form class="mt-4">
        <div class="row g-3">
            <div class="col-12">
                <label for="exampleFormControlTextarea1" class="form-label text-body">Start Discussion</label>
                <textarea ref="textComment" @input="resize" class="form-control bg-light border-light" v-model="comment" id="exampleFormControlTextarea1" rows="3" placeholder="Enter your message..."></textarea>
            </div>
            <div class="col-12 text-end">
                <!-- <button type="button" class="btn btn-ghost-secondary btn-icon waves-effect me-1">
                    <i class="ri-attachment-line fs-16"></i>
                    <input type="file" name="file" style="opacity:0;visibility:none">
                </button> -->
                <button type="button" class="btn btn-success" @click="postComment">Post Comment</button>
            </div>
        </div>
    </form>
</template>

<script>
    
    export default {
        props: {
            lead: Object
        },
        data() {
            return {
                comment: null
            }
        },
        methods: {
            postComment() {
                if(this.comment != null){
                    this.$emit('leaddiscussionevent', {
                        user: this.user.id,
                        comment: this.comment
                    });
                    
                    this.comment = null;
                }
            },
            resize() {
                this.$refs.textComment.style.scrollHeight + 'px';
            }
        },
        computed: {
            user() {
                return this.$page.props.auth.user
            },
        },
    }

</script>