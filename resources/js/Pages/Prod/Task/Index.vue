<template>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">TASKS</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><Link :href="route('prod.dashboard')">Dashboard</Link></li>
                                    <li class="breadcrumb-item active">TASKS</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <flash-messages/>
                <div class="row">
                        <div class="col-lg-12">
                            <div class="card" id="leadsList">
                                <div class="card-header border-0">
                                    <form @submit.prevent="filter">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-xl-3">
                                                <div class="search-box">
                                                  <input type="text" autocomplete="off" v-model="filters.search" class="form-control search" placeholder="Search..." />
                                                  <i class="ri-search-line search-icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-xl-1">
                                                <button class="btn btn-outline-primary" :disabled="filters.processing" type="submit">Filter</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-body p-0">
                                <!-- Hoverable Rows -->
                                <form >
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Task ID</th>
                                                    <th scope="col">Title</th>
                                                    <th scope="col">Due Date Time</th>
                                                    <th scope="col">Priority</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Created At</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="task,index in tasks.data" :key="task.id">
                                                    <td>
                                                        <Link :href="route('prod.tasks.show', { slug: currentWebsite.slug, id: task.id, team_id: task.task_stage.team.id })">{{ task.task_no }}</Link>
                                                    </td>
                                                    <td>{{ task.name }}</td>
                                                    <td>{{ task.due_date_time }}</td>
                                                    <td>{{ task.priority }}</td>
                                                    <td>
                                                        <span class="badge badge-outline-primary ms-1"> {{ task.task_stage.name }} </span>
                                                    </td>
                                                    <td>
                                                        {{ task.created_at }}
                                                    </td>
                                                    <td>
                                                        <div class="hstack gap-3 flex-wrap">
                                                            <Link :href="route('prod.tasks.show',{slug: currentWebsite.slug, id: task.id, team_id: task.task_stage.team.id})" class="link-success fs-15"><i class="ri-eye-line"></i></Link>
                                                           
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div><!-- end card body -->
                            <div class="card-footer">
                                <pagination class="mt-6" :links="tasks.links" />
                            </div>
                            </div>

                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
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
    import Pagination from '@/Shared/Pagination'
    import TextInput from '@/Shared/TextInput'
    import SelectInput from '@/Shared/SelectInput'
    import DeleteModal from '@/Shared/DeleteModal'
    import SearchFilter from '@/Shared/SearchFilter'

    export default {
        components: {
           TextInput,
           SelectInput,
           Footer,
           Pagination,
           DeleteModal,
           SearchFilter,
        },
        data() {
            return {
              filters: this.$inertia.form({
               search : '',
              }),
            }
        },
        layout: Layout,
        props: {
            tasks: Object,
        },
        methods: {
            filter() {
                this.filters.get(route('prod.tasks',{ slug: this.currentWebsite.slug }),{
                    preserveState: true,
                    preserveScroll: true    
                })
            },
        },
        computed: {
            currentWebsite() {
                return this.$page.props.currentWebsite.details
            },
        }
    }
</script>