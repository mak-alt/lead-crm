<template>
    <div>
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <Logo />
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <div v-if="user.role.slug === 'super-admin'">
                        <ul class="navbar-nav" id="navbar-nav" v-if="isUrl('admin/main')">
                            <li class="menu-title"><span data-key="t-menu">Welcome {{ user.name }}</span></li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('admin.dashboard')">
                                    <i class="ri-dashboard-2-line"></i> <span data-key="t-widgets">Dashboard</span>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('admin.websites')">
                                    <i class="ri-globe-line"></i> <span data-key="t-widgets">Websites</span>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('admin.roles')">
                                    <i class="ri-shield-line"></i> <span data-key="t-widgets">Roles</span>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('admin.users')">
                                    <i class="ri-user-line"></i> <span data-key="t-widgets">Users</span>
                                </Link>
                            </li>
                            <li class="menu-title"><span data-key="t-menu">Your Websites</span></li>
                            <li class="nav-item" v-for="website in websites" :key="website.id">
                                <Link class="nav-link menu-link" :href="route('bridge.make',{ slug: website.slug })">
                                    <span data-key="t-widgets">{{ website.name }}/{{ website.domain }}</span>
                                </Link>
                            </li>
                        </ul>
                        <ul class="navbar-nav" id="navbar-nav" v-else>
                            <li class="menu-title"><span data-key="t-menu">{{ currentWebsite.name }}/{{ currentWebsite.domain }}</span></li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('admin.single.dashboard', { slug: currentWebsite.slug })">
                                    <i class="ri-dashboard-2-line"></i> <span data-key="t-widgets">Dashboard</span>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('admin.leads', { slug: currentWebsite.slug })">
                                    <i class="ri-pulse-line"></i> <span data-key="t-widgets">Leads</span>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('admin.teams', { slug: currentWebsite.slug })">
                                    <i class="ri-team-line"></i> <span data-key="t-widgets">Teams</span>
                                </Link>
                            </li>
                        </ul>
                    </div>
                    <div v-if="user.role.slug === 'partner' ">
                        <ul class="navbar-nav" id="navbar-nav" v-if="isUrl('partner/main')">
                            <li class="menu-title"><span data-key="t-menu">Welcome {{ user.name }}</span></li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('partner.dashboard')">
                                    <i class="ri-dashboard-2-line"></i> <span data-key="t-widgets">Dashboard</span>
                                </Link>
                            </li>
                            <li class="menu-title"><span data-key="t-menu">Your Websites</span></li>
                            <li class="nav-item" v-for="website in websites" :key="website.id">
                                <Link class="nav-link menu-link" :href="route('bridge.make',{ slug: website.slug })">
                                    <span data-key="t-widgets">{{ website.name }}/{{ website.domain }}</span>
                                </Link>
                            </li>
                        </ul>
                        <ul class="navbar-nav" id="navbar-nav" v-else>
                            <li class="menu-title"><span data-key="t-menu">{{ currentWebsite.name }}/{{ currentWebsite.domain }}</span></li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('partner.single.dashboard', { slug: currentWebsite.slug })">
                                    <i class="ri-dashboard-2-line"></i> <span data-key="t-widgets">Dashboard</span>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('partner.leads', { slug: currentWebsite.slug })">
                                    <i class="ri-pulse-line"></i> <span data-key="t-widgets">Leads</span>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('partner.teams', { slug: currentWebsite.slug })">
                                    <i class="ri-team-line"></i> <span data-key="t-widgets">Teams</span>
                                </Link>
                            </li>
                        </ul>
                    </div>
                    <div v-if="user.role.slug === 'sales-head' ">
                        <ul class="navbar-nav" id="navbar-nav" v-if="isUrl('saleshead/main')">
                            <li class="menu-title"><span data-key="t-menu">Welcome {{ user.name }}</span></li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('saleshead.dashboard')">
                                    <i class="ri-dashboard-2-line"></i> <span data-key="t-widgets">Dashboard</span>
                                </Link>
                            </li>
                            <li class="menu-title"><span data-key="t-menu">Your Websites</span></li>
                            <li class="nav-item" v-for="website in websites" :key="website.id">
                                <Link class="nav-link menu-link" :href="route('bridge.make',{ slug: website.slug })">
                                    <span data-key="t-widgets">{{ website.name }}/{{ website.domain }}</span>
                                </Link>
                            </li>
                        </ul>
                        <ul class="navbar-nav" id="navbar-nav" v-else>
                            <li class="menu-title"><span data-key="t-menu">{{ currentWebsite.name }}/{{ currentWebsite.domain }}</span></li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('saleshead.single.dashboard', { slug: currentWebsite.slug })">
                                    <i class="ri-dashboard-2-line"></i> <span data-key="t-widgets">Dashboard</span>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('saleshead.leads', { slug: currentWebsite.slug })">
                                    <i class="ri-pulse-line"></i> <span data-key="t-widgets">Leads</span>
                                </Link>
                            </li>
                        </ul>
                    </div>
                    <div v-if="user.role.slug === 'sales' ">
                        <ul class="navbar-nav" id="navbar-nav" v-if="isUrl('sales/main')">
                            <li class="menu-title"><span data-key="t-menu">Welcome {{ user.name }}</span></li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('sales.dashboard')">
                                    <i class="ri-dashboard-2-line"></i> <span data-key="t-widgets">Dashboard</span>
                                </Link>
                            </li>
                            <li class="menu-title"><span data-key="t-menu">Your Websites</span></li>
                            <li class="nav-item" v-for="website in websites" :key="website.id">
                                <Link class="nav-link menu-link" :href="route('bridge.make',{ slug: website.slug })">
                                    <span data-key="t-widgets">{{ website.name }}/{{ website.domain }}</span>
                                </Link>
                            </li>
                        </ul>
                        <ul class="navbar-nav" id="navbar-nav" v-else>
                            <li class="menu-title"><span data-key="t-menu">{{ currentWebsite.name }}/{{ currentWebsite.domain }}</span></li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('sales.single.dashboard', { slug: currentWebsite.slug })">
                                    <i class="ri-dashboard-2-line"></i> <span data-key="t-widgets">Dashboard</span>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('sales.leads', { slug: currentWebsite.slug })">
                                    <i class="ri-pulse-line"></i> <span data-key="t-widgets">Leads</span>
                                </Link>
                            </li>
                        </ul>
                    </div>
                    <div v-if="user.role.slug === 'production-head' ">
                        <ul class="navbar-nav" id="navbar-nav" v-if="isUrl('prodhead/main')">
                            <li class="menu-title"><span data-key="t-menu">Welcome {{ user.name }}</span></li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('prodhead.dashboard')">
                                    <i class="ri-dashboard-2-line"></i> <span data-key="t-widgets">Dashboard</span>
                                </Link>
                            </li>
                            <li class="menu-title"><span data-key="t-menu">Your Websites</span></li>
                            <li class="nav-item" v-for="website in websites" :key="website.id">
                                <Link class="nav-link menu-link" :href="route('bridge.make',{ slug: website.slug })">
                                    <i class="ri-globe-line"></i> <span data-key="t-widgets">{{ website.name }}</span>
                                </Link>
                            </li>
                        </ul>
                        <ul class="navbar-nav" id="navbar-nav" v-else>
                            <li class="menu-title"><span data-key="t-menu">{{ currentWebsite.name }}</span></li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('prodhead.single.dashboard', { slug: currentWebsite.slug })">
                                    <i class="ri-dashboard-2-line"></i> <span data-key="t-widgets">Dashboard</span>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('prodhead.teams', { slug: currentWebsite.slug })">
                                    <i class="ri-team-line"></i> <span data-key="t-widgets">Teams</span>
                                </Link>
                            </li>
                        </ul>
                    </div>
                    <div v-if="user.role.slug === 'production' ">
                        <ul class="navbar-nav" id="navbar-nav" v-if="isUrl('prod/main')">
                            <li class="menu-title"><span data-key="t-menu">Welcome {{ user.name }}</span></li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('prod.dashboard')">
                                    <i class="ri-dashboard-2-line"></i> <span data-key="t-widgets">Dashboard</span>
                                </Link>
                            </li>
                            <li class="menu-title"><span data-key="t-menu">Your Websites</span></li>
                            <li class="nav-item" v-for="website in websites" :key="website.id">
                                <Link class="nav-link menu-link" :href="route('bridge.make',{ slug: website.slug })">
                                    <i class="ri-globe-line"></i> <span data-key="t-widgets">{{ website.name }}</span>
                                </Link>
                            </li>
                        </ul>
                        <ul class="navbar-nav" id="navbar-nav" v-else>
                            <li class="menu-title"><span data-key="t-menu">{{ currentWebsite.name }}</span></li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('prod.single.dashboard', { slug: currentWebsite.slug })">
                                    <i class="ri-dashboard-2-line"></i> <span data-key="t-widgets">Dashboard</span>
                                </Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('prod.tasks', { slug: currentWebsite.slug })">
                                    <i class="ri-apps-2-line"></i> <span data-key="t-widgets">Tasks</span>
                                </Link>
                            </li>
                        </ul>
                    </div>
                    <div v-if="user.role.slug === 'client' ">
                        <ul class="navbar-nav" id="navbar-nav" v-if="isUrl('client/main')">
                            <li class="menu-title"><span data-key="t-menu">Welcome {{ user.name }}</span></li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" :href="route('client.dashboard')">
                                    <i class="ri-dashboard-2-line"></i> <span data-key="t-widgets">Dashboard</span>
                                </Link>
                            </li>
                        </ul>
                        <ul class="navbar-nav" id="navbar-nav" v-else>
                            <li class="menu-title"><span data-key="t-menu">{{ currentWebsite.name }}</span></li>
                            <li class="nav-item">
                                <Link class="nav-link menu-link" href="#">
                                    <i class="ri-apps-2-line"></i> <span data-key="t-widgets">Tasks</span>
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
    </div>
    <!-- Left Sidebar End -->
</template>

<script>

import Logo from '@/Shared/Logo'

export default {
    components: {
        Logo
    },
    methods: {
        isUrl(...urls) {
            let currentUrl = this.$page.url.substr(1)
            if (urls[0] === '') {
                return currentUrl === ''
            }
            return urls.filter((url) => currentUrl.startsWith(url)).length
        },
    },
    computed: {
        websites() {
            return this.$page.props.auth.user.websites
        },
        user() {
            return this.$page.props.auth.user
        },
        currentWebsite() {
            return this.$page.props.currentWebsite.details
        },
    },
    created() {
    }
}

</script>