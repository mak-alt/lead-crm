<template>
	<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header bg-light">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Leads Filters</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <!--end offcanvas-header-->
        <form action="" class="d-flex flex-column justify-content-end h-100">
            <div class="offcanvas-body">
                <div class="mb-4">
                    <label for="datepicker-range" class="form-label text-muted text-uppercase fw-semibold mb-3">Date</label>
                    <input type="date" class="form-control" id="datepicker-range" data-provider="flatpickr" data-range="true" placeholder="Select date">
                </div>
                <div class="mb-4">
                    <label for="status-select" class="form-label text-muted text-uppercase fw-semibold mb-3">Status</label>
                    <div class="row g-2">
                        <div class="col-lg-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                <label class="form-check-label" for="inlineCheckbox1">New Leads</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                                <label class="form-check-label" for="inlineCheckbox2">Old Leads</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3">
                                <label class="form-check-label" for="inlineCheckbox3">Loss Leads</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox4" value="option4">
                                <label class="form-check-label" for="inlineCheckbox4">Follow Up</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="leadscore" class="form-label text-muted text-uppercase fw-semibold mb-3">Lead Score</label>
                    <div class="row g-2 align-items-center">
                        <div class="col-lg">
                            <input type="number" class="form-control" id="leadscore" placeholder="0">
                        </div>
                        <div class="col-lg-auto">
                            To
                        </div>
                        <div class="col-lg">
                            <input type="number" class="form-control" id="leadscore" placeholder="0">
                        </div>
                    </div>
                </div>
                <div>
                    <label for="leads-tags" class="form-label text-muted text-uppercase fw-semibold mb-3">Tags</label>
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="marketing" value="marketing">
                                <label class="form-check-label" for="marketing">Marketing</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="management" value="management">
                                <label class="form-check-label" for="management">Management</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="business" value="business">
                                <label class="form-check-label" for="business">Business</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="investing" value="investing">
                                <label class="form-check-label" for="investing">Investing</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="partner" value="partner">
                                <label class="form-check-label" for="partner">Partner</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="lead" value="lead">
                                <label class="form-check-label" for="lead">Leads</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="sale" value="sale">
                                <label class="form-check-label" for="sale">Sale</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="owner" value="owner">
                                <label class="form-check-label" for="owner">Owner</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="banking" value="banking">
                                <label class="form-check-label" for="banking">Banking</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="banking" value="banking">
                                <label class="form-check-label" for="banking">Exiting</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="banking" value="banking">
                                <label class="form-check-label" for="banking">Finance</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="banking" value="banking">
                                <label class="form-check-label" for="banking">Fashion</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end offcanvas-body-->
            <div class="offcanvas-footer border-top p-3 text-center hstack gap-2">
                <button class="btn btn-light w-100">Clear Filter</button>
                <button type="submit" class="btn btn-success w-100">Filters</button>
            </div>
            <!--end offcanvas-footer-->
        </form>
    </div>
    <!--end offcanvas-->
</template>

<script>
	
	import TextInput from '@/Shared/TextInput'
	import SelectInput from '@/Shared/SelectInput'


</script>