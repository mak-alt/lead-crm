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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">{{ website.name }}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                
                <!-- end page title -->
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
                        <div class="col-xl-12 col-lg-12">
                            <div class="d-flex align-items-center justify-content-center text-center" style="height:600px">
                                <div class="mt-3">
                                    <h3 class="text-uppercase">YOU WILL SEE YOUR ACTIVITY INSIGHTS HERE &#x1F60A;</h3>
                                </div>
                            </div>
                        </div><!-- end col -->
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

    export default {
        components: {
           Footer,
        },
        layout: Layout,
        props: {
            website: Object
        },
        computed: {
            user() {
                return this.$page.props.auth.user
            }
        },
    }
</script>