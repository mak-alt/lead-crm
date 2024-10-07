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
                                    <a href="javascript:;" class="d-inline ms-2" @click="showUpdateDates"><i class="ri-edit-box-line"></i></a>
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
                                        <div class="flex-shrink-0">
                                            <button type="button" class="btn btn-soft-danger btn-sm" @click="showAddMemberModal"><i class="ri-share-line me-1 align-bottom"></i> Assign Member</button>
                                        </div>
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
                                                <div class="flex-shrink-0">
                                                   <div class="dropdown">
                                                      <button class="btn btn-icon btn-sm fs-16 text-muted dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                      <i class="ri-more-fill"></i>
                                                      </button>
                                                      <ul class="dropdown-menu" style="">
                                                         <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-delete-bin-5-fill text-muted me-2 align-bottom"></i>Remove</a></li>
                                                      </ul>
                                                   </div>
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
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-muted">
                                        <h6 class="mb-3 fw-semibold text-uppercase d-inline">Summary</h6>
                                        <a href="javascript:;" class="d-inline ms-2" @click="showUpdateSummary"><i class="ri-edit-box-line"></i></a>
                                        <div v-html="task.original_description"></div>
                                    </div>
                                </div>
                            </div>
                            <!--end card-->
                            <div class="card">
                                <div class="card-header">
                                    <div>
                                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#home-1" role="tab">
                                                    Comments ({{ task.task_discussions_count }})
                                                </a>
                                            </li>
                                        </ul>
                                        <!--end nav-->
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="home-1" role="tabpanel">
                                            <div style="height: 300px;" class="d-flex align-items-center justify-content-center text-center px-3 mx-n3 mb-2" v-if="loading_discussions">
                                            		<h5>Loading Discussions....</h5>
                                        	</div>
                                            <discussion :discussions="discussions"></discussion>
                                            <discussion-form :task="task" @taskdiscussionevent="addDiscussion"></discussion-form>
                                        </div>

                                    </div>
                                    <!--end tab-content-->
                                </div>
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->

                    <!-- Add Members Modal -->
		            <add-member-modal :title="'Assign members to ' + task.task_no">
		            	<template #content>
			                <form @submit.prevent="addMember">
			                    <div class="row">
			                        <select-multiple class="mb-3" label="Members" v-model="add_member.members">
			                            <template>
			                                <optgroup label="Production">
			                                    <option :value="member.id" v-for="member in members" :key="member.id">{{ member.name }} ({{ member.email }})</option>
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
                    <!-- end modal -->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

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
            <!-- Update Task Dates Modal -->
            <update-dates-modal :title="'Set Dates For ' + task.task_no">
                <template #content>
                    <form @submit.prevent="updateDates">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 mb-3">
                                <text-input v-model="update_dates.start_date_time" data-provider="flatpickr" data-date-format="Y-m-d" data-enable-time :error="update_dates.errors.start_date_time" class="mt-10 flatpickr-date" label="Start Date Time" placeholder="Select Start Date & Time" type="text" autofocus autocapitalize="off" />
                            </div>
                            <div class="col-xl-12 col-md-12 mb-3">
                                <text-input v-model="update_dates.due_date_time" data-provider="flatpickr" data-date-format="Y-m-d" data-enable-time :error="update_dates.errors.due_date_time" class="mt-10 flatpickr-date" label="Due Date Time" placeholder="Select Due Date & Time" type="text" autofocus autocapitalize="off" />
                            </div>
                            <div class="col-xl-12 col-md-12">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-block" :disabled="resource.processing">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </template>
            </update-dates-modal>   
        </div>
        <!-- end main content-->
</template>

<script>
	import Layout from '@/Shared/Layout'
	import Footer from '@/Shared/Footer'
    import TextInput from '@/Shared/TextInput'
    import SelectInput from '@/Shared/SelectInput'
    import SelectMultiple from '@/Shared/SelectMultiple'
    import AddMemberModal from '@/Pages/Admin/Task/Partials/AddMemberModal'
    import CreateResource from '@/Pages/Admin/Task/Partials/CreateResource'
    import Discussion from '@/Pages/Admin/Task/Partials/Discussion'
	import DiscussionForm from '@/Pages/Admin/Task/Partials/DiscussionForm'
    import UpdateSummaryModal from '@/Pages/Admin/Task/Partials/UpdateSummaryModal'
    import UpdateDatesModal from '@/Pages/Admin/Task/Partials/UpdateDatesModal'

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
            AddMemberModal,
            CreateResource,
            Discussion,
			DiscussionForm,
            UpdateSummaryModal,
            UpdateDatesModal,
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
				add_member: this.$inertia.form({
		    		members:[]
		    	}),
		    	resource: this.$inertia.form({
                    myFiles: []
                }),
                update_summary: this.$inertia.form({
                    description: this.task.original_description
                }),
                update_dates: this.$inertia.form({
                    start_date_time: this.task.original_start_date_time,
                    due_date_time: this.task.original_due_date_time
                }),
				stage_id: this.task.task_stage_id,
				discussions: [],
				loading_discussions: true,
                editor: ClassicEditor,
                accepted_file_types: this.accepted_file_types_global,
                file_size_error_flag: false,
                file_type_error_flag: false,
			}
		},
		methods: {
			showAddMemberModal() {
        		bootstrap.Modal.getOrCreateInstance('#addmembermodal').show();
        	},
        	hideAddMemberModal() {
        		bootstrap.Modal.getOrCreateInstance('#addmembermodal').hide();
        	},
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
            showUpdateDates() {
                bootstrap.Modal.getOrCreateInstance('#updatedatesmodal').show();
            },
            hideUpdateDates() {
                bootstrap.Modal.getOrCreateInstance('#updatedatesmodal').hide();
            },
			updateStatus(e) {
				this.stage_id = e.target.value;
				axios.post(route('admin.tasks.update.status', { slug: this.currentWebsite.slug, id: this.task.id }), { stage_id: this.stage_id }).then((response) => {
                    console.log(response.data);
                });
			},
			addMember() {
        		this.add_member.post(route('admin.tasks.add.members', { slug: this.currentWebsite.slug, id: this.task.id }),{
        			preserveScroll: true,
        			preserveState: true,
        			onSuccess: () => {
        				this.add_member.reset('members');
        				this.hideAddMemberModal();
        			}
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
                this.resource.post(route('admin.tasks.upload.media', { slug: this.currentWebsite.slug, id: this.task.id }),{
                    preserveScroll: true,
                    onSuccess: () => {
                        this.resource.myFiles = [];
                        this.resource.reset();
                    },
                })
            },
            updateSummary() {
                this.update_summary.post(route('admin.tasks.update.summary', { slug: this.currentWebsite.slug, id: this.task.id }),{
                    preserveScroll: true,
                    onSuccess: () => {
                        this.hideUpdateSummary();
                    }
                })
            },
            updateDates() {
                this.update_dates.post(route('admin.tasks.update.dates', { slug: this.currentWebsite.slug, id: this.task.id }),{
                    preserveScroll: true,
                    onSuccess: () => {
                        this.hideUpdateDates();
                    }
                })
            },
            getDiscussions() {
				axios.get(route('admin.tasks.discussions', { slug: this.currentWebsite.slug }), { params: { task_id: this.task.id } }).then((response) => {
                    this.loading_discussions = false;
					response.data.forEach((value, index) => {
						this.discussions.push(value);
					})
				});
			},
			addDiscussion(comment) {
				axios.post(route('admin.tasks.discussions.store', { slug: this.currentWebsite.slug }), { task_id: this.task.id, comment: comment.comment }).then((response) => {
                    this.discussions.push(response.data);
                });
                setTimeout(() => this.scrollToBottom(), 1000);
			},
            scrollToBottom() {
                var container = document.querySelector('.discussionContainer .simplebar-content-wrapper'); 
                container.scrollTo({ top: container.scrollHeight, behavior: "smooth" });
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
        	this.getDiscussions();
            
        	Echo.private('task-discussion.'+this.task.id)
			  	.listen('TaskDiscussionEvent', (e) => {
    			    this.discussions.push(e.discussion);
                    document.getElementById('ChatAudio').play();
                    setTimeout(() => this.scrollToBottom(), 1000);
			    });

            setTimeout(() => this.scrollToBottom(), 1000);

            this.injectScripts(this.asset("public/assets/js/app.js"));
        }
	}
</script>