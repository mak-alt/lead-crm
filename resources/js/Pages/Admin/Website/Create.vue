<template>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">WEBSITES</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><Link :href="route('admin.dashboard')">Dashboards</Link></li>
                                    <li class="breadcrumb-item"><Link :href="route('admin.websites')">Websites</Link></li>
                                    <li class="breadcrumb-item active">Create new</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <flash-messages/>
                <form @submit.prevent="save">
	                <div class="row">
	                    <div class="col-xl-6">
	                        <div class="card">
	                            <div class="card-body">
	                                <div class="row">
	                                	<div class="col-xl-6 col-md-6">
	                                		<text-input v-model="form.name" :error="form.errors.name" :required="true" class="mt-10" label="Name" placeholder="Enter Website Name" type="text" autofocus autocapitalize="off" />
	                                	</div>
	                                	<div class="col-xl-6 col-md-6">
	                                		<text-input v-model="form.domain" :error="form.errors.domain" :required="true" class="mt-10" label="Domain" placeholder="Enter Website Domain" type="text" autofocus autocapitalize="off" />
	                                	</div>
	                                </div>
	                            </div><!-- end card body -->
	                            <div class="card-footer">
	                            	<button class="btn btn-outline-primary" :disabled="form.processing" type="submit">Save</button>
	                            </div>
	                        </div><!-- end card -->
	                    </div><!-- end col -->
	                </div><!-- end row -->
                </form>
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
		      	domain: ''
		      }),
		    }
		},
        layout: Layout,
        props: {
        	
        },
        methods: {
        	save() {
        		this.form.post(route('admin.websites.store'),{
        			preserveScroll: true,
					onSuccess: () => this.form.reset(),
        		})
        	}
        }
    }
</script>