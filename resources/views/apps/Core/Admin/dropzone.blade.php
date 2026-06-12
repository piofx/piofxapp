<x-dynamic-component :component="$componentName" class="mt-4" >
<div class="card card-custom gutter-b">
	<form method="post" action="{{ url()->current() }}">
		<div class="card-header">
										<div class="card-title">
											<h3 class="card-label">Dropzone File Upload Examples</h3>
										</div>
									</div>
		<div class="card-body">
			<div class="form-group row">
				<label class="col-form-label col-lg-3 col-sm-12 text-lg-right">Single File Upload</label>
				<div class="col-lg-4 col-md-9 col-sm-12">
					<div class="dropzone dropzone-default" id="kt_dropzone_1">
						<div class="dropzone-msg dz-message needsclick">
							<h3 class="dropzone-msg-title">Drop files here or click to upload.</h3>
							<span class="dropzone-msg-desc">This is just a demo dropzone. Selected files are 
								<strong>not</strong>actually uploaded.</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer">
											<div class="row">
												<div class="col-lg-3"></div>
												<div class="col-lg-4">
													<input type="hidden" class="_token" name="_token" value="{{ csrf_token() }}">
													<button type="submit" class="btn btn-light-primary mr-2">Submit</button>
													<button type="reset" class="btn btn-primary">Cancel</button>
												</div>
											</div>
										</div>
		</form>
	</div>
</x-dynamic-component>