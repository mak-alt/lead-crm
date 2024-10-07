<template>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">TEAMS</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><Link :href="route('prod.dashboard', { slug: currentWebsite.slug })">Dashboards</Link></li>
                                    <li class="breadcrumb-item"><Link :href="route('prod.teams', { slug: currentWebsite.slug})">Teams</Link></li>
                                    <li class="breadcrumb-item active">Edit {{ team.team_no }}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <flash-messages/>
                <form @submit.prevent="save">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12">
                                            <text-input v-model="form.name" :error="form.errors.name" class="mt-10" label="Name" placeholder="Enter Team Name" type="text" autofocus autocapitalize="off" />
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                                <div class="card-footer">
                                    <button class="btn btn-outline-primary" :disabled="form.processing" type="submit">Save</button>
                                </div>
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div><!-- end row -->
                </form>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <Footer />
    </div>
</template>

<script>
    import Layout from '@/Shared/Layout'
    import Footer from '@/Shared/Footer'
    import TextInput from '@/Shared/TextInput'
    import SelectInput from '@/Shared/SelectInput'

    export default {
        components: {
           TextInput,
           SelectInput,
           Footer,
        },
        data() {
            return {
              form: this.$inertia.form({
                name: this.team.name
              }),
            }
        },
        layout: Layout,
        props: {
            team: Object
        },
        methods: {
            save() {
                this.form.post(route('prod.teams.update', { id: this.team.id, slug: this.currentWebsite.slug }),{
                    preserveScroll: true,
                    onSuccess: () => this.form.reset(),
                })
            }
        },
        computed: {
            currentWebsite() {
                return this.$page.props.currentWebsite.details
            },
        }
    }
</script>