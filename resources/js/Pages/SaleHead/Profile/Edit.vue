<template>
	<div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="position-relative mx-n4 mt-n4">
                    <div class="profile-wid-bg profile-setting-img">
                        <img :src="asset('public/assets/images/profile-bg.jpg')" class="profile-wid-img" alt="">
                        <div class="overlay-content">
                            <div class="text-end p-3">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xxl-3">
                        <div class="card mt-n5">
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                        <user-avatar :profile="user.profile_image" class="avatar-xl img-thumbnail user-profile-image" alt="user-profile-image"/>
                                        <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                            <input id="profile-img-file-input" @change="updateProfileImage($event)" type="file" class="profile-img-file-input">
                                            <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                <span class="avatar-title rounded-circle bg-light text-body">
                                                    <i class="ri-camera-fill"></i>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <h5 class="fs-16 mb-1">{{ user.name }}</h5>
                                    <p class="text-muted mb-0">{{ user.email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card" v-if="user.websites.length > 0">
						   <div class="card-body">
						      <h5 class="card-title mb-4">Websites</h5>
						      <div class="d-flex flex-wrap gap-2 fs-15">
						         <a href="javascript:;" class="badge badge-soft-primary" v-for="website in user.websites">{{ website.name }}</a>
						      </div>
						   </div>
						   <!-- end card body -->
						</div>
                        <!--end card-->
                        <div class="card" v-if="user.websites.length > 0">
                           <div class="card-body">
                              <h5 class="card-title mb-4">Roles</h5>
                              <div class="d-flex flex-wrap gap-2 fs-15">
                                 <p class="badge badge-soft-primary" v-for="role in user.roles">{{ role.name }}</p>
                              </div>
                           </div>
                           <!-- end card body -->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                    <div class="col-xxl-9">
                        <div class="card mt-xxl-n5">
                            <div class="card-header">
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                            <i class="fas fa-home"></i> Personal Details
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                            <i class="far fa-user"></i> Change Password
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body p-4">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                        <form @submit.prevent="updateProfile">
                                            <div class="row">
                                            	<div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <text-input v-model="form.name" :error="form.errors.name" class="mt-10" label="Full Name" placeholder="Enter Full Name" readonly type="text" autofocus autocapitalize="off" />
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <text-input v-model="form.email" :error="form.errors.email" class="mt-10" label="Email" placeholder="Enter Email Address" readonly type="email" autofocus autocapitalize="off" />
                                                    </div>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </form>
                                    </div>
                                    <!--end tab-pane-->
                                    <div class="tab-pane" id="changePassword" role="tabpanel">
                                        <form @submit.prevent="updatePassword">
                                            <div class="row g-2">
                                                <div class="col-lg-4">
                                                    <div>
                                                        <text-input v-model="password.old" :error="password.errors.old" class="mt-10" label="Old Password*" placeholder="Enter Old Password" type="password" autofocus autocapitalize="off" />
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4">
                                                    <div>
                                                        <text-input v-model="password.new" :error="password.errors.new" class="mt-10" label="New Password*" placeholder="Enter New Password" type="password" autofocus autocapitalize="off" />
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4">
                                                    <div>
                                                        <text-input v-model="password.confirm" :error="password.errors.confirm" class="mt-10" label="Confirm Password*" placeholder="Confirm Password" type="password" autofocus autocapitalize="off" />
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <a href="javascript:void(0);" class="link-primary text-decoration-underline">Forgot Password ?</a>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-12">
                                                    <div class="text-end">
                                                        <button type="submit" class="btn btn-success" :disabled="password.processing">Change Password</button>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->

            </div>
            <!-- container-fluid -->
        </div><!-- End Page-content -->
        <Footer/>
    </div>
    <!-- end main content-->
</template>

<script>
	
	import Layout from '@/Shared/Layout'
	import Footer from '@/Shared/Footer'
	import TextInput from '@/Shared/TextInput'
    import UserAvatar from '@/Shared/UserAvatar'

	export default {
		components:{
			Footer,
			TextInput,
            UserAvatar
		},
		props: {
			user: Object,
		},
		layout: Layout,

		data() {
			return {
				form: this.$inertia.form({
					name: this.user.name,
					email: this.user.email
				}),
				password: this.$inertia.form({
					old: null,
					new: null,
					confirm: null
				}),
			}
		},
		methods: {
			updatePassword() {
                this.password.post(route('saleshead.profile.update.password', { id: this.user.id }),{
                    preserveScroll: true,
                    onSuccess: () => this.password.reset(),
                });
			},
			updateProfileImage(event){
				var formData = new FormData();
				const file = event.target.files[0];
				this.user.profile_image = URL.createObjectURL(file);
				formData.append("profile", file);
				axios.post(route('saleshead.profile.update.image', { id: this.user.id }), formData, {
				    headers: {
				      'Content-Type': 'multipart/form-data'
				    }
				}).then((response) => {
					console.log(response);
				})
			}
		}
	}

</script>