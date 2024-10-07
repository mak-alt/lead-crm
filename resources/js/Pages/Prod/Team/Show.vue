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
 												<h6 class="fs-15 mb-0 flex-grow-1 text-truncate task-title"><Link :href="route('prod.tasks.show', { slug: currentWebsite.slug, id: task.id, team_id: team.id })" class="d-block">{{ task.name }}</Link></h6>
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
                        </div>
                    </div>
                    <!--end task-board-->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <Footer/>
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

    export default {
        components: {
           TextInput,
           TextareaInput,
           SelectInput,
           SelectMultiple,
           Footer,
        },
        data() {
		    return {
		    }
		},
        layout: Layout,
        props: {
        	team: Object,
        	stages: Object,
        	members: Object,
        },
        methods: {
        	
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