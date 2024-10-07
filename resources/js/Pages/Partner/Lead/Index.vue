<template>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">LEADS</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><Link :href="route('partner.dashboard')">Dashboard</Link></li>
                                    <li class="breadcrumb-item active">Leads</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <flash-messages/>
                <!-- end page title -->
                <div class="row">
                    <stage-counter class="col-xxl-2 col-sm-4" :leadstages="lead_stages" />
                </div>
                <div class="row">
                        <div class="col-lg-12">
                            <div class="card" id="leadsList">
                                <div class="card-header border-0">
                                    <form @submit.prevent="filter">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-xl-2">
                                                <div class="search-box">
                                                  <input type="text" autocomplete="off" v-model="filters.search" class="form-control search" placeholder="Enter Lead ID..." />
                                                  <i class="ri-search-line search-icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <text-input v-model="filters.due_date" data-provider="flatpickr" data-date-format="Y-m-d" class="mt-10 flatpickr-date" placeholder="Filter By Due Date" type="text" autofocus autocapitalize="off" />
                                            </div>
                                            <div class="col-xl-1">
                                                <button class="btn btn-outline-primary" :disabled="filters.processing" type="submit">Filter</button>
                                            </div>
                                            <div class="col-sm-auto ms-auto">
                                                <div class="hstack gap-2">
                                                    <!-- <button class="btn btn-soft-danger" type="button" @click.prevent="bulkDelete"><i class="ri-delete-bin-2-line"></i></button> -->
                                                    <Link :href="route('partner.leads.create', { slug: currentWebsite.slug })" class="btn btn-primary" id="create-btn"><i class="ri-add-line align-bottom me-1"></i> Add Leads</Link>
                                                </div>
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
                                                    <th scope="col">
                                                        <div class="form-check">
                                                            <input class="form-check-input" @click="checkAll" type="checkbox">
                                                        </div>
                                                    </th>
                                                    <th scope="col">Lead ID</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Phone</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Source</th>
                                                    <th scope="col">User</th>
                                                    <th scope="col">Created At</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="lead,index in leads.data" :key="lead.id">
                                                    <th scope="row">
                                                        <div class="form-check">
                                                            <input class="form-check-input" :value="all_ids" type="checkbox" :id="lead.id" @change="updateCheckAll(lead.id,$event);" :checked="isCheckAll">
                                                        </div>
                                                    </th>
                                                    <td>
                                                        <Link :href="route('partner.leads.show', { slug: currentWebsite.slug, id: lead.id })">{{ lead.lead_no }}</Link>
                                                    </td>
                                                    <td>{{ lead.client.name }}</td>
                                                    <td>{{ lead.client.email }}</td>
                                                    <td>{{ lead.client.phone ?? '-' }}</td>
                                                    <td>
                                                        <span class="badge badge-outline-primary ms-1"> <a href="javascript:;">{{ lead.stage.name }}</a></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-outline-success ms-1"> <a href="javascript:;">{{ lead.source.name }}</a></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-outline-info ms-1"> <a href="javascript:;">{{ lead.user.name }}</a></span>
                                                    </td>
                                                    <td>
                                                        {{ lead.created_at }}
                                                    </td>
                                                    <td>
                                                        <div class="hstack gap-3 flex-wrap">
                                                            <Link :href="route('partner.leads.show',{slug: currentWebsite.slug, id: lead.id})" class="link-success fs-15"><i class="ri-eye-line"></i></Link>
                                                            <Link :href="route('partner.leads.edit',{slug: currentWebsite.slug, id: lead.id})" class="link-success fs-15"><i class="ri-edit-2-line"></i></Link>
                                                           
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div><!-- end card body -->
                            <div class="card-footer">
                                <pagination class="mt-6" :links="leads.links" />
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
    import StageCounter from '@/Pages/Admin/Lead/Partials/StageCounter'

    export default {
        components: {
           TextInput,
           SelectInput,
           Footer,
           Pagination,
           DeleteModal,
           SearchFilter,
           StageCounter
        },
        data() {
            return {
              filters: this.$inertia.form({
               search: '',
               name: '',
               due_date: ''
              }),
              delete: this.$inertia.form({

              }),
              bulk_delete: this.$inertia.form({
                all_ids: [],
              }),
              isCheckAll: false,
            }
        },
        layout: Layout,
        props: {
            leads: Object,
            lead_stages: Object
        },
        methods: {
            filter() {
                this.filters.get(route('partner.leads',{ slug: this.currentWebsite.slug }),{
                    preserveState: true,
                    preserveScroll: true    
                })
            },
            checkAll(){
                this.bulk_delete.all_ids = [];
                this.isCheckAll = !this.isCheckAll;
                if(this.isCheckAll){
                    this.leads.data.forEach((value, index) => {
                       this.bulk_delete.all_ids.push(value.id);
                    });
                }
            },
            updateCheckAll(row,event) {
                if(event.target.checked){
                    if(this.bulk_delete.all_ids.includes(row) === false){
                        this.bulk_delete.all_ids.push(row);
                    }
                }else{
                    var index = this.bulk_delete.all_ids.indexOf(row);
                    if(index !== -1)
                    this.bulk_delete.all_ids.splice(index,1);
                }
            },
            bulkDelete(){
                if(this.bulk_delete.all_ids.length > 0){
                    this.bulk_delete.post(route('partner.leads.bulk.delete', { slug: this.currentWebsite.slug }), {
                        preserveScroll: true,
                        preserveState: true
                    });
                }
            }
        },
        computed: {
            currentWebsite() {
                return this.$page.props.currentWebsite.details
            },
        },
        created() {
            this.injectScripts(this.asset('public/assets/js/app.js'));
        }
    }
</script>