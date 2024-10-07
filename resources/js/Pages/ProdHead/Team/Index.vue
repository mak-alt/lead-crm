<template>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">TEAMS</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><Link :href="route('prodhead.single.dashboard',{ slug: currentWebsite.slug })">Dashboard</Link></li>
                                    <li class="breadcrumb-item active">Teams</li>
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
                                              <input type="text" autocomplete="off" v-model="filters.team_no" class="form-control search" placeholder="Search..." />
                                              <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                        <div class="col-xl-1">
                                            <button class="btn btn-outline-primary" :disabled="filters.processing" type="submit">Filter</button>
                                        </div>
                                        <div class="col-sm-auto ms-auto">
                                            <div class="hstack gap-2">
                                                <button class="btn btn-soft-danger" type="button" @click="bulkDelete"><i class="ri-delete-bin-2-line"></i></button>
                                                <a href="javascript:;" @click="showCreateModal" class="btn btn-primary" id="create-btn"><i class="ri-add-line align-bottom me-1"></i> Create Team</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div><!-- end row -->
                <div class="row">
                   <div class="col-12">
                      <div class="row row-cols-xxl-5 row-cols-lg-3 row-cols-1">
                         <div class="col" v-for="team in teams.data" :key="team.id">
                            <div class="card card-body">
                               <div class="d-flex mb-4">
                                  <div class="flex-grow-1">
                                     <h5 class="card-title mb-1"><Link :href="route('prodhead.teams.show', { slug: currentWebsite.slug, id: team.id })">{{ team.name }}</Link></h5>
                                     <p class="text-muted mb-0 fs-16"><Link :href="route('prodhead.teams.show', { slug: currentWebsite.slug, id: team.id })">{{ team.team_no }}</Link></p>
                                  </div>
                                  <div class="team-status">
                                    <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                       <input type="checkbox" class="form-check-input" id="customSwitchsizemd">
                                       <label class="form-check-label" for="customSwitchsizemd"></label>
                                    </div>
                                  </div>
                               </div>
                               <div class="d-flex mt-1">
                                    <div class="flex-grow-1">
                                        <div class="avatar-group">
                                            <a v-for="member in team.members" href="javascript: void(0);" class="avatar-group-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" :aria-label="member.name" :title="member.name">
                                                <img :src="member.profile_image" alt="" class="rounded-circle avatar-xxs">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="team-edit me-2">
                                        <a href="javascript:;" class="link-success fs-18" @click="showEditModal($event)" :data-id="team.id" :data-name="team.name"><i class="ri-edit-box-line" :data-id="team.id" :data-name="team.name"></i></a>
                                    </div>
                                </div>
                            </div>
                         </div>
                         <!-- end col -->
                      </div>
                      <!-- end row -->
                   </div>
                   <!-- end col -->
                   <div class="col-12">
                       <pagination class="mt-6" :links="teams.links" />
                   </div>
                </div>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        <Footer />

        <create-modal :website="currentWebsite">
            <template #content>
                <form @submit.prevent="createTeam">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-3">
                            <text-input v-model="form.name" :error="form.errors.name" class="mt-10" label="Team Name" placeholder="Enter Team Name" type="text" autofocus autocapitalize="off" />
                        </div>
                        <select-multiple class="mb-3" label="Members" v-model="form.members">
                            <template>
                                <optgroup label="Production">
                                    <option :value="member.id" v-for="member in members" :key="member.id">{{ member.name }}</option>
                                </optgroup>
                            </template>
                        </select-multiple>
                        <div class="col-xl-12 col-md-12">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block" :disabled="form.processing">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </template>
        </create-modal>

        <edit-modal>
            <template #content>
                <form @submit.prevent="updateTeam">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-3">
                            <text-input v-model="edit.name" :error="edit.errors.name" class="mt-10" label="Team Name" placeholder="Enter Team Name" type="text" autofocus autocapitalize="off" />
                        </div>
                        <div class="col-xl-12 col-md-12">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block" :disabled="form.processing">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </template>
        </edit-modal>

    </div>
</template>

<script>
    import Layout from '@/Shared/Layout'
    import Footer from '@/Shared/Footer'
    import Pagination from '@/Shared/Pagination'
    import TextInput from '@/Shared/TextInput'
    import SelectInput from '@/Shared/SelectInput'
    import SelectMultiple from '@/Shared/SelectMultiple'
    import DeleteModal from '@/Shared/DeleteModal'
    import CreateModal from '@/Pages/ProdHead/Team/Partials/CreateModal'
    import EditModal from '@/Pages/ProdHead/Team/Partials/EditModal'

    export default {
        components: {
           TextInput,
           SelectInput,
           Footer,
           Pagination,
           DeleteModal,
           CreateModal,
           EditModal,
           SelectMultiple
        },
        data() {
		    return {
		      filters: this.$inertia.form({
		        team_no: '',
		      }),
		      delete: this.$inertia.form({

		      }),
		      bulk_delete: this.$inertia.form({
                all_ids: [],
              }),
              form: this.$inertia.form({
                name: '',
                members: []
              }),
              edit: this.$inertia.form({
                name: '',
              }),
		      isCheckAll: false,
		    }
		},
        layout: Layout,
        props: {
        	teams: Object,
            members: Object
        },
        methods: {
        	filter() {
        		this.filters.get(route('prodhead.teams', { slug: this.currentWebsite.slug}),{
        			preserveState: true,
	                preserveScroll: true	
        		})
        	},
        	checkAll(){
                this.bulk_delete.all_ids = [];
                this.isCheckAll = !this.isCheckAll;
                if(this.isCheckAll){
                    this.teams.data.forEach((value, index) => {
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
                    this.bulk_delete.post(route('prodhead.teams.bulk.delete', { slug: this.currentWebsite.slug }));
                }
            },
            showCreateModal() {
                bootstrap.Modal.getOrCreateInstance('#createteammodal').show();
            },
            hideCreateModal() {
                bootstrap.Modal.getOrCreateInstance('#createteammodal').hide();
            },
            showEditModal(e) {
                this.edit.name = e.target.getAttribute('data-name');
                this.edit.id = e.target.getAttribute('data-id');
                bootstrap.Modal.getOrCreateInstance('#editteammodal').show();
            },
            hideEditModal() {
                bootstrap.Modal.getOrCreateInstance('#editteammodal').hide();
            },
            createTeam() {
                this.form.post(route('prodhead.teams.store', { slug: this.currentWebsite.slug }),{
                    preserveScroll: true,
                    onSuccess: () => {
                        this.hideCreateModal(),
                        this.form.reset()
                    }
                })
            },
            updateTeam() {
                this.edit.post(route('prodhead.teams.update', { slug: this.currentWebsite.slug, id: this.edit.id }),{
                    preserveScroll: true,
                    onSuccess: () => {
                        this.hideEditModal(),
                        this.form.reset()
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
            this.injectScripts(this.asset("public/assets/js/app.js"));
        }
    }
</script>