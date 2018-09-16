<?php get_header(); ?>

<div class="l-body">

	<h2 class="u-screen-reader">Main content</h2>

	<?php 
		// Banner Content
		$banner_title = get_field('featured_hero_title');
		$banner_subtitle = get_field('featured_hero_subtitle');
		if(!$banner_title):
			$banner_title = get_the_title();
		endif;

		// Banner Background
		$banner_background = get_field('featured_hero'); 
		if($banner_background):
			$banner_background = $banner_background['sizes']['banner'];
		else:
			$banner_background = get_bloginfo('stylesheet_directory').'/images/banner-services.jpg';
		endif;
	?>
	<div class="banner" style="background-image: url(<?php echo $banner_background; ?>);">
		<span class="banner__content">
			<?php if($banner_title): ?>
				<p class="banner__content--first"><?php echo $banner_title; ?></p>
			<?php endif; ?>
			<?php if($banner_subtitle): ?>
				<p class="banner__content--second"><?php echo $banner_subtitle; ?></p>
			<?php endif; ?>
		</span>
	</div>

<!-- Service Intro -->
	<div class="location-intro">
		<div class='l-container'>
			<?php if( have_rows('location_intro') ): 
			while( have_rows('location_intro') ): the_row(); 
			$location_intro_title = get_sub_field('location_intro_title');
			$location_intro_content = get_sub_field('location_intro_content'); ?>
				<h1 class="location-intro__title"><?php echo $location_intro_title; ?></h1>
				<p class="location-intro__content"><?php echo $location_intro_content; ?></p>
			<?php endwhile;
			endif; ?>
		</div>
	</div>

<!-- Members -->
	<div class="location-members">
		<div class='l-container'>
			<p class="location-members__title">Our Leaders</p>
			<ul class="members">
				<?php
					$args = array(
						'post_type' => 'member',
						'posts_per_page' => -1,
						'orderby'=> 'menu_order',
						'meta_query' => array(
							array(
								'key' => 'location', 
								'value' => '"' . get_the_ID() . '"', 
								'compare' => 'LIKE'
							)
						)
					);
					$loop = new WP_Query( $args );
					if ( $loop->have_posts() ): 
					while ( $loop->have_posts() ) : $loop->the_post();
						$profile_name = get_the_title();
						$profile_description = get_field('profile_description');
						$profile_description = htmlentities($profile_description, null, 'utf-8');
						$profile_description = str_replace("&nbsp;", " ", $profile_description);
						$profile_description = html_entity_decode($profile_description);
						$profile_industry = get_field('industry');
						$profile_image = get_field('profile_image');
						if($profile_image):
							$profile_image = $profile_image['sizes']['thumbnail'];
						else:
							$profile_image = get_bloginfo('stylesheet_directory').'/images/placeholder-member.jpg';
						endif;
					?>
			        <div class="member-tile">
			        	<img src="<?php echo $profile_image; ?>" class="member-tile__image">
			            <div class="member-tile__bio">
			            	<p class="member-tile__bio__industry"><?php echo $profile_industry; ?></p>
			            	<span class="member-tile__bio__description"><?php echo $profile_description; ?></span>
			            </div>
			        </div>

					<?php endwhile;
					endif;
					wp_reset_postdata();
				?>
			</ul>
		</div>
	</div>

<!-- Location Offices -->
	<div class="offices">
		<div class='l-container'>
			<p class="offices__title">Our Locations</p>
			<div class="office-tiles">
				<?php if( have_rows('locations') ): 
				while( have_rows('locations') ): the_row(); 
				$location_name = get_sub_field('location_name');
				$location_address = get_sub_field('location_address');
				$location_map = get_sub_field('location_map');
				$location_map = $location_map['sizes']['office-map']; ?>
					<div class="office-tile">
						<div class="office-tile__details">
							<p class="office-tile__details__name"><?php echo $location_name; ?></p>
							<span class="office-tile__details__address"><?php echo $location_address; ?></span>
						</div>
						<div class="office-tile__map" ></div>
					</div>
				<?php endwhile;
				endif; ?>
			</div>
		</div>
	</div>
</div>
<script>
	const offices = Array.from(document.getElementsByClassName('office-tile__map'));
	function initMap() {
		let geocoder = new google.maps.Geocoder();
		let address;
		offices.map(el => {
			showLocation(geocoder, el);
		});
	}
	function showLocation(geocoder, el) {
		let coor = {
			lat: '',
			lng: ''
		};
		let address = getAddress(el.previousElementSibling.children[1]);
		geocoder.geocode({'address': address}, function(results, status) {
			if (status === google.maps.GeocoderStatus.OK) {
				coor.lat = results[0].geometry.location.lat();
				coor.lng = results[0].geometry.location.lng();
				let map = new google.maps.Map(el, {
					center: coor,
						zoom: 15
				});
				showMarker(map, coor, address);
			}
		});
	}
	function showMarker(resultedMap, coor, address) {
		let marker = new google.maps.Marker({
				map: resultedMap,
				position: coor
		});
		let infoWindow = new google.maps.InfoWindow({
			content: address
		});	
		marker.addListener('click', function() {
			infoWindow.open(resultedMap, marker);
		});
	}
	function getAddress(string) {
		return string.children[0].childNodes[0].nodeValue;
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDamahnGNNXb3nehQvuksnFzTEZYORG8KE&callback=initMap"
    async defer></script>
<?php get_footer(); ?>
