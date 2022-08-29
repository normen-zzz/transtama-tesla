	<!-- ======= Hero Section slider ======= -->
	<?php $this->load->view('templates/front/slider'); ?>

	<!-- ======= Services Section ======= -->
	<section id="services" class="services">
		<div class="container">

			<div class="section-title">
				<h2>Layanan Pembelajaran Online</h2>
				<p></p>
			</div>

			<div class="row">
				<?php foreach ($layanan as $l) { ?>
					<div class="col-lg-4 col-md-6 d-flex align-items-stretch mb-4" data-aos="zoom-in" data-aos-delay="100">
						<div class="icon-box <?= $l['color_icon'] ?>">
							<div class="icon">
								<svg width="100" height="100" viewBox="0 0 600 600" xmlns="">
									<path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,521.0016835830174C376.1290562159157,517.8887921683347,466.0731472004068,529.7835943286574,510.70327084640275,468.03025145048787C554.3714126377745,407.6079735673963,508.03601936045806,328.9844924480964,491.2728898941984,256.3432110539036C474.5976632858925,184.082847569629,479.9380746630129,96.60480741107993,416.23090153303,58.64404602377083C348.86323505073057,18.502131276798302,261.93793281208167,40.57373210992963,193.5410806939664,78.93577620505333C130.42746243093433,114.334589627462,98.30271207620316,179.96522072025542,76.75703585869454,249.04625023123273C51.97151888228291,328.5150500222984,13.704378332031375,421.85034740162234,66.52175969318436,486.19268352777647C119.04800174914682,550.1803526380478,217.28368757567262,524.383925680826,300,521.0016835830174"></path>
								</svg>
								<i class="<?= $l['icon'] ?>"></i>
							</div>
							<h4><a href="<?= $l['link']; ?>"><?= $l['nama_layanan'] ?></a></h4>
							<p><?= $l['deskripsi'] ?></p>
						</div>
					</div>

				<?php } ?>

			</div>

		</div>
	</section><!-- End Services Section -->


	<!-- ======= Contact Section ======= -->
	<!-- <section id="contact" class="contact">
	<div class="container">

		<div class="section-title">
			<h2>Contact</h2>
			<p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
		</div>

		<div class="row">

			<div class="col-lg-5 d-flex align-items-stretch">
				<div class="info">
					<div class="address">
						<i class="icofont-google-map"></i>
						<h4>Location:</h4>
						<p>A108 Adam Street, New York, NY 535022</p>
					</div>

					<div class="email">
						<i class="icofont-envelope"></i>
						<h4>Email:</h4>
						<p>info@example.com</p>
					</div>

					<div class="phone">
						<i class="icofont-phone"></i>
						<h4>Call:</h4>
						<p>+1 5589 55488 55s</p>
					</div>

					<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe>
				</div>

			</div>

			<div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
				<form action="forms/contact.php" method="post" role="form" class="php-email-form">
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="name">Your Name</label>
							<input type="text" name="name" class="form-control" id="name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
							<div class="validate"></div>
						</div>
						<div class="form-group col-md-6">
							<label for="name">Your Email</label>
							<input type="email" class="form-control" name="email" id="email" data-rule="email" data-msg="Please enter a valid email" />
							<div class="validate"></div>
						</div>
					</div>
					<div class="form-group">
						<label for="name">Subject</label>
						<input type="text" class="form-control" name="subject" id="subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
						<div class="validate"></div>
					</div>
					<div class="form-group">
						<label for="name">Message</label>
						<textarea class="form-control" name="message" rows="10" data-rule="required" data-msg="Please write something for us"></textarea>
						<div class="validate"></div>
					</div>
					<div class="mb-3">
						<div class="loading">Loading</div>
						<div class="error-message"></div>
						<div class="sent-message">Your message has been sent. Thank you!</div>
					</div>
					<div class="text-center"><button type="submit">Send Message</button></div>
				</form>
			</div>

		</div>

	</div>
</section> -->