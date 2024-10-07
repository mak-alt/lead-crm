<template>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">ROLES</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                    <li class="breadcrumb-item active">Roles</li>
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
                            <div class="card-body p-0">
                                <!-- Hoverable Rows -->
                                <form>
									<table class="table table-hover table-nowrap mb-0">
									    <thead>
									        <tr>
									            <th scope="col">Name</th>
									            <th scope="col">Slug</th>
									            <th scope="col">Status</th>
									            <th scope="col">Action</th>
									        </tr>
									    </thead>
									    <tbody>
									        <tr v-for="role in roles" :key="role.id">
									            <td>{{ role.name }}</td>
									            <td>{{ role.slug }}</td>
									            <td><p class="badge badge-outline-primary">{{ role.status == 1 ? 'Active' : 'Inactive' }}</p></td>
									            <td>
									                <div class="hstack gap-3 flex-wrap">
									                    <a href="javascript:;" class="link-success fs-15"><i class="ri-edit-2-line"></i></a>
									                </div>
									            </td>
									        </tr>
									    </tbody>
									</table>
								</form>
                            </div><!-- end card body -->
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

    export default {
        components: {
           Footer,
        },
        data() {
		    return {
		      
		    }
		},
        layout: Layout,
        props: {
        	roles: Object
        },
        methods: {
        	
        },
        created() {
            this.injectScripts(this.asset('public/assets/js/app.js'));
        }
    }
</script>