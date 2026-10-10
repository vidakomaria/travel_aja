<?php
/** English version of the Travel Aja about page. */
$whatsapp = preg_replace( '/\D/', '', get_theme_mod( 'travel_whatsapp', '' ) );
$email    = get_theme_mod( 'travel_email', '' );
$address  = trim( (string) get_theme_mod( 'travel_office_address', '' ) );
$hours    = get_theme_mod( 'travel_hours', 'Every day (08:00–17:00 WIB)' );
get_header();
?>
<main id="main-content" class="content-page about-page">
	<section class="travel-page-hero about-hero">
		<div class="container travel-page-hero__inner">
			<span>About Travel Aja</span>
			<h1>Explore Indonesia with Travel Aja</h1>
			<p>Find tour packages, local transport, and travel inspiration to plan a trip that suits you.</p>
			<div class="about-actions">
				<a href="<?php echo esc_url( custom_theme_listing_url( 'paket_wisata' ) ); ?>">Browse Tour Packages</a>
				<a href="#contact">Contact our team</a>
			</div>
		</div>
	</section>
	<section class="page-section">
		<div class="container">
			<div class="section-heading"><span class="about-kicker">Plan your trip</span><h2>Travel planning made easier</h2><p>Choose a destination, find the right package, and arrange transport with help from our local team.</p></div>
			<div class="about-grid">
				<article class="about-card"><b>Destination ideas</b><p>Explore places and experiences across Indonesia.</p></article>
				<article class="about-card"><b>Tour packages</b><p>Find a trip that fits your schedule, interests, and budget.</p></article>
				<article class="about-card"><b>Local transport</b><p>Browse vehicle options to make getting around easier.</p></article>
				<article class="about-card"><b>Personal support</b><p>Talk with our team about a route that suits your plans.</p></article>
			</div>
		</div>
	</section>
	<section class="page-section page-section--pale">
		<div class="container">
			<div class="section-heading"><span class="about-kicker">How it works</span><h2>Four steps to your next trip</h2></div>
			<div class="about-steps">
				<article class="about-step"><span>Choose a destination</span><p>Browse places that match your interests and travel dates.</p></article>
				<article class="about-step"><span>Pick a package</span><p>Compare trip options and choose one that suits your budget.</p></article>
				<article class="about-step"><span>Arrange transport</span><p>Find a vehicle for your route and group size.</p></article>
				<article class="about-step"><span>Enjoy the journey</span><p>Confirm the details with our team, then enjoy your time in Indonesia.</p></article>
			</div>
		</div>
	</section>
	<section class="page-section contact-page-section" id="contact">
		<div class="container">
			<div class="section-heading"><span class="about-kicker">Contact</span><h2>Talk to Travel Aja</h2><p>Share your travel plans and our team will help you choose destinations, packages, and transport.</p></div>
			<div class="contact-layout contact-layout--about">
				<aside class="contact-panel contact-panel--details"><div class="contact-info">
					<div class="contact-item"><small>Office</small><strong><?php echo esc_html( $address ?: 'Serving destinations across Indonesia' ); ?></strong></div>
					<div class="contact-item"><small>WhatsApp</small><?php if ( $whatsapp ) : ?><a href="<?php echo esc_url( 'https://wa.me/' . $whatsapp ); ?>"><?php echo esc_html( $whatsapp ); ?></a><?php else : ?><strong>Contact details coming soon</strong><?php endif; ?></div>
					<div class="contact-item"><small>Email</small><?php if ( $email ) : ?><a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a><?php else : ?><strong>Not available yet</strong><?php endif; ?></div>
					<div class="contact-item"><small>Hours</small><strong><?php echo esc_html( $hours ); ?></strong></div>
				</div></aside>
				<div class="contact-panel contact-panel--form">
					<?php if ( $whatsapp ) : ?>
					<form id="contact-trip-form" class="contact-form contact-form-grid" data-whatsapp="<?php echo esc_attr( $whatsapp ); ?>">
						<p class="contact-form-note">Share whatever details you already know. Every field is optional.</p>
						<label><span>Name</span><input type="text" name="name" placeholder="Your name"></label>
						<label><span>Group size</span><select name="people"><option value="">Choose group size</option><option>1 person</option><option>2 people</option><option>3–5 people</option><option>6–10 people</option><option>More than 10 people</option></select></label>
						<label><span>Estimated budget per person</span><select name="budget"><option value="">Choose a budget</option><option>Under Rp 500,000</option><option>Rp 500,000–Rp 1,000,000</option><option>Rp 1,000,000–Rp 2,000,000</option><option>Over Rp 2,000,000</option></select></label>
						<label><span>Approximate departure date</span><input type="date" name="date"></label>
						<label class="full"><span>Destinations or activities</span><input type="text" name="interest" placeholder="For example: beaches, nature, culture, food"></label>
						<label class="full"><span>Trip notes</span><textarea name="notes" rows="4" placeholder="Tell us what you have in mind"></textarea></label>
						<button type="submit">◉ Send to WhatsApp</button>
					</form>
					<p id="contact-trip-status" class="contact-status" aria-live="polite"></p>
					<?php else : ?><p>Contact details are not connected yet. Please check back soon.</p><?php endif; ?>
				</div>
			</div>
			<div class="page-bottom-cta"><div><h2>Ready to plan your trip?</h2><p>Explore destinations and find a package for your next journey.</p></div><div class="page-bottom-cta__actions"><a href="<?php echo esc_url( custom_theme_listing_url( 'destinasi' ) ); ?>">Explore Destinations</a><a href="<?php echo esc_url( custom_theme_listing_url( 'paket_wisata' ) ); ?>">Browse Tour Packages</a></div></div>
		</div>
	</section>
</main>
<?php get_footer(); ?>
