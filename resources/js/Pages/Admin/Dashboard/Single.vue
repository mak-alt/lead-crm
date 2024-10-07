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
                        <div class="col-xl-6">
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
                        <div class="col-xl-6">
                            <div class="tasks-container" v-if="recent_tasks.length > 0">
                                <h4 class="fw-bold">Recent Tasks</h4>
                                    <div class="card" id="leadsList">
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Task ID</th>
                                                            <th scope="col">Title</th>
                                                            <th scope="col">Assigned To</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Created At</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="task,index in recent_tasks" :key="task.id">
                                                            <td>
                                                                <a href="javascript:;">#{{ task.task_no }}</a>
                                                            </td>
                                                            <td>{{ task.name }}</td>
                                                            <td>
                                                                <div class="flex-shrink-0">
                                                                    <div class="avatar-group">
                                                                        <a v-for="member in task.members" href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" :title="member.name">
                                                                            <img :src="member.profile_image" alt="" class="rounded-circle avatar-xxs">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-outline-primary ms-1"> <a href="javascript:;">{{ task.task_stage.name }}</a></span>
                                                            </td>
                                                            <td>
                                                                {{ task.created_at }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
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
            recent_tasks: Object,
            teams: Object,
            website: Object
        },
        computed: {
            
        },
        created() {
            this.injectScripts(this.asset('public/assets/js/app.js'));
        }
    }
</script>