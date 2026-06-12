<x-dynamic-component :component="$app->componentName">
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">
						<!--begin::Entry-->
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container">
								<!--begin::Profile Personal Information-->
								<div class="d-flex flex-row">
									<!--begin::Aside-->
									<div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
										<!--begin::Profile Card-->
										<div class="card card-custom card-stretch">
											<!--begin::Body-->
											<div class="card-body pt-4">
												<!--img display-->
                                                <img src="{{ asset($url) }}" class="img-fluid" alt="document can't be displayed ">
												
											</div>
											<!--end::Body-->
										</div>
										<!--end::Profile Card-->
									</div>
									<!--end::Aside-->
									<!--begin::Content-->
									<div class="flex-row-fluid ml-lg-8">
										<!--begin::Card-->
										<div class="card card-custom card-stretch">
											<!--begin::Header-->
											<div class="card-header py-3">
												<div class="card-title align-items-start flex-column">
													<h3 class="card-label font-weight-bolder text-dark">Image Information</h3>
												</div>
											</div>
											<!--end::Header-->
											<!--begin::Form-->
											<form  class="form">
                                            
                                              <div class="card-body">
													<div class="row">
														<label class="col-xl-3"></label>
														<div class="col-lg-9 col-xl-6">
															<h5 class="font-weight-bold mb-6">Image Info</h5>
														</div>
													</div>
                                                   
                                                    <div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label text-right"><h5>Image URL</h5></label>
														<div class="col-lg-9 col-xl-6">
                                                            <input type="text" class="form-control" placeholder="Enter First name" name="firstname" value="{{ asset($url) }}" id="myInput">
                                                        </div>
                                                        <div class="col-lg-9 col-xl-6">
                                                        <i class="fas fa-copy" style="float:right" onclick="copyfunction()">Copy</i>  
                                                        </div>
                                                    </div>	
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label text-right">Title </label>
                                                        <div class="col-lg-9 col-xl-6">
															<div class="input-group input-group-lg input-group-solid">
                                                            <input type="text" class="form-control" id="inputCity" name="city" value="{{$objs->title}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                        <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label text-right">Description </label>
                                                        <div class="col-lg-9 col-xl-6">
															<div class="input-group input-group-lg input-group-solid">
                                                            <input type="text" class="form-control" id="inputCity" name="state" value="{{$objs->description}}">
                                                            </div>
                                                        </div>
                                                      </div> 
                                                        </div>
                                                    </form>
                                                </div>
												<!--end::Body-->
											</form>
											<!--end::Form-->
										</div>
									</div>
									<!--end::Content-->
								</div>
								<!--end::Profile Personal Information-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>
					<!--end::Content-->
					
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Main-->

</x-dynamic-component>