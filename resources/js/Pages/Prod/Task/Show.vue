<template>
	<div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Task Details</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active">{{ task.name }}</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xxl-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <h6 class="card-title mb-3 flex-grow-1 text-start d-inline">Time Tracking</h6>
                                <div class="mb-2">
                                    <lord-icon src="https://cdn.lordicon.com/kbtmbyzy.json" trigger="loop" colors="primary:#405189,secondary:#02a8b5" style="width:90px;height:90px"></lord-icon>
                                </div>
                                <h3 class="mb-1">{{ task.time_left }}</h3>
                                <h5 class="fs-14 mb-4" v-if="task.time_left !== 'Date Expired'">Left From Now</h5>
                                <p class="fs-14">Start Date Time : <span class="fs-14 badge bg-primary">{{ task.start_date_time_local }}</span></p>
                                <p class="fs-14">Due Date Time : <span class="fs-14 badge bg-danger">{{ task.due_date_time_local }}</span></p>
                            </div>
                        </div>
                        <!--end card-->
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="mb-4">
                                    <select-input v-model="stage_id" @change="updateStatus($event)">
                                        <option :value="stage.id" v-for="stage in stages">{{ stage.name }}</option>
                                    </select-input>
                                </div>
                                <div class="table-card">
                                    <table class="table mb-0">
                                        <tbody>
                                            <tr>
                                                <td class="fw-medium">Tasks No</td>
                                                <td>#{{ task.task_no }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium">Tasks Title</td>
                                                <td>{{ task.name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium">Priority</td>
                                                <td><span :class="task.priority == 'High' ? 'badge badge-soft-danger' : 'badge badge-soft-primary' ">{{ task.priority }}</span></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium">Status</td>
                                                <td><span class="badge badge-soft-secondary">{{ task.task_stage.name }}</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--end table-->
                                </div>
                            </div>
                        </div>
                        <!--end card-->
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="card-title">
                                    <div class="d-flex mb-3">
                                        <h6 class="card-title mb-0 flex-grow-1">Client Details</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-card">
                                    <table class="table mb-0">
                                        <tbody>
                                            <tr>
                                                <td class="fw-medium">Client ID</td>
                                                <td>#{{ task.client.user_no }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-medium">Client Name</td>
                                                <td>{{ task.client.name }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--end table-->
                                </div>
                            </div>
                        </div>
                        <!--end card-->
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex mb-3">
                                    <h6 class="card-title mb-0 flex-grow-1">Assigned To</h6>
                                </div>
                                <ul class="list-unstyled vstack gap-3 mb-0">
                                    <li v-for="member in task.members">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img :src="member.profile_image" alt="" class="avatar-xs rounded-circle">
                                            </div>
                                            <div class="flex-grow-1 ms-2">
                                                <h6 class="mb-1"><a href="javascript:;">{{ member.name }}</a></h6>
                                                <p class="text-muted mb-0">{{ member.email }}</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--end card-->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Attachments</h5>
                                <div class="vstack gap-2">
                                    <div class="border rounded border-dashed p-2" v-for="media in task.media">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title bg-light text-secondary rounded fs-24">
                                                        <i class="ri-folder-zip-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="fs-13 mb-1"><a href="javascript:void(0);" class="text-body text-truncate d-block">{{ media.file_name }}</a></h5>
                                                <div>{{ media.human_readable_size }}</div>
                                            </div>
                                            <div class="flex-shrink-0 ms-2">
                                                <div class="d-flex gap-1">
                                                    <a :href="media.original_url" class="btn btn-icon text-muted btn-sm fs-18"><i class="ri-download-2-line"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border rounded border-dashed border-primary p-2">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title bg-light text-secondary rounded fs-24">
                                                        <i class="ri-folder-zip-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="fs-13 mb-1"><a href="javascript:void(0);" @click="showCreateResource" class="text-body text-truncate d-block">Upload Resource</a></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end card-->
                    </div>
                    <!---end col-->
                    <div class="col-xxl-9">
                        <button type="button" class="btn btn-info mb-2" data-bs-toggle="offcanvas" href="#createsubtaskcanvas"><i class="ri-filter-3-line align-bottom me-1"></i> Subtasks</button>
                        <div class="card">
                            <div class="card-body">
                                <div class="text-muted">
                                    <h6 class="mb-3 fw-semibold text-uppercase d-inline">Summary</h6>
                                    <a href="javascript:;" class="d-inline ms-2" @click="showUpdateSummary"><i class="ri-edit-box-line"></i></a>
                                    <div v-html="task.original_description"></div>
                                </div>
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
        <create-subtask>
            <template #content>
                <div class="offcanvas-body">
                    <div class="p-3 bg-light rounded mb-4" v-if="task.expired_due_date !== false">
                        <div class="row g-2">
                            <div class="col-lg-12">
                                <form @submit.prevent="createSubTask">
                                    <div class="row">
                                        <div class="col-md-6 col-xl-6">
                                            <text-input v-model="create_subtask.name" :error="create_subtask.errors.name" class="mt-3" label="Subtask Title" placeholder="Enter Subtask" type="text" autofocus autocapitalize="off" />
                                        </div>
                                        <div class="col-md-6 col-xl-6">
                                            <text-input v-model="create_subtask.due_date_time" data-provider="flatpickr" data-date-format="Y-m-d" :data-minDate="task.original_start_date_time" :data-maxDate="task.original_due_date_time" :error="create_subtask.errors.due_date_time" class="mt-3 flatpickr-date" label="Due Date" placeholder="Select Due Date" type="text" autofocus autocapitalize="off" />
                                        </div>
                                    </div>
                                    <button class="btn btn-primary createTask mt-2" type="submit">
                                        <i class="ri-add-fill align-bottom"></i> Create
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="todo-content position-relative px-4 mx-n4" id="todo-content">
                        <div class="todo-task" id="todo-task">
                            <div class="table-responsive"  v-if="task.subtasks.length > 0">
                                <table class="table align-middle position-relative">
                                    <thead class="table-active">
                                        <tr>
                                            <th scope="col">Task No</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Due Date</th>
                                            <th scope="col">Priority</th>
                                            <th scope="col">Is Completed</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody id="task-list">
                                        <tr v-for="subtask in task.subtasks">
                                            <td>#{{ subtask.task_no }}</td>
                                            <td>{{ subtask.name }}</td>
                                            <td>{{ subtask.formatted_due_date }}</td>
                                            <td><span class="badge text-uppercase" :class="subtask.priority == 'High' ? 'bg-danger' : 'bg-success'">{{ subtask.priority }}</span></td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" @change="updateSubtaskStatus($event)" :data-id="subtask.id" role="switch" :id="subtask.id" :checked="subtask.is_completed == 1">
                                                    <label class="form-check-label" for="subtask.id"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="subtask-edit me-2">
                                                    <a href="javascript:;" class="link-success fs-18" @click="showEditSubtaskModal($event)" :data-id="subtask.id" :data-name="subtask.name" :data-due_date_time="subtask.original_due_date_time" :data-task_no="subtask.task_no"><i :data-id="subtask.id" :data-name="subtask.name" :data-due_date_time="subtask.original_due_date_time" :data-task_no="subtask.task_no" class="ri-edit-box-line"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end offcanvas-body-->
            </template>
        </create-subtask>
        <!--end offcanvas-->
        <Footer />

        <!-- Upload New Resource Modal -->
        <create-resource :title="'Upload new resource in ' + task.task_no">
            <template #content>
                <form @submit.prevent="uploadResource">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-3">
                            <file-pond
                            v-model="resource.myFiles" 
                            ref="pond"
                            class-name="my-pond"
                            max-files="1"
                            max-file-size="50MB"
                            label-max-file-size-exceeded="File is too large"
                            label-max-file-size="Maximum file size is {filesize}"
                            label-idle="Drop file here... You can upload upto 1 file at a time"
                            :accepted-file-types="accepted_file_types"
                            :files="resource.myFiles"
                             />
                        </div>
                        <div class="col-xl-12 col-md-12">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block" :disabled="resource.processing">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </template>
        </create-resource>
        <!-- Update Task Summary Modal -->
        <update-summary-modal :title="'Update Summary For ' + task.task_no">
            <template #content>
                <form @submit.prevent="updateSummary">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-3">
                            <div class="mb-3">
                                <label class="form-label">Description:</label>
                                <ckeditor :editor="editor" v-model="update_summary.description" :config="editorConfig"></ckeditor>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block" :disabled="resource.processing">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </template>
        </update-summary-modal>

        <edit-subtask-modal :title="'Edit Task'">
            <template #content>
                <form @submit.prevent="updateSubTask">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-3">
                            <text-input v-model="update_subtask.name" :error="update_subtask.errors.name" class="mt-3" label="Title" placeholder="Enter Subtask Title" type="text" autofocus autocapitalize="off" />
                        </div>
                        <div class="col-xl-12 col-md-12 mb-3">
                            <text-input v-model="update_subtask.due_date_time" data-provider="flatpickr" data-date-format="Y-m-d" :data-minDate="task.original_start_date_time" :data-maxDate="task.original_due_date_time" :error="update_subtask.errors.due_date_time" class="mt-10 flatpickr-date" label="Due Date" placeholder="Select Due Date" type="text" autofocus autocapitalize="off" />
                        </div>
                        <div class="col-xl-12 col-md-12">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block" :disabled="update_subtask.processing">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </template>
        </edit-subtask-modal>
    </div>
        <!-- end main content-->
</template>

<script>
	import Layout from '@/Shared/Layout'
	import Footer from '@/Shared/Footer'
    import TextInput from '@/Shared/TextInput'
    import SelectInput from '@/Shared/SelectInput'
    import SelectMultiple from '@/Shared/SelectMultiple'
    import CreateResource from '@/Pages/Prod/Task/Partials/CreateResource'
    import UpdateSummaryModal from '@/Pages/Prod/Task/Partials/UpdateSummaryModal'
    import CreateSubtask from '@/Partials/CreateSubtask'
    import EditSubtaskModal from '@/Partials/EditSubtask'

    import vueFilePond from 'vue-filepond'
    import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
    import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size'
    import 'filepond/dist/filepond.min.css'
    import { useForm } from '@inertiajs/inertia-vue3'

    // Create FilePond component
    const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginFileValidateSize);

    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

	export default {
		components: {
			Footer,
            TextInput,
            SelectInput,
            SelectMultiple,
            CreateResource,
            UpdateSummaryModal,
            CreateSubtask,
            EditSubtaskModal,
            FilePond
		},
		layout: Layout,
		props: {
			task: Object,
			stages: Object,
			members: Object
		},
		data() {
			return {
		    	resource: this.$inertia.form({
                    myFiles: []
                }),
                update_summary: this.$inertia.form({
                    description: this.task.original_description
                }),
                create_subtask: this.$inertia.form({
		    		name: '',
		    		description: '',
		    		start_date_time: this.task.original_start_date_time,
		    		due_date_time: '',
		    		task_stage_id: this.task.task_stage_id,
                    client_id: this.task.client_id,
                    timezone_id: this.task.timezone_id,
                    parent_id: this.task.id
		    	}),
                update_subtask: this.$inertia.form({
                    id: '',
                    name: '',
                    due_date_time: ''
                }),
				stage_id: this.task.task_stage_id,
                editor: ClassicEditor,
                accepted_file_types: this.accepted_file_types_global,
                file_size_error_flag: false,
                file_type_error_flag: false,

			}
		},
		methods: {
        	showCreateResource() {
                bootstrap.Modal.getOrCreateInstance('#createresourcemodal').show();
            },
            hideCreateResource() {
                bootstrap.Modal.getOrCreateInstance('#createresourcemodal').hide();
            },
            showUpdateSummary() {
                bootstrap.Modal.getOrCreateInstance('#updatesummarymodal').show();
            },
            hideUpdateSummary() {
                bootstrap.Modal.getOrCreateInstance('#updatesummarymodal').hide();
            },
            showEditSubtaskModal(event) {
                this.update_subtask.id = event.target.getAttribute('data-id');
                this.update_subtask.name = event.target.getAttribute('data-name');
                this.update_subtask.due_date_time = event.target.getAttribute('data-due_date_time');
                bootstrap.Modal.getOrCreateInstance('#editsubtaskmodal').show();
            },
            hideEditSubtaskModal() {
                bootstrap.Modal.getOrCreateInstance('#editsubtaskmodal').hide();
            },
			updateStatus(e) {
				this.stage_id = e.target.value;
				axios.post(route('prod.tasks.update.status', { slug: this.currentWebsite.slug, id: this.task.id }), { stage_id: this.stage_id }).then((response) => {
                    console.log(response.data);
                });
			},
        	uploadResource() {
                this.resource.myFiles = [];
                this.file_size_error_flag = false;
                this.file_type_error_flag = false;
                this.$refs.pond.getFiles().forEach((value, index) => {
                    if(value.file.size > this.max_file_size){
                        this.file_size_error_flag = true;
                    }
                    if(!this.accepted_file_types_array.includes(value.file.type)){
                        this.file_type_error_flag = true;
                    }
                    this.resource.myFiles.push(value.file);
                });
                if(this.file_size_error_flag){
                    alert('File size exceeded');
                    return false;
                }
                if(this.file_type_error_flag){
                    alert('File type not supported');
                    return false;
                }
                this.resource.post(route('prod.tasks.upload.media', { slug: this.currentWebsite.slug, id: this.task.id }),{
                    preserveScroll: true,
                    onSuccess: () => {
                        this.resource.myFiles = [];
                        this.resource.reset();
                    },
                })
            },
            updateSummary() {
                this.update_summary.post(route('prod.tasks.update.summary', { slug: this.currentWebsite.slug, id: this.task.id }),{
                    preserveScroll: true,
                    onSuccess: () => {
                        this.hideUpdateSummary();
                    }
                })
            },
            createSubTask() {
                this.create_subtask.post(route('prod.subtasks.store', { slug: this.currentWebsite.slug }),{
                    preserveState: true,
                    preserveScroll: true,
                    onSuccess: () => {
                        this.create_subtask.reset();
                    }
                })
            },
            updateSubTask() {
                this.update_subtask.post(route('prod.subtasks.update', { slug: this.currentWebsite.slug, id: this.update_subtask.id }),{
                    preserveState: true,
                    preserveScroll: true,
                    onSuccess: () => {
                        this.hideEditSubtaskModal();
                        this.update_subtask.reset();
                    }
                })
            },
            updateSubtaskStatus(event) {
                let subtask_id = event.target.getAttribute('data-id');
                let is_completed = event.target.checked == true ? 1 : 0;
                axios.post(route('prod.subtasks.status.update', { slug: this.currentWebsite.slug, id: subtask_id }), {is_completed: is_completed }).then((response) => {
                    console.log(response.data.success);
                });
            }, 
		},
		computed: {
            currentWebsite() {
                return this.$page.props.currentWebsite.details
            },
            user() {
	            return this.$page.props.auth.user
	        },
        },
        created() {
            this.injectScripts(this.asset("public/assets/js/app.js"));
        }
	}
</script>