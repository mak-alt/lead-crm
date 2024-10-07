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
                                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Dashboard</Link></li>
                                    <li class="breadcrumb-item"><Link :href="route('admin.users')">Users</Link></li>
                                    <li class="breadcrumb-item active">Create new</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <flash-messages/>
                <form @submit.prevent="save">
	                <div class="row">
	                    <div class="col-xl-8">
	                        <div class="card">
	                            <div class="card-body">
	                                <div class="row">
	                                	<div class="col-xl-6 col-md-6 mb-3">
	                                		<text-input v-model="form.name" :error="form.errors.name" :required="true" class="mt-10" label="Name" placeholder="Enter Full Name" type="text" autofocus autocapitalize="off" />
	                                	</div>
	                                	<div class="col-xl-6 col-md-6 mb-3">
	                                		<text-input v-model="form.email" :error="form.errors.email" :required="true" class="mt-10" label="Email" placeholder="Enter Email" type="text" autofocus autocapitalize="off" />
	                                	</div>
	                                </div>
	                            </div><!-- end card body -->
	                            <div class="card-footer">
	                            	<button class="btn btn-outline-primary" :disabled="form.processing" type="submit">Save</button>
	                            </div>
	                        </div><!-- end card -->
	                    </div><!-- end col -->
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-header m-0">
                                    <h6 class="card-title mb-0">Roles</h6>
                                </div>
                                <div class="card-body">
                                    <div data-init="simplebar" class="scrollable">
                                        <ul class="list-group list-group-flush">
                                            <div v-if="error" class="form-error invalid-feedback">{{ form.errors.roleId }}</div>
                                            <li v-for="(role,index) in roles" :key="role.id">
                                                <div class="form-check form-check-outline form-check-primary mb-0">
                                                    <input class="form-check-input" v-model="form.roleId" :value="role.id" type="radio" :id="role.id">
                                                    <label class="form-check-label" :for="role.id">
                                                        {{ role.name }} ({{ role.slug }})
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header m-0">
                                    <h6 class="card-title mb-0">Websites</h6>
                                </div>
                                <div class="card-body">
                                    <div data-init="simplebar" class="scrollable">
                                        <ul class="list-group list-group-flush">
                                            <li v-for="website in websites" :key="website.id">
                                                <div class="form-check form-check-outline form-check-primary mb-0">
                                                    <input class="form-check-input" v-model="form.websiteIds" :value="website.id" type="checkbox" :id="website.id">
                                                    <label class="form-check-label" :for="website.id">
                                                        {{ website.name }} ({{ website.domain }})
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
	                </div><!-- end row -->
                </form>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <Footer />
    </div>
</template>

<style scoped>
    .scrollable{
      overflow-y: auto;
      max-height: 300px;
    }
</style>

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
		      	name: '',
		      	email: '',
                websiteIds: [],
                roleId: 2,
		      }),
		    }
		},
        layout: Layout,
        props: {
        	websites: Object,
            roles: Object
        },
        methods: {
        	save() {
        		this.form.post(route('admin.users.store'),{
        			preserveScroll: true,
					onSuccess: () => this.form.reset(),
        		})
        	}
        },
        created() {

        }
    }
</script>