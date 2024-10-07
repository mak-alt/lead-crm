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
                <div class="website-contents">
                    <div class="row">
                        <div class="col-xl-12">
                            <h4 class="mb-3">LEADS</h4>
                            <div class="card crm-widget">
                                <div class="card-body p-0">
                                    <div class="row g-0">
                                        <div class="col" v-for="lead_stage in lead_stages">
                                            <div class="py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">{{ lead_stage.name }} <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-space-ship-line display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0"><span class="counter-value" :data-target="lead_stage.leads_count">0</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                    </div><!-- end row -->
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div><!-- end row -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="leads-container" v-if="recent_leads.length > 0">
                                <h4 class="fw-bold">Recent Leads</h4>
                                <div class="card" id="leadsList">
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Lead ID</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Email</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Created At</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="lead,index in recent_leads" :key="lead.id">
                                                        <td>
                                                            <a href="javascript:;">#{{ lead.lead_no }}</a>
                                                        </td>
                                                        <td>{{ lead.client.name }}</td>
                                                        <td>{{ lead.client.email }}</td>
                                                        <td>
                                                            <span class="badge badge-outline-primary ms-1"> <a href="javascript:;">{{ lead.stage.name }}</a></span>
                                                        </td>
                                                        <td>
                                                            {{ lead.created_at }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                    </div><!-- end row -->
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
            lead_stages: Object,
            recent_leads: Object,
            website: Object
        },
        computed: {
            
        },
        created() {
            this.injectScripts(this.asset('public/assets/js/app.js'));
        }
    }
</script>