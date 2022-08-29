<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container">
			<!--begin::Dashboard-->
			<div class="row">
				<div class="col-md-6">
					<div id="app">
						<div class="sidebar">
							<section class="cameras">
								<h2>Cameras</h2>
								<ul>
									<li v-if="cameras.length === 0" class="empty">No cameras found</li>
									<li v-for="camera in cameras">
										<span v-if="camera.id == activeCameraId" :title="formatName(camera.name)" class="active">{{ formatName(camera.name) }}</span>
										<span v-if="camera.id != activeCameraId" :title="formatName(camera.name)">
											<a @click.stop="selectCamera(camera)">{{ formatName(camera.name) }}</a>
										</span>
									</li>
								</ul>
							</section>
							<section class="scans">
								<h2>Scans</h2>
								<ul v-if="scans.length === 0">
									<li class="empty">No scans yet</li>
								</ul>
								<transition-group name="scans" tag="ul">
									<textarea name="" id="" v-for="scan in scans" :key="scan.date" :title="scan.content">{{ scan.content }}</textarea>
									<!-- <input type="text" v-for="scan in scans" :key="scan.date" :title="scan.content" value="{{ scan.content }}"> -->
									<!-- <li v-for="scan in scans" :key="scan.date" :title="scan.content">{{ scan.content }}</li> -->
								</transition-group>
							</section>
						</div>
						<div class="preview-container">
							<video id="preview"></video>
						</div>
					</div>

				</div>

			</div>


		</div>
		<!--end::Container-->
	</div>
	<!--end::Entry-->
</div>
<!--end::Content-->