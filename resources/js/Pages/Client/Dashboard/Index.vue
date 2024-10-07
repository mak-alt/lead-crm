<template>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">CRM</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                    <li class="breadcrumb-item active">CRM</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="single-web-contents">
                    <div class="row mb-3 pb-1">
                       <div class="col-12">
                          <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                             <div class="flex-grow-1">
                                <h4 class="fs-16 mb-1">Hello, {{ user.name }}!</h4>
                             </div>
                          </div>
                          <!-- end card header -->
                       </div>
                       <!--end col-->
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate" v-for="website in websites">
                                <Link href="#">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> {{ website.domain }}</p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <h5 class="text-success fs-14 mb-0">
                                                    <i class="ri-arrow-right-line fs-13 align-middle"></i> 
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </Link>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                </div>
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
    import SelectInput from '@/Shared/SelectInput'

    export default {
        components: {
           Footer,
           SelectInput
        },
        layout: Layout,
        props: {
            data: Object
        },
        data() {
            return {
                
            }
        },
        methods: {
            
        },
        computed: {
            roles() {
                return this.$page.props.auth.user.roles
            },
            user() {
                return this.$page.props.auth.user
            },
            websites() {
                return this.$page.props.auth.user.websites
            }
        },
        created() {
            this.injectScripts(this.asset('public/assets/js/app.js'));
        }
    }
</script>