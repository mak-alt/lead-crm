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
                
                <!-- end page title -->
                <div class="website-contents">
                    <div class="row"  v-if="data.count_total_websites > 0">
                        <div class="col-xl-12">
                            <div class="card crm-widget">
                                <div class="card-body p-0">
                                    <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0">
                                        <div class="col">
                                            <div class="py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">Active Users <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-user-line display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0"><span class="counter-value" :data-target="data.count_active_users">0</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                        <div class="col">
                                            <div class="mt-3 mt-md-0 py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">Active Websites <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-globe-line display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0"><span class="counter-value" :data-target="data.count_active_websites">0</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                        <div class="col">
                                            <div class="mt-3 mt-md-0 py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">Total Leads <i class="ri-arrow-down-circle-line text-danger fs-18 float-end align-middle"></i></h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-pulse-line display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0"><span class="counter-value" :data-target="data.count_total_leads">0</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                        <div class="col">
                                            <div class="mt-3 mt-lg-0 py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">Total Teams <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-team-line display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0"><span class="counter-value" :data-target="data.count_total_teams">0</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                        <div class="col">
                                            <div class="mt-3 mt-lg-0 py-4 px-3">
                                                <h5 class="text-muted text-uppercase fs-13">Total Tasks <i class="ri-arrow-down-circle-line text-danger fs-18 float-end align-middle"></i></h5>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-task-line display-6 text-muted"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h2 class="mb-0"><span class="counter-value" :data-target="data.count_total_tasks">0</span></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col -->
                                    </div><!-- end row -->
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div><!-- end row -->
                    <div class="row justify-content-center" v-else>
                        <div class="col-xxl-4 col-lg-6">
                            <Link href="">
                                <div class="card card-body text-center">
                                   <div class="avatar-sm mx-auto mb-3">
                                      <div class="avatar-title bg-soft-success text-success fs-17 rounded">
                                         <i class="ri-add-line"></i>
                                      </div>
                                   </div>
                                   <h4 class="card-title">Add New Website</h4>
                                   <p class="card-text text-muted">This will also create roles according to the website.</p>
                                   <Link :href="route('admin.websites.create')" class="btn btn-success">Add New</Link>
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>

                <div class="single-web-contents">
                    <div class="row mb-3 pb-1">
                       <div class="col-12">
                          <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                             <div class="flex-grow-1">
                                <h4 class="fs-16 mb-1">Good Morning, {{ user.name }}!</h4>
                             </div>
                          </div>
                          <!-- end card header -->
                       </div>
                       <!--end col-->
                    </div>
                    <div class="row main-row">
                        <div class="col-6">
                            <div class="row" v-if="lead_stages.length > 0">
                                <div class="col-12">
                                    <h4 class="fw-bold">Leads</h4>
                                </div>
                                <div class="col-xl-4 col-md-8" v-for="stage in lead_stages">
                                   <!-- card -->
                                   <div class="card card-animate">
                                      <div class="card-body">
                                         <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                               <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> {{ stage.name }}</p>
                                            </div>
                                         </div>
                                         <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                               <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" :data-target="stage.leads_count">{{ stage.leads_count }}</span> </h4>
                                               <!-- <a href="" class="text-decoration-underline">View net earnings</a> -->
                                            </div>
                                         </div>
                                      </div>
                                      <!-- end card body -->
                                   </div>
                                   <!-- end card -->
                                </div>
                            </div><!-- end row -->
                            <div class="row" v-if="teams.length > 0">
                                <div class="col-12">
                                    <h4 class="fw-bold">Teams</h4>
                                </div>
                                <div class="col-xl-4 col-md-8" v-for="team in teams">
                                   <!-- card -->
                                   <div class="card card-animate">
                                      <div class="card-body">
                                         <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 overflow-hidden">
                                               <p class="text-uppercase fw-medium text-truncate mb-0"> {{ team.name }}</p>
                                            </div>
                                         </div>
                                         <div class="d-flex align-items-end justify-content-between mt-4">
                                            <div>
                                               <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" >{{ team.team_no }}</span> </h4>
                                               <!-- <a href="" class="text-decoration-underline">View net earnings</a> -->
                                            </div>
                                         </div>
                                      </div>
                                      <!-- end card body -->
                                   </div>
                                   <!-- end card -->
                                </div>
                            </div><!-- end row -->
                        </div>
                        <div class="col-6">
                            <div class="leads-container" v-if="leads.length > 0">
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
                                                    <tr v-for="lead,index in leads" :key="lead.id">
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
                            <div class="tasks-container" v-if="tasks.length > 0">
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
                                                        <tr v-for="task,index in tasks" :key="task.id">
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
                website_id: 1,
                date: '',
                lead_stages: [],
                teams: [],
                leads: [],
                tasks: [],
            }
        },
        methods: {
            getAnalytics() {
                axios.get(route('admin.dashboard.analytics'),{ params: { website_id: this.website_id, date: this.date } }).then((response) => {
                        this.lead_stages = response.data.data.lead_stages;
                        this.teams = response.data.data.teams;
                        this.leads = response.data.data.leads;
                        this.tasks = response.data.data.tasks;
                    
                });
            }
        },
        computed: {
            roles() {
                return this.$page.props.auth.user.roles
            },
            user() {
                return this.$page.props.auth.user
            }
        },
        created() {
            this.getAnalytics();
            this.injectScripts(this.asset('public/assets/js/app.js'));
        }
    }
</script>