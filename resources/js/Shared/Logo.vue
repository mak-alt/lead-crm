<!-- LOGO -->
<template>
    <div class="navbar-brand-box" v-if="user.role.slug == 'super-admin'">
        <Link :href="route('admin.dashboard')" class="logo logo-dark">
            <span class="logo-sm">
                <img :src="asset('public/assets/images/logo-sm.png')" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img :src="asset('public/assets/images/logo-dark.png')" alt="" height="30">
            </span>
        </Link>

        <Link :href="route('admin.dashboard')" class="logo logo-light">
            <span class="logo-sm">
                <img :src="asset('public/assets/images/logo-sm.png')" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img :src="asset('public/assets/images/logo-light.png')" alt="" height="30">
            </span>
        </Link>
    </div>
    <div class="navbar-brand-box" v-if="user.role.slug == 'partner'">
        <Link :href="route('partner.dashboard')" class="logo logo-dark">
            <span class="logo-sm">
                <img :src="asset('public/assets/images/logo-sm.png')" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img :src="asset('public/assets/images/logo-dark.png')" alt="" height="30">
            </span>
        </Link>

        <Link :href="route('partner.dashboard')" class="logo logo-light">
            <span class="logo-sm">
                <img :src="asset('public/assets/images/logo-sm.png')" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img :src="asset('public/assets/images/logo-light.png')" alt="" height="30">
            </span>
        </Link>
    </div>
    <div class="navbar-brand-box" v-if="user.role.slug == 'sales-head'">
        <Link :href="route('saleshead.dashboard')" class="logo logo-dark">
            <span class="logo-sm">
                <img :src="asset('public/assets/images/logo-sm.png')" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img :src="asset('public/assets/images/logo-dark.png')" alt="" height="30">
            </span>
        </Link>

        <Link :href="route('saleshead.dashboard')" class="logo logo-light">
            <span class="logo-sm">
                <img :src="asset('public/assets/images/logo-sm.png')" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img :src="asset('public/assets/images/logo-light.png')" alt="" height="30">
            </span>
        </Link>
    </div>
    <div class="navbar-brand-box" v-if="user.role.slug == 'sales'">
        <Link :href="route('sales.dashboard')" class="logo logo-dark">
            <span class="logo-sm">
                <img :src="asset('public/assets/images/logo-sm.png')" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img :src="asset('public/assets/images/logo-dark.png')" alt="" height="30">
            </span>
        </Link>

        <Link :href="route('sales.dashboard')" class="logo logo-light">
            <span class="logo-sm">
                <img :src="asset('public/assets/images/logo-sm.png')" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img :src="asset('public/assets/images/logo-light.png')" alt="" height="30">
            </span>
        </Link>
    </div>
    <div class="navbar-brand-box" v-if="user.role.slug == 'production-head'">
        <Link :href="route('prodhead.dashboard')" class="logo logo-dark">
            <span class="logo-sm">
                <img :src="asset('public/assets/images/logo-sm.png')" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img :src="asset('public/assets/images/logo-dark.png')" alt="" height="30">
            </span>
        </Link>

        <Link :href="route('prodhead.dashboard')" class="logo logo-light">
            <span class="logo-sm">
                <img :src="asset('public/assets/images/logo-sm.png')" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img :src="asset('public/assets/images/logo-light.png')" alt="" height="30">
            </span>
        </Link>
    </div>
    <div class="navbar-brand-box" v-if="user.role.slug == 'production'">
        <Link :href="route('prod.dashboard')" class="logo logo-dark">
            <span class="logo-sm">
                <img :src="asset('public/assets/images/logo-sm.png')" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img :src="asset('public/assets/images/logo-dark.png')" alt="" height="30">
            </span>
        </Link>

        <Link :href="route('prod.dashboard')" class="logo logo-light">
            <span class="logo-sm">
                <img :src="asset('public/assets/images/logo-sm.png')" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img :src="asset('public/assets/images/logo-light.png')" alt="" height="30">
            </span>
        </Link>
    </div>
</template>
<script>

import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Link
    },
    data() {
        return {

        }
    },
    computed: {
        user() {
            return this.$page.props.auth.user
        }
    }
}

</script>