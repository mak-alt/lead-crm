<template>
    <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">{{ team.team_no }} {{ team.name }}</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Teams</a></li>
                                        <li class="breadcrumb-item active">{{ team.team_no }}</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="card">
                        <div class="card-body">
                            <div class="row g-2">
                                <!--end col-->
                                <div class="col-lg-3 col-auto">
                                    <div class="search-box">
                                        <input type="text" class="form-control search" id="search-task-options" placeholder="Search for project, tasks...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                                <div class="col-auto ms-sm-auto">
                                    <div class="avatar-group" id="newMembar">
                                        <a v-for="member in team.members" :key="member.id" href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" :title="member.name">
                                            <img :src="member.profile_image" alt="" class="rounded-circle avatar-xs">
                                        </a>
                                        <a href="javascript:;" class="avatar-group-item" @click="showAddMemberModal">
                                            <div class="avatar-xs">
                                                <div class="avatar-title rounded-circle">
                                                    +
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->

                    <div class="tasks-board mb-3" id="kanbanboard">
                        <div class="tasks-list" v-for="stage in stages" :key="stage.id">
                            <div class="d-flex mb-3">
                                <div class="flex-grow-1">
                                    <h6 class="fs-14 text-uppercase fw-semibold mb-0"> {{ stage.name }} <small class="badge bg-success align-bottom ms-1 totaltask-badge">{{ stage.tasks_count }}</small></h6>
                                </div>
                            </div>
                            <div data-simplebar class="tasks-wrapper px-3 mx-n3">
                                <div :id="stage.slug + '-task'" class="tasks">
                                    <div class="card tasks-box" v-for="task in stage.tasks" :key="task.id">
                                        <div class="card-body">
                                            <div class="d-flex mb-2">
 												<h6 class="fs-15 mb-0 flex-grow-1 text-truncate task-title"><Link :href="route('admin.tasks.show', { slug: currentWebsite.slug, id: task.id, team_id: team.id })" class="d-block">{{ task.name }}</Link></h6>
                                            </div>
                                            <p class="text-muted" v-html="task.description"></p>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <span class="badge badge-soft-primary">{{ task.user.name }}</span>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <div class="avatar-group">
                                                        <a v-for="member in task.members" href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" :title="member.name">
                                                            <img :src="member.profile_image" alt="" class="rounded-circle avatar-xxs">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer border-top-dashed">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <h6 class="text-muted mb-0">#{{ task.task_no }}</h6>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <ul class="link-inline mb-0">
                                                        <li class="list-inline-item">
                                                            <a href="javascript:void(0)" class="text-muted"><i class="ri-question-answer-line align-bottom"></i> {{ task.task_discussions_count }}</a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="javascript:void(0)" class="text-muted"><i class="ri-attachment-2 align-bottom"></i> {{ task.media_count }}</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end card-body-->
                                    </div>
                                    <!--end card-->
                                </div>
                                <!--end tasks-->
                            </div>
                            <div class="my-3">
                                <button type="button" class="btn btn-soft-info w-100" @click="showCreateTaskModal($event)" :data-stage-id="stage.id">Add More</button>
                            </div>
                        </div>
                        <div class="tasks-list">
	                        <div class="d-flex mb-3">
                                <div class="flex-grow-1">
                                    <button type="button" class="btn btn-soft-info w-100" @click="showCreateStageModal">Create New Stage</button>
                                </div>
                            </div>
	                    </div>
                        <!--end tasks-list-->
                    </div>
                    <!--end task-board-->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <Footer/>

            <!-- Add Members Modal -->
            <add-member-modal :title="'Add members in ' + team.name">
            	<template #content>
	                <form @submit.prevent="addMember">
	                    <div class="row">
	                        <select-multiple class="mb-3" label="Members" v-model="add_member.members">
	                            <template>
	                                <optgroup label="Production">
	                                    <option :value="member.id" v-for="member in members" :key="member.id">{{ member.name }}</option>
	                                </optgroup>
	                            </template>
	                        </select-multiple>
	                        <div class="col-xl-12 col-md-12">
	                            <div class="d-grid">
	                                <button type="submit" class="btn btn-primary btn-block" :disabled="add_member.processing">Submit</button>
	                            </div>
	                        </div>
	                    </div>
	                </form>
	            </template>
            </add-member-modal>

            <!-- Create New Task Modal -->
            <create-task-modal :title="'Create New Task in ' + team.name">
            	<template #content>
	                <form @submit.prevent="createTask">
	                    <div class="row">
                            <div class="col-xl-12 col-md-12 mb-3">
                                <select-input v-model="create_task.client_id" :required="true" :error="create_task.errors.client_id" class="mt-10" label="Select Client" autofocus autocapitalize="off">
                                    <option value="">Select Client</option>
                                    <option v-for="client in clients" :key="client.id" :value="client.id">{{ client.user_no }} {{ client.name }}</option>
                                </select-input>
                            </div>
	                        <div class="col-xl-12 col-md-12">
	                        	<text-input v-model="create_task.name" :error="create_task.errors.name" :required="true" class="mb-3" label="Title" placeholder="Enter Task Title" type="text" autofocus autocapitalize="off" />
	                        </div>
	                        <div class="col-xl-12 col-md-12">
	                        	<div class="mb-3">
							        <label class="form-label">Description:</label>
	                        		<ckeditor :editor="editor" v-model="create_task.description" :config="editorConfig"></ckeditor>
		                        </div>
	                        </div>
	                        <div class="col-xl-4 col-md-4 mb-3">
                                <text-input v-model="create_task.start_date_time" data-provider="flatpickr" data-date-format="Y-m-d" data-enable-time :error="create_task.errors.start_date_time" class="mt-10 flatpickr-date" label="Start Date Time" placeholder="Select Start Date & Time" type="text" autofocus autocapitalize="off" />
                            </div>
                            <div class="col-xl-4 col-md-4 mb-3">
                                <text-input v-model="create_task.due_date_time" data-provider="flatpickr" data-date-format="Y-m-d" data-enable-time :error="create_task.errors.due_date_time" class="mt-10 flatpickr-date" label="Due Date Time" placeholder="Select Due Date & Time" type="text" autofocus autocapitalize="off" />
                            </div>
                            <div class="col-xl-4 col-md-4 mb-3">
                                <select-input v-model="create_task.timezone_id" :error="create_task.errors.timezone_id" class="mt-10" label="Timezone" autofocus autocapitalize="off">
                                    <option v-for="timezone in timezones" :key="timezone.id" :value="timezone.id">{{ timezone.timezone }}</option>
                                </select-input>
                            </div>
                            <div class="col-xl-12 col-md-12">
	                        	<select-multiple class="mb-3" label="Members" v-model="create_task.members">
		                            <template>
		                                <optgroup label="Production">
		                                    <option :value="member.id" v-for="member in team.members" :key="member.id">{{ member.name }} ( {{ member.email }} )</option>
		                                </optgroup>
		                            </template>
		                        </select-multiple>
	                        </div>
	                        <div class="col-xl-12 col-md-12">
                                <file-pond
                                v-model="create_task.myFiles" 
                                ref="pond"
                                class-name="my-pond"
                                allow-multiple="true"
                                max-files="2"
                                max-file-size="50MB"
                                label-max-file-size-exceeded="File is too large"
                                label-max-file-size="Maximum file size is {filesize}"
                                label-idle="Drop files here... You can upload upto 2 files"
                                :accepted-file-types="accepted_file_types"
                                :files="create_task.myFiles"
                                 />
	                        </div>
	                        <div class="col-xl-12 col-md-12">
	                            <div class="hstack gap-2 justify-content-end">
	                                <button type="submit" class="btn btn-primary btn-block" :disabled="create_task.processing">Submit</button>
	                            </div>
	                        </div>
	                    </div>
	                </form>
	            </template>
            </create-task-modal>

            <!-- Create New Stage Modal -->
            <create-stage-modal :title="'Create New Stage in ' + team.name">
            	<template #content>
	                <form @submit.prevent="createStage">
	                    <div class="row">
	                        <div class="col-xl-12 col-md-12">
	                        	<text-input v-model="create_stage.name" :error="create_stage.errors.expected_amount" class="mb-3" label="Stage Name" placeholder="Enter Stage Name" type="text" autofocus autocapitalize="off" />
	                        </div>
	                        <div class="col-xl-12 col-md-12">
	                            <div class="d-grid">
	                                <button type="submit" class="btn btn-primary btn-block" :disabled="create_stage.processing">Submit</button>
	                            </div>
	                        </div>
	                    </div>
	                </form>
	            </template>
            </create-stage-modal>
        </div><!-- end main content-->
</template>

<style scoped>
	.tasks{
		min-height: 0px;
	}
</style>

<script>
    import Layout from '@/Shared/Layout'
    import Footer from '@/Shared/Footer'
    import TextInput from '@/Shared/TextInput'
    import TextareaInput from '@/Shared/TextareaInput'
    import SelectInput from '@/Shared/SelectInput'
    import SelectMultiple from '@/Shared/SelectMultiple'
    import AddMemberModal from '@/Pages/Admin/Team/Members/AddMemberModal'
    import CreateTaskModal from '@/Pages/Admin/Task/Partials/CreateTaskModal'
    import CreateStageModal from '@/Pages/Admin/Task/Partials/CreateStageModal'

    // File Uploading Imports
    
    import vueFilePond from 'vue-filepond'
    import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
    import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size'
    import 'filepond/dist/filepond.min.css'
    import { useForm } from '@inertiajs/inertia-vue3'

    // Create FilePond component
    const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginFileValidateSize);
    //Classic Editor
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    export default {
        components: {
           TextInput,
           TextareaInput,
           SelectInput,
           SelectMultiple,
           AddMemberModal,
           CreateTaskModal,
           CreateStageModal,
           Footer,
           FilePond
        },
        data() {
		    return {
		    	add_member: this.$inertia.form({
		    		members:[]
		    	}),
		    	create_task: this.$inertia.form({
		    		name: '',
		    		description: '',
		    		start_date_time: '',
		    		due_date_time: '',
		    		members: [],
		    		myFiles: [],
		    		task_stage_id:'',
                    client_id: '',
                    timezone_id: 1,
		    	}),
		    	create_stage: this.$inertia.form({
		    		name: '',
		    		team_id: this.team.id,
		    		color: '',
		    	}),
		    	editor: ClassicEditor,
                accepted_file_types: this.accepted_file_types_global,
                file_size_error_flag: false,
                file_type_error_flag: false,
		    }
		},
        layout: Layout,
        props: {
        	team: Object,
        	stages: Object,
        	members: Object,
            clients: Object,
            timezones: Object,
        },
        methods: {
        	showAddMemberModal() {
        		bootstrap.Modal.getOrCreateInstance('#addmembermodal').show();
        	},
        	hideAddMemberModal() {
        		bootstrap.Modal.getOrCreateInstance('#addmembermodal').hide();
        	},
        	showCreateTaskModal(e) {
        		this.create_task.task_stage_id = e.target.getAttribute('data-stage-id');
        		bootstrap.Modal.getOrCreateInstance('#createtaskmodal').show();
        	},
        	hideCreateTaskModal() {
        		bootstrap.Modal.getOrCreateInstance('#createtaskmodal').hide();
        	},
        	showCreateStageModal() {
        		bootstrap.Modal.getOrCreateInstance('#createstagemodal').show();
        	},
        	hideCreateStageModal() {
        		bootstrap.Modal.getOrCreateInstance('#createstagemodal').hide();
        	},
        	addMember() {
        		this.add_member.post(route('admin.teams.add.members', { slug: this.currentWebsite.slug, id: this.team.id }),{
        			preserveScroll: true,
        			onSuccess: () => {
        				this.add_member.reset();
        				this.hideAddMemberModal();
        			}
        		});
        	},
        	createTask() {
        		this.create_task.myFiles = [];
                this.file_size_error_flag = false;
                this.file_type_error_flag = false;
                this.$refs.pond.getFiles().forEach((value, index) => {
                    if(value.file.size > this.max_file_size){
                        this.file_size_error_flag = true;
                    }
                    if(!this.accepted_file_types_array.includes(value.file.type)){
                        this.file_type_error_flag = true;
                    }
                    this.create_task.myFiles.push(value.file);
                });
                if(this.file_size_error_flag){
                    alert('File size exceeded');
                    return false;
                }
                if(this.file_type_error_flag){
                    alert('File type not supported');
                    return false;
                }
        		this.create_task.post(route('admin.tasks.store', { slug: this.currentWebsite.slug }), {
        			preserveScroll: true,
        			onSuccess: () => {
        				this.create_task.myFiles = [];
        				this.create_task.description = '';
        				this.create_task.members = [];
        				this.create_task.reset();
        				this.hideCreateTaskModal();
        			}
        		})
        	},
        	createStage() {
        		this.create_stage.post(route('admin.tasks.stages.store', { slug: this.currentWebsite.slug }), {
        			preserveScroll: true,
        			onSuccess: () => {
        				this.create_stage.reset();
        				this.hideCreateStageModal();
        			}
        		})
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