<template>
    <div data-simplebar style="height: 300px;" class="px-3 mx-n3 mb-2 discussionContainer" v-if="discussions.length > 0">
        <div class="d-flex mb-4 discussion-message" v-for="discussion in discussions">
            <div class="flex-shrink-0">
                <user-avatar :profile="discussion.user.profile_image" class="avatar-xs"/>
            </div>
            <div class="ms-3">
                <h5 class="fs-13">{{ discussion.user ? discussion.user.name : 'User' }} <small class="text-muted ms-2">{{ discussion.created_at }}</small></h5>
                <p class="text-muted text-muted bg-light p-2 border-1 rounded-3 comment">{{ discussion.comment }}</p>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .discussion-message .comment{
        white-space: pre-wrap;
    }
</style>

<script>
    
    import UserAvatar from '@/Shared/UserAvatar'

    export default {
        components: {
            UserAvatar
        },
        props: {
            discussions: Object
        },

    }

</script>