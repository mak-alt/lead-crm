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
                                    <li class="breadcrumb-item"><Link :href="route('saleshead.single.dashboard', { slug: currentWebsite.slug })">Dashboard</Link></li>
                                    <li class="breadcrumb-item"><Link :href="route('saleshead.leads', { slug: currentWebsite.slug })">Leads</Link></li>
                                    <li class="breadcrumb-item active">Create new</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <flash-messages/>
                <form @submit.prevent="save">
                    <div class="row">
                        <div class="col-xl-9">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 mb-3">
                                            <select-input v-model="form.client_id" :required="true" :error="form.errors.client_id" class="mt-10" label="Select Client" autofocus autocapitalize="off">
                                                <option value="">Select Client</option>
                                                <option v-for="client in clients" :key="client.id" :value="client.id">{{ client.user_no }} {{ client.name }}</option>
                                            </select-input>
                                            <span><a href="javascript:;" @click="showCreateClientModal">Didn't find your client? create new</a></span>
                                        </div>
                                        <div class="col-xl-6 col-md-6 mb-3">
                                            <text-input v-model="form.subject" :error="form.errors.subject" class="mt-10" label="Subject" placeholder="Enter Subject" type="text" autofocus autocapitalize="off" />
                                        </div>
                                        <div class="col-xl-6 col-md-6 mb-3">
                                            <text-input v-model="form.type" :error="form.errors.type" class="mt-10" label="Type" placeholder="Enter Type" type="text" autofocus autocapitalize="off" />
                                        </div>
                                        <div class="col-xl-3 col-md-3 mb-3">
                                            <text-input v-model="form.start_date_time" data-provider="flatpickr" data-date-format="Y-m-d" data-enable-time :error="form.errors.start_date_time" class="mt-10 flatpickr-date" label="Start Date Time" placeholder="Select Start Date & Time" type="text" autofocus autocapitalize="off" />
                                        </div>
                                        <div class="col-xl-3 col-md-3 mb-3">
                                            <text-input v-model="form.due_date_time" data-provider="flatpickr" data-date-format="Y-m-d" data-enable-time :error="form.errors.due_date_time" class="mt-10 flatpickr-date" label="Due Date Time" placeholder="Select Due Date & Time" type="text" autofocus autocapitalize="off" />
                                        </div>
                                        <div class="col-xl-3 col-md-3 mb-3">
                                            <select-input v-model="form.timezone_id" :error="form.errors.timezone_id" class="mt-10" label="Timezone" autofocus autocapitalize="off">
                                                <option v-for="timezone in timezones" :key="timezone.id" :value="timezone.id">{{ timezone.timezone }}</option>
                                            </select-input>
                                        </div>
                                        <div class="col-xl-3 col-md-3 mb-3">
                                            <select-input v-model="form.priority" :error="form.errors.priority" class="mt-10" label="Priority" autofocus autocapitalize="off">
                                                <option value="low">Low</option>
                                                <option value="medium">Medium</option>
                                                <option value="high">High</option>
                                            </select-input>
                                        </div>
                                        <div class="col-xl-12 col-md-12 mb-3">
                                            <text-input v-model="form.expected_amount" :error="form.errors.expected_amount" class="mt-10" label="Expected Payment" placeholder="Enter Amount in USD" type="number" autofocus autocapitalize="off" />
                                        </div>
                                        <div class="col-xl-12 col-md-12 mb-3">
                                            <textarea-input v-model="form.description" :error="form.errors.description" class="mt-10" label="Description" placeholder="Enter Details" autofocus autocapitalize="off" />
                                        </div>
                                        <div class="col-xl-12">
                                            <file-pond
                                            v-model="form.myFiles" 
                                            ref="pond"
                                            class-name="my-pond"
                                            allow-multiple="true"
                                            max-files="2"
                                            max-file-size="50MB"
                                            label-max-file-size-exceeded="File is too large"
                                            label-max-file-size="Maximum file size is {filesize}"
                                            label-idle="Drop files here... You can upload upto 2 files"
                                            :accepted-file-types="accepted_file_types"
                                            :files="form.myFiles"
                                             />
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                                <div class="card-footer">
                                    <button class="btn btn-outline-primary" :disabled="form.processing" type="submit">Save</button>
                                </div>
                            </div><!-- end card -->
                        </div><!-- end col -->
                        <div class="col-xl-3">
                            <div class="card">
                                <div class="card-header p-2 m-0">
                                    <h6 class="card-title mb-0">Status</h6>
                                    <p class="text-muted font-sm">Assign lead stage</p>
                                </div>
                                <div class="card-body p-2">
                                    <div class="scrollable">
                                        <ul class="p-1">
                                            <li class="mt-1" v-for="stage in stages" :key="stage.id">
                                                <div class="form-check form-check-outline form-check-primary mb-0">
                                                    <input class="form-check-input" v-model="form.stageId" :value="stage.id" type="radio" :id="stage.id">
                                                    <label class="form-check-label" :for="stage.id">
                                                        {{ stage.name }}
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header p-2 m-0">
                                    <h6 class="card-title mb-0">Source</h6>
                                    <p class="text-muted font-sm">Assign lead source</p>
                                </div>
                                <div class="card-body p-2">
                                    <div class="scrollable">
                                        <ul class="p-1">
                                            <li class="mt-1" v-for="source in sources" :key="source.id">
                                                <div class="form-check form-check-outline form-check-primary mb-0">
                                                    <input class="form-check-input" v-model="form.sourceId" :value="source.id" type="radio" :id="source.id">
                                                    <label class="form-check-label" :for="source.id">
                                                        {{ source.name }}
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

        <!-- Create client modal -->
        <create-client>
            <template #content>
                <form @submit.prevent="createClient">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-3">
                            <text-input v-model="create_client.name" :error="create_client.errors.name" class="mt-10" label="Name" placeholder="Enter Client Name" type="text" autofocus autocapitalize="off" />
                        </div>
                        <div class="col-xl-12 col-md-12 mb-3">
                            <text-input v-model="create_client.email" :error="create_client.errors.email" class="mt-10" label="Email" placeholder="Enter Client Email" type="email" autofocus autocapitalize="off" />
                        </div>
                        <div class="col-xl-12 col-md-12 mb-3">
                            <text-input v-model="create_client.phone" :error="create_client.errors.phone" class="mt-10" label="Phone" placeholder="Enter Client Phone" type="number" autofocus autocapitalize="off" />
                        </div>
                        <div class="col-xl-12 col-md-12">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block" :disabled="create_client.processing">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </template>
        </create-client>

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
    import TextareaInput from '@/Shared/TextareaInput'
    import SelectInput from '@/Shared/SelectInput'
    import CreateClient from '@/Partials/CreateClient'

    import vueFilePond from 'vue-filepond'
    import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
    import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size'
    import 'filepond/dist/filepond.min.css'
    import { useForm } from '@inertiajs/inertia-vue3'

    // Create FilePond component
    const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginFileValidateSize);

    export default {
        components: {
           TextInput,
           SelectInput,
           TextareaInput,
           CreateClient,
           Footer,
           FilePond
        },
        data() {
            return {
              form: this.$inertia.form({
                client_id: '',
                start_date_time: null,
                due_date_time: null,
                timezone_id: 1,
                priority: 'low',
                expected_amount: null,
                description: null,
                stageId: null,
                sourceId: null,
                subject: null,
                type: null,
                myFiles: [],
              }),
              create_client: this.$inertia.form({
                name: '',
                email: '',
                phone: ''
              }),
              accepted_file_types: this.accepted_file_types_global,
              file_size_error_flag: false,
              file_type_error_flag: false,
            }
        },
        layout: Layout,
        props: {
            stages: Object,
            sources: Object,
            timezones: Object,
            clients: Object
        },
        methods: {
            showCreateClientModal() {
                bootstrap.Modal.getOrCreateInstance('#createclientmodal').show();
            },
            hideCreateClientModal() {
                bootstrap.Modal.getOrCreateInstance('#createclientmodal').hide();
            },
            save() {
                this.form.myFiles = [];
                this.file_size_error_flag = false;
                this.file_type_error_flag = false;
                this.$refs.pond.getFiles().forEach((value, index) => {
                    if(value.file.size > this.max_file_size){
                        this.file_size_error_flag = true;
                    }
                    if(!this.accepted_file_types_array.includes(value.file.type)){
                        this.file_type_error_flag = true;
                    }
                    this.form.myFiles.push(value.file);
                });
                if(this.file_size_error_flag){
                    alert('File size exceeded');
                    return false;
                }
                if(this.file_type_error_flag){
                    alert('File type not supported');
                    return false;
                }
                this.form.post(route('saleshead.leads.store', { slug: this.currentWebsite.slug }),{
                    preserveScroll: true,
                    onSuccess: () => {
                        this.form.myFiles = [];
                        this.form.reset();
                        this.check();
                    },
                })
            },
            check() {
                this.form.stageId = this.stages.length > 0 ? this.stages[0].id : '';
                this.form.sourceId = this.sources.length > 0 ? this.sources[0].id : '';
            },
            createClient() {
                this.create_client.post(route('saleshead.client.store'),{
                    preserveScroll: true,
                    onSuccess: () => {
                        window.location.reload();
                    }
                });
            }
        },
        computed: {
            currentWebsite() {
                return this.$page.props.currentWebsite.details
            },
        },
        created() {
            this.check();
            this.injectScripts(this.asset('public/assets/js/app.js'));

        }
    }
</script>