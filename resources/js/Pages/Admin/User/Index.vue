<template>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">USERS</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Dashboards</Link></li>
                                    <li class="breadcrumb-item active">Users</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <flash-messages/>
                <!-- end page title -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header border-0">
                                <form @submit.prevent="filter">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-xl-3">
                                            <div class="search-box">
                                              <input type="text" autocomplete="off" v-model="filters.name" class="form-control search" placeholder="Search..." />
                                              <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-xl-1">
                                            <button class="btn btn-outline-primary" :disabled="filters.processing" type="submit">Filter</button>
                                        </div>
                                        <div class="col-sm-auto ms-auto">
                                            <div class="hstack gap-2">
                                                <button class="btn btn-soft-danger" type="button" @click="bulkDelete"><i class="ri-delete-bin-2-line"></i></button>
                                                <Link :href="route('admin.users.create')" class="btn btn-primary" id="create-btn"><i class="ri-add-line align-bottom me-1"></i> Create User</Link>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body p-0">
                                <!-- Hoverable Rows -->
                                <form>
                                    <table class="table table-hover table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" @click="checkAll" type="checkbox">
                                                    </div>
                                                </th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Assigned Role</th>
                                                <th scope="col">Assigned Websites</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="user in users.data" :key="user.id">
                                                <th scope="row">
                                                    <div class="form-check">
                                                        <input class="form-check-input" :value="all_ids" type="checkbox" :id="user.id" @change="updateCheckAll(user.id,$event);" :checked="isCheckAll">
                                                    </div>
                                                </th>
                                                <td>{{ user.name }}</td>
                                                <td>{{ user.email }}</td>
                                                <td>
                                                    <span class="badge badge-outline-primary ms-1" v-for="role in user.roles" :key="role.id"> <a href="javascript:;">{{ role.slug }}</a></span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-outline-primary ms-1" v-for="website in user.websites" :key="website.id"> <Link :href="route('admin.websites.edit',{ id: website.id })">{{ website.domain }}</Link></span>
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <Link data-bs-toggle="tooltip" data-bs-placement="top" title="Click to change status" :class="user.status == 1 ? 'badge badge-outline-success' : 'badge badge-outline-danger'" :href="route('admin.users.status.update')" method="post" :data="{ id: user.id, status: user.status == 1 ? 0 : 1 }">{{ user.status == 1 ? 'Active' : 'Inactive' }}
                                                        </Link>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="hstack gap-3 flex-wrap">
                                                        <Link :href="route('admin.users.edit',{'id':user.id})" class="link-success fs-15"><i class="ri-edit-2-line"></i></Link>
                                                        <Link method="post" :href="route('admin.users.delete',{id:user.id})" class="link-danger fs-15"><i class="ri-delete-bin-line"></i></Link>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div><!-- end card body -->
                            <div class="card-footer">
                                <pagination class="mt-6" :links="users.links" />
                            </div>
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div><!-- end row -->
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

    export default {
        components: {
           TextInput,
           SelectInput,
           Footer,
           Pagination,
           DeleteModal
        },
        data() {
            return {
              filters: this.$inertia.form({
                name: '',
                // domain: '',
                // status: null
              }),
              delete: this.$inertia.form({

              }),
              bulk_delete: this.$inertia.form({
                all_ids: [],
              }),
              isCheckAll: false,
              isModalVisible: false,
            }
        },
        layout: Layout,
        props: {
            users: Object
        },
        methods: {
            filter() {
                this.filters.get(route('admin.users'),{
                    preserveState: true,
                    preserveScroll: true    
                })
            },
            checkAll(){
                this.bulk_delete.all_ids = [];
                this.isCheckAll = !this.isCheckAll;
                if(this.isCheckAll){
                    this.users.data.forEach((value, index) => {
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
                    this.bulk_delete.post(route('admin.users.bulk.delete'));
                }
            }
        },
        created() {
            this.injectScripts(this.asset('public/assets/js/app.js'));
        }
    }
</script>