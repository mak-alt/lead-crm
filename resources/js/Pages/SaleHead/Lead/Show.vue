<template>
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mt-n4 mx-n4">
                            <div class="bg-soft-warning">
                                <div class="card-body pb-0 px-4">
                                    <div class="row mb-3">
                                        <div class="col-md">
                                            <div class="row align-items-center g-3">
                                                <div class="col-md">
                                                    <div>
                                                        <h4 class="fw-bold">{{ lead.lead_no }}</h4>
                                                        <div class="hstack gap-3">
                                                            <div>
                                                                <span class="fw-medium">Start Date Time({{ lead.timezone.timezone }})</span><br> 
                                                                <span class="fs-14 badge bg-primary">{{ lead.start_date_time ?? '-' }}</span>
                                                            </div>
                                                            <div class="vr"></div>
                                                            <div>
                                                                <span class="fw-medium">Due Date Time({{ lead.timezone.timezone }})</span><br> 
                                                                <span class="fs-14 badge bg-danger">{{ lead.due_date_time ?? '-' }}</span>
                                                            </div>
                                                            <div class="vr"></div>
                                                            <div>
                                                                <span class="fw-medium">Start Date Time(Local)</span><br> 
                                                                <span class="fs-14 badge bg-primary">{{ lead.start_date_time_local }}</span>
                                                            </div>
                                                            <div class="vr"></div>
                                                            <div>
                                                                <span class="fw-medium">Due Date Time(Local)</span><br> 
                                                                <span class="fs-14 badge bg-danger">{{ lead.due_date_time_local }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <ul class="nav nav-tabs-custom border-bottom-0" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active fw-semibold" data-bs-toggle="tab" href="#project-overview" role="tab">
                                                Overview
                                            </a>
                                        </li>
                                        <li class="nav-item" v-if="lead.expected_amount > 0">
                                            <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#project-payments" role="tab">
                                                Payments
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- end card body -->
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-xl-9 col-lg-8">
                        <div class="tab-content text-muted">
                            <div class="tab-pane fade show active" id="project-overview" role="tabpanel">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="text-muted">
                                                    <h6 class="mb-3 fw-semibold text-uppercase">Summary</h6>
                                                    <p>{{ lead.description }}</p>

                                                    <div class="pt-3 border-top border-top-dashed mt-4">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-sm-6" v-if="lead.subject">
                                                                <div>
                                                                    <p class="mb-2 text-uppercase fw-medium">Subject :</p>
                                                                    <div class="badge bg-primary fs-12">{{ lead.subject }}</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-6" v-if="lead.type">
                                                                <div>
                                                                    <p class="mb-2 text-uppercase fw-medium">Type :</p>
                                                                    <div class="badge bg-success fs-12">{{ lead.type }}</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-6">
                                                                <div>
                                                                    <p class="mb-2 text-uppercase fw-medium">Priority :</p>
                                                                    <div class="badge bg-danger fs-12">{{ lead.priority }}</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-6">
                                                                <div>
                                                                    <p class="mb-2 text-uppercase fw-medium">Status :</p>
                                                                    <div class="badge bg-warning fs-12">{{ lead.stage ? lead.stage.name : 'New  ' }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pt-3 border-top border-top-dashed mt-4">
                                                        <h6 class="mb-3 fw-semibold text-uppercase">Resources</h6>
                                                        <div class="row g-3" v-if="lead.media.length > 0">
                                                            <div class="col-xxl-4 col-lg-6" v-for="media in lead.media" :key="media.id">
                                                                <div class="border rounded border-dashed p-2">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-shrink-0 me-3">
                                                                            <div class="avatar-sm">
                                                                                <div class="avatar-title bg-light text-secondary rounded fs-24">
                                                                                    <i class="ri-folder-zip-line"></i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="flex-grow-1 overflow-hidden">
                                                                            <h5 class="fs-13 mb-1"><a target="_blank" :href="media.original_url" class="text-body text-truncate d-block">{{ media.file_name }}</a></h5>
                                                                            <div>{{ media.human_readable_size }}</div>
                                                                        </div>
                                                                        <div class="flex-shrink-0 ms-2">
                                                                            <div class="d-flex gap-1">
                                                                                <a :href="media.original_url" as="button" class="btn btn-icon text-muted btn-sm fs-18"><i class="ri-download-2-line"></i></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                             <div class="col-xxl-4 col-lg-6">
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
                                                                            <h5 class="fs-13 fw-bold mb-1"><a href="javascript:;" @click="showCreateResource" class="text-body text-truncate d-block">Upload Resource</a></h5>
                                                                        </div>
                                                                        <div class="flex-shrink-0 ms-2">
                                                                            <div class="d-flex gap-1">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- end col -->
                                                        </div>
                                                        <div class="row g-3" v-else>
                                                            <div class="col-xxl-4 col-lg-6">
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
                                                                            <h5 class="fs-13  fw-bold mb-1"><a href="javascript:;" @click="showCreateResource" class="text-body text-truncate d-block">Upload Resource</a></h5>
                                                                        </div>
                                                                        <div class="flex-shrink-0 ms-2">
                                                                            <div class="d-flex gap-1">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- end col -->
                                                        </div>
                                                        <!-- end row -->
                                                    </div>
                                                    <div class="pt-3 border-top border-top-dashed mt-4">
                                                        <h6 class="mb-3 fw-semibold text-uppercase">Payments</h6>
                                                        <div class="row" v-if="lead.expected_amount > 0">
                                                            <div class="col-lg-3 col-sm-6">
                                                                <div>
                                                                    <p class="mb-2 text-uppercase fw-medium">Total Payment :</p>
                                                                    <h5 class="badge bg-primary fs-15 mb-0">{{ currency + ' ' + lead.expected_amount }}</h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-6">
                                                                <div>
                                                                    <p class="mb-2 text-uppercase fw-medium">Paid :</p>
                                                                    <h5 class="badge bg-success fs-15 mb-0">{{ currency + ' ' + lead.paid }}</h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-6">
                                                                <div>
                                                                    <p class="mb-2 text-uppercase fw-medium">Refund :</p>
                                                                    <div class="badge bg-danger fs-15 mb-0">{{ currency + ' ' + lead.refund }}</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-6">
                                                                <div>
                                                                    <p class="mb-2 text-uppercase fw-medium">Remaining :</p>
                                                                    <div class="badge bg-warning fs-15 mb-0">{{ currency + ' ' + lead.remaining }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row" v-else>
                                                            <div class="col-lg-3 col-sm-6">
                                                                <button class="btn btn-outline-primary" type="button" @click="showExpectedPayment">
                                                                    Add Expected Payment
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <!-- end row -->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end card body -->
                                        </div>
                                        <!-- end card -->

                                        <div class="card">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Discussions</h4>
                                            </div><!-- end card header -->

                                            <div class="card-body">
                                                <div style="height: 300px;" class="d-flex align-items-center justify-content-center text-center px-3 mx-n3 mb-2" v-if="loading_discussions">
                                                    <h5>Loading Discussions....</h5>
                                                </div>
                                                <discussion :discussions="discussions"></discussion>
                                                <discussion-form :lead="lead" @leaddiscussionevent="addDiscussion"></discussion-form>
                                                
                                            </div>
                                            <!-- end card body -->
                                        </div>
                                        <!-- end card -->
                                    </div>
                                    <!-- ene col -->
                                </div>
                                <!-- end row -->
                            </div>
                            <div class="tab-pane fade" id="project-payments" role="tabpanel" v-if="lead.expected_amount > 0">
                                <div class="row">
                                   <div class="col-xxl-3">
                                      <div class="card">
                                         <div class="card-body">
                                            <h5 class="card-title mb-3">Info</h5>
                                            <div class="table-responsive">
                                               <table class="table table-borderless mb-0">
                                                  <tbody>
                                                     <tr>
                                                        <th class="ps-0" scope="row">Expected Payment :</th>
                                                        <td class="text-muted">
                                                            <p class="badge bg-primary fs-15 mb-0">{{ currency + ' ' + lead.expected_amount }}</p>
                                                        </td>
                                                     </tr>
                                                     <tr>
                                                        <th class="ps-0" scope="row">Paid :</th>
                                                        <td class="text-muted">
                                                            <p class="badge bg-success fs-15 mb-0">{{ currency + ' ' + lead.paid }}</p>
                                                        </td>
                                                     </tr>
                                                     <tr>
                                                        <th class="ps-0" scope="row">Refund :</th>
                                                        <td class="text-muted">
                                                            <p class="badge bg-danger fs-15 mb-0">{{ currency + ' ' + lead.refund }}</p>
                                                        </td>
                                                     </tr>
                                                     <tr>
                                                        <th class="ps-0" scope="row">Remaining :</th>
                                                        <td class="text-muted">
                                                            <p class="badge bg-warning fs-15 mb-0">{{ currency + ' ' + lead.remaining }}</p>
                                                        </td>
                                                     </tr>
                                                  </tbody>
                                               </table>
                                            </div>
                                         </div>
                                         <!-- end card body -->
                                      </div>
                                      <!-- end card -->
                                   </div>
                                   <!--end col-->
                                   <div class="col-xxl-9">
                                      <div class="card">
                                         <div class="card-body" v-if="lead.payments.length > 0">
                                            <div class="row g-4 align-items-center">
                                                <div class="col-lg-3">
                                                    <h5 class="card-title mb-3">Payments</h5>
                                                </div>
                                                <div class="col-sm-auto ms-auto">
                                                    <div class="hstack gap-2">
                                                        <a href="javascript:;" @click="showCreatePayment" class="btn btn-primary" id="create-btn"><i class="ri-add-line align-bottom me-1"></i> Create Payment</a>
                                                        <a href="javascript:;" @click="showRefundPartialModal" class="btn btn-danger" id="refund-btn"><i class="ri-add-line align-bottom me-1"></i> Create Refund</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Amount</th>
                                                            <th scope="col">Paid By</th>
                                                            <th scope="col">Payment Date</th>
                                                            <th scope="col">Status</th>
                                                            <!-- <th scope="col">Action</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="payment in lead.payments" :key="payment.id">
                                                            <td>
                                                                {{ currency + ' ' +  payment.amount }}
                                                            </td>
                                                            <td>{{ payment.user.name }}</td>
                                                            <td>{{ payment.created_at }}</td>
                                                            <td>
                                                                <p :class="payment.status == 1 ? 'badge bg-success' : 'badge bg-danger' ">{{ payment.status == 1 ? 'PAID' : 'REFUND' }}</p>
                                                            </td>
                                                            <!-- <td>
                                                                <div class="hstack gap-3 flex-wrap">
                                                                    <a href="javascript:;" v-if="payment.status == 1" @click="showRefundModal($event)" :data-id="payment.id" class="btn btn-danger btn-sm">Refund</a>
                                                                    <a href="javascript:;" v-else class="btn btn-light btn-sm">Refunded</a>
                                                                </div>
                                                            </td> -->
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                         </div>
                                         <div class="card-body" v-else>
                                            <div class="row justify-content-center">
                                                <div class="col-xxl-4 col-lg-6">
                                                    <a href="javascript:;" @click="showCreatePayment" v-if="lead.expected_amount">
                                                        <div class="text-center">
                                                           <div class="avatar-sm mx-auto mb-3">
                                                              <div class="avatar-title bg-soft-success text-success fs-17 rounded">
                                                                 <i class="ri-add-line"></i>
                                                              </div>
                                                           </div>
                                                           <h4 class="card-title">Create Payment</h4>
                                                           <p class="card-text text-muted">payments will be created against {{ lead.lead_no }}</p>
                                                           <a href="javascript:;" class="btn btn-success">Add New</a>
                                                        </div>
                                                    </a>
                                                    <a href="javascript:;" @click="showExpectedPayment" v-else>
                                                        <div class="text-center">
                                                           <div class="avatar-sm mx-auto mb-3">
                                                              <div class="avatar-title bg-soft-success text-success fs-17 rounded">
                                                                 <i class="ri-add-line"></i>
                                                              </div>
                                                           </div>
                                                           <h4 class="card-title">Create Payment</h4>
                                                           <p class="card-text text-muted">payments will be created against {{ lead.lead_no }}</p>
                                                           <a href="javascript:;" class="btn btn-success">Add New</a>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                         </div>
                                         <!--end card-body-->
                                      </div>
                                   </div>
                                   <!--end col-->
                                </div>
                                <!-- end row -->
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-xl-3 col-lg-4">
                       <div class="card">
                          <div class="card-header align-items-center d-flex border-bottom-dashed">
                             <h4 class="card-title mb-0 flex-grow-1">Client Details</h4>
                          </div>
                          <div class="card-body">
                             <div data-simplebar="init" style="height: 235px;" class="mx-n3 px-3">
                                <div class="simplebar-wrapper" style="margin: 0px -16px;">
                                   <div class="simplebar-height-auto-observer-wrapper">
                                      <div class="simplebar-height-auto-observer"></div>
                                   </div>
                                   <div class="simplebar-mask">
                                      <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                         <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
                                            <div class="simplebar-content" style="padding: 0px 16px;">
                                               <div class="vstack gap-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1">
                                                            <h5 class="fs-13 mb-0"><a href="#" class="text-body d-block"> Name</a></h5>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <div class="d-flex align-items-center gap-1">
                                                                <span class="fw-medium">{{ lead.client.name }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1">
                                                            <h5 class="fs-13 mb-0"><a href="#" class="text-body d-block"> Email</a></h5>
                                                        </div>
                                                        <div class="flex-shrink-0">
                                                            <div class="d-flex align-items-center gap-1">
                                                                <span class="fw-medium">{{ lead.client.email }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                  <div class="d-flex align-items-center">
                                                     <div class="flex-grow-1">
                                                        <h5 class="fs-13 mb-0"><a href="#" class="text-body d-block"> Phone</a></h5>
                                                     </div>
                                                     <div class="flex-shrink-0">
                                                        <div class="d-flex align-items-center gap-1">
                                                           <span class="fw-medium">{{ lead.client.phone ?? '-' }}</span>
                                                        </div>
                                                     </div>
                                                  </div>
                                                  <!-- end member item -->
                                               </div>
                                               <!-- end list -->
                                            </div>
                                         </div>
                                      </div>
                                   </div>
                                   <div class="simplebar-placeholder" style="width: auto; height: 284px;"></div>
                                </div>
                                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                   <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                </div>
                                <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                   <div class="simplebar-scrollbar" style="height: 194px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                                </div>
                             </div>
                          </div>
                          <!-- end card body -->
                       </div>
                       <!-- end card -->
                       <div class="card" v-if="lead.is_converted === 0">
                            <div class="card-header align-items-center d-flex border-bottom-dashed">
                                <h4 class="card-title mb-0 flex-grow-1">Convert Lead Into Task</h4>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="convertLeadToTask">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12">
                                            <select-input v-model="convert.team_id" :required="true" :error="convert.errors.team_id" class="mb-3" label="Select Team" autofocus autocapitalize="off">
                                                <option value="">Select Team</option>
                                                <option v-for="team in teams" :key="team.id" :value="team.id">{{ team.team_no }} {{ team.name }}</option>
                                            </select-input>
                                        </div>
                                        <div class="col-xl-12 col-md-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary btn-block" :disabled="convert.processing">Convert</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <Footer/>
        <refund-modal>
            <template #content>
                <form @submit.prevent="refundPayment">
                    <div class="mt-4 pt-4">
                        <h4>Are you sure you want to refund this payment?</h4>
                        <p class="text-muted">This action cannot be undo</p>
                    </div>
                    <button class="btn btn-warning" type="submit">
                        Continue
                    </button>
                </form>
            </template>
        </refund-modal>

        <create-payment :lead="lead">
            <template #content>
                <form @submit.prevent="createPayment">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-3">
                            <text-input v-model="create_payment.amount" :error="create_payment.errors.amount" class="mt-10" label="Amount" placeholder="Enter Amount in USD" type="text" autofocus autocapitalize="off" />
                        </div>
                        <div class="col-xl-6 col-md-6 mb-3">
                            <text-input v-model="create_payment.date" data-provider="flatpickr" data-date-format="Y-m-d" :error="create_payment.errors.date" class="mt-10 flatpickr-date" label="Payment Date" placeholder="Select Date" type="text" autofocus autocapitalize="off" />
                        </div>
                        <div class="col-xl-6 col-md-6 mb-3">
                            <select-input v-model="create_payment.mode" :error="create_payment.errors.mode" class="mt-10" label="Payment Mode" autofocus autocapitalize="off">
                                <option value="stripe">Stripe</option>
                                <option value="paypal">Paypal</option>
                                <option value="authorize.net">Authorize.net</option>
                            </select-input>
                        </div>
                        <div class="col-xl-12 col-md-12">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block" :disabled="create_payment.processing">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </template>
        </create-payment>

        <expected-payment :lead="lead">
            <template #content>
                <form @submit.prevent="updateLead">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-3">
                            <text-input v-model="update_lead.expected_amount" :error="update_lead.errors.expected_amount" class="mt-10" label="Expected Amount" placeholder="Enter Amount in USD" type="number" autofocus autocapitalize="off" />
                        </div>
                        <div class="col-xl-12 col-md-12">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block" :disabled="update_lead.processing">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </template>
        </expected-payment>

        <create-resource :lead="lead">
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
        
        <refund-partial-modal :lead="lead">
            <template #content>
                <form @submit.prevent="refundPartialPayment">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-3">
                            <text-input v-model="refund_partial.amount" :error="refund_partial.errors.amount" class="mt-10" label="Amount" placeholder="Enter Amount in USD" type="text" autofocus autocapitalize="off" />
                        </div>
                        <div class="col-xl-6 col-md-6 mb-3">
                            <text-input v-model="refund_partial.date" data-provider="flatpickr" data-date-format="Y-m-d" :error="refund_partial.errors.date" class="mt-10 flatpickr-date" label="Payment Date" placeholder="Select Date" type="text" autofocus autocapitalize="off" />
                        </div>
                        <div class="col-xl-6 col-md-6 mb-3">
                            <select-input v-model="refund_partial.mode" :error="refund_partial.errors.mode" class="mt-10" label="Payment Mode" autofocus autocapitalize="off">
                                <option value="stripe">Stripe</option>
                                <option value="paypal">Paypal</option>
                                <option value="authorize.net">Authorize.net</option>
                            </select-input>
                        </div>
                        <div class="col-xl-12 col-md-12">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block" :disabled="refund_partial.processing">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </template>
        </refund-partial-modal>

    </div>
    <!-- end main content-->
</template>

<script>
    import Layout from '@/Shared/Layout'
    import Footer from '@/Shared/Footer'
    import Discussion from '@/Pages/SaleHead/Lead/Partials/Discussion'
    import DiscussionForm from '@/Pages/SaleHead/Lead/Partials/DiscussionForm'
    import CreateResource from '@/Pages/SaleHead/Lead/Partials/CreateResource'
    import RefundModal from '@/Pages/SaleHead/Lead/Partials/RefundModal'
    import CreatePayment from '@/Pages/SaleHead/Lead/Partials/CreatePayment'
    import ExpectedPayment from '@/Pages/SaleHead/Lead/Partials/ExpectedPayment'
    import RefundPartialModal from '@/Pages/SaleHead/Lead/Partials/RefundPartialModal'
    import TextInput from '@/Shared/TextInput'
    import SelectInput from '@/Shared/SelectInput'
    
    import vueFilePond from 'vue-filepond'
    import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
    import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size'
    import 'filepond/dist/filepond.min.css'
    import { useForm } from '@inertiajs/inertia-vue3'

    // Create FilePond component
    const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginFileValidateSize);

    export default {
        components: {
            Footer,
            Discussion,
            DiscussionForm,
            CreateResource,
            RefundModal,
            CreatePayment,
            ExpectedPayment,
            RefundPartialModal,
            TextInput,
            SelectInput,
            FilePond
        },
        layout: Layout,
        props: {
            lead: Object,
            teams: Object
        },
        data() {
            return {
                discussions: [],
                currency: 'USD',
                loading_discussions: true,
                refund: this.$inertia.form({}),
                create_payment: this.$inertia.form({
                    amount: null,
                    date: null,
                    mode: 'stripe',
                    lead_id: this.lead.id
                }),
                refund_partial: this.$inertia.form({
                    amount: null,
                    date: null,
                    mode: 'stripe',
                    lead_id: this.lead.id
                }),
                update_lead: this.$inertia.form({
                    expected_amount: null
                }),
                resource: this.$inertia.form({
                    myFiles: []
                }),
                convert: this.$inertia.form({
                    team_id: ''
                }),
                accepted_file_types: this.accepted_file_types_global,
                file_size_error_flag: false,
                file_type_error_flag: false,
            }
        },
        methods: {
            getDiscussions() {
                axios.get(route('saleshead.leads.discussions', { slug: this.currentWebsite.slug }), { params: { lead_id: this.lead.id } }).then((response) => {
                    this.loading_discussions = false;
                    response.data.forEach((value, index) => {
                        this.discussions.push(value);
                    })
                });
            },
            addDiscussion(comment) {
                axios.post(route('saleshead.leads.discussions.store', { slug: this.currentWebsite.slug }), { lead_id: this.lead.id, comment: comment.comment }).then((response) => {
                    this.discussions.push(response.data);
                });
                setTimeout(() => this.scrollToBottom(), 1000);
            },
            scrollToBottom() {
                var container = document.querySelector('.discussionContainer .simplebar-content-wrapper'); 
                container.scrollTo({ top: container.scrollHeight, behavior: "smooth" });
            },
            refundPayment() {
                this.refund.post(route('saleshead.leads.payments.update', { slug: this.currentWebsite.slug, id: this.refund.id }),{
                    preserveScroll: true,
                    onSuccess: () => this.hideRefundModal()
                });
            },
            createPayment() {
                this.create_payment.post(route('saleshead.leads.payments.store', { slug: this.currentWebsite.slug }), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.hideCreatePayment(),
                        this.create_payment.reset();
                    }
                });
            },
            updateLead() {
                this.update_lead.post(route('saleshead.leads.update.expected.amount', { slug: this.currentWebsite.slug, id: this.lead.id }),{
                    onSuccess: () => {
                        this.hideExpectedPayment(),
                        this.update_lead.reset()
                    }
                })
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
                this.resource.post(route('saleshead.leads.upload.media', { slug: this.currentWebsite.slug, id: this.lead.id }),{
                    preserveScroll: true,
                    onSuccess: () => {
                        this.resource.myFiles = [];
                        this.resource.reset();
                    },
                })
            },
            convertLeadToTask() {
                this.convert.post(route('saleshead.leads.convert.task', { slug: this.currentWebsite.slug, id: this.lead.id }),{
                    preserveScroll: true,
                    onSuccess: () => {
                        this.convert.reset('');
                    }
                });
            },
            refundPartialPayment() {
                this.refund_partial.post(route('saleshead.leads.payments.refund.partial', { slug: this.currentWebsite.slug }),{
                    preserveScroll: true,
                    onSuccess: () => this.hideRefundPartialModal()
                });
            },
            showRefundModal(e) {
                this.refund.id = e.target.getAttribute('data-id');
                bootstrap.Modal.getOrCreateInstance('#refundmodal').show();
            },
            hideRefundModal() {
                bootstrap.Modal.getOrCreateInstance('#refundmodal').hide();
            },
            showCreatePayment() {
                bootstrap.Modal.getOrCreateInstance('#paymentmodal').show();
            },
            hideCreatePayment() {
                bootstrap.Modal.getOrCreateInstance('#paymentmodal').hide();
            },
            showExpectedPayment() {
                bootstrap.Modal.getOrCreateInstance('#expectedpaymentmodal').show();
            },
            hideExpectedPayment() {
                bootstrap.Modal.getOrCreateInstance('#expectedpaymentmodal').hide();
            },
            showCreateResource() {
                bootstrap.Modal.getOrCreateInstance('#createresourcemodal').show();
            },
            hideCreateResource() {
                bootstrap.Modal.getOrCreateInstance('#createresourcemodal').hide();
            },
            showRefundPartialModal(e) {
                this.refund.id = e.target.getAttribute('data-id');
                bootstrap.Modal.getOrCreateInstance('#refundpartialmodal').show();
            },
            hideRefundPartialModal() {
                bootstrap.Modal.getOrCreateInstance('#refundpartialmodal').hide();
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
            
            Echo.private('lead-discussion.'+this.lead.id)
                .listen('LeadDiscussionEvent', (e) => {
                    this.discussions.push(e.discussion);
                    document.getElementById('ChatAudio').play();
                    setTimeout(() => this.scrollToBottom(), 1000);
                });

            setTimeout(() => this.scrollToBottom(), 1000);

            this.injectScripts(this.asset('public/assets/js/app.js'));
        }
    }
</script>