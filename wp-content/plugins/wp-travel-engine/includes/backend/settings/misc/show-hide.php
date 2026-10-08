<?php
/**
 * Show hide options.
 */
$settings = get_option( 'wp_travel_engine_settings', [] );
$feat_img                  = isset( $settings['feat_img'] ) ? esc_attr( $settings['feat_img'] ) : '0';
$show_trip_facts_sidebar   = isset( $settings['show_trip_facts_sidebar'] ) && $settings['show_trip_facts_sidebar'] != '' ? $settings['show_trip_facts_sidebar'] : 'yes';
$hide_traveller_info       = isset( $settings['travelers_information'] ) ? $settings['travelers_information'] : 'yes';
?>
<div class="wpte-form-block-wrap">
	<div class="wpte-form-block">
		<div class="wpte-form-content">
			<div class="wpte-field wpte-checkbox advance-checkbox">
				<label class="wpte-field-label" for="wp_travel_engine_settings[booking]"><?php esc_html_e( 'Hide Booking Form', 'wp-travel-engine' ); ?></label>
				<div class="wpte-checkbox-wrap">
					<input type="checkbox" id="wp_travel_engine_settings[booking]" class="hide-booking" name="wp_travel_engine_settings[booking]" value="1"
					<?php
					if ( isset( $settings['booking'] ) && $settings['booking'] != '' ) {
						echo 'checked';}
					?>
					>
					<label for="wp_travel_engine_settings[booking]"></label>
				</div>
				<span class="wpte-tooltip"><?php esc_html_e( 'If checked, booking form in the trip detail page will be disabled.', 'wp-travel-engine' ); ?></span>
			</div>

			<div class="wpte-field wpte-checkbox advance-checkbox">
				<label class="wpte-field-label" for="wp_travel_engine_settings[enquiry]"><?php esc_html_e( 'Hide Enquiry Form', 'wp-travel-engine' ); ?></label>
				<div class="wpte-checkbox-wrap">
					<input type="checkbox" id="wp_travel_engine_settings[enquiry]" class="hide-enquiry" name="wp_travel_engine_settings[enquiry]" value="1"
					<?php
					if ( isset( $settings['enquiry'] ) && $settings['enquiry'] != '' ) {
						echo 'checked';}
					?>
					>
					<label for="wp_travel_engine_settings[enquiry]"></label>
				</div>
				<span class="wpte-tooltip"><?php esc_html_e( 'If checked, enquiry form in the trip detail page will be disabled.', 'wp-travel-engine' ); ?></span>
			</div>
			<?php
			// SHow form editor upsell.
			$form_editor_enabled = apply_filters( 'wpte_is_form_editor_addon_active', false );

			if ( ! $form_editor_enabled ) :
				?>
				<div style="margin-bottom: 40px;" class="wpte-info-block">
						<b><?php esc_html_e( 'Note:', 'wp-travel-engine' ); ?></b>
						<p>
							<?php
								echo wp_kses(
									sprintf(
										__( 'Need to edit the booking, enquiry and traveller information form as per your requirements? You can use Form Editor extension to edit fields and add your own. %1$sGet Form Editor extension now%2$s.', 'wp-travel-engine' ),
										'<a target="_blank" href="https://wptravelengine.com/downloads/form-editor/?utm_source=setting&utm_medium=customer_site&utm_campaign=setting_addon">',
										'</a>'
									),
									array(
										'a' => array(
											'target' => array(),
											'href'   => array(),
										),
									)
								);
							?>
						</p>
				</div>
			<?php endif; ?>
			<div class="wpte-field wpte-checkbox advance-checkbox">
				<label class="wpte-field-label" for="wp_travel_engine_settings[emergency]"><?php esc_html_e( 'Hide Emergency Contact Details', 'wp-travel-engine' ); ?></label>
				<div class="wpte-checkbox-wrap">
					<input type="checkbox" id="wp_travel_engine_settings[emergency]" class="hide-emergency" name="wp_travel_engine_settings[emergency]" value="1"
					<?php
					if ( isset( $settings['emergency'] ) && $settings['emergency'] != '' ) {
						echo 'checked';}
					?>
					>
					<label for="wp_travel_engine_settings[emergency]"></label>
				</div>
				<span class="wpte-tooltip"><?php esc_html_e( 'If checked, Emergency Contact Details of the travelers will be disabled from the Travelers Information Form.', 'wp-travel-engine' ); ?></span>
			</div>

			<div class="wpte-field wpte-checkbox advance-checkbox">
				<label class="wpte-field-label" for="wp_travel_engine_settings[feat_img]"><?php esc_html_e( 'Hide Trip Featured Image', 'wp-travel-engine' ); ?></label>
				<div class="wpte-checkbox-wrap">
					<input type="checkbox" id="wp_travel_engine_settings[feat_img]" name="wp_travel_engine_settings[feat_img]" value="1" <?php echo checked( '1', $feat_img ); ?>>
					<label for="wp_travel_engine_settings[feat_img]"></label>
				</div>
				<span class="wpte-tooltip"><?php esc_html_e( 'If checked, featured image in the trip detail page will be disabled.', 'wp-travel-engine' ); ?></span>
			</div>

			<div class="wpte-field wpte-checkbox advance-checkbox">
				<label class="wpte-field-label" for="wp_travel_engine_settings[travelers_information]"><?php esc_html_e( 'Hide Travelers Information', 'wp-travel-engine' ); ?></label>
				<div class="wpte-checkbox-wrap">
					<input type="hidden" name="wp_travel_engine_settings[travelers_information]" value="no">
					<input type="checkbox" id="wp_travel_engine_settings[travelers_information]" name="wp_travel_engine_settings[travelers_information]" value="yes" <?php checked( $hide_traveller_info, 'yes' ); ?>>
					<label for="wp_travel_engine_settings[travelers_information]"></label>
				</div>
				<span class="wpte-tooltip"><?php esc_html_e( 'If checked, information of all the travelers will be optional. After checkout, information of each of the travelers will not be asked to fill up.', 'wp-travel-engine' ); ?></span>
			</div>

			<div class="wpte-field wpte-checkbox advance-checkbox">
				<label class="wpte-field-label" for="wp_travel_engine_settings[tax_images]"><?php esc_html_e( 'Show Taxonomy Image', 'wp-travel-engine' ); ?></label>
				<div class="wpte-checkbox-wrap">
					<input type="checkbox" id="wp_travel_engine_settings[tax_images]" name="wp_travel_engine_settings[tax_images]" value="1"
					<?php
					if ( isset( $settings['tax_images'] ) && $settings['tax_images'] != '' ) {
						echo 'checked';}
					?>
					>
					<label for="wp_travel_engine_settings[tax_images]"></label>
				</div>
				<span class="wpte-tooltip"><?php esc_html_e( 'Enable to show taxonomy image in the taxonomy page.', 'wp-travel-engine' ); ?></span>
			</div>
			<div class="wpte-field wpte-checkbox advance-checkbox">
				<label class="wpte-field-label" for="wp_travel_engine_settings[show_multiple_pricing_list_disp]"><?php esc_html_e( 'Display Multiple Prices List', 'wp-travel-engine' ); ?></label>
				<div class="wpte-checkbox-wrap">
					<input type="checkbox" id="wp_travel_engine_settings[show_multiple_pricing_list_disp]" name="wp_travel_engine_settings[show_multiple_pricing_list_disp]" value="1"
					<?php
					if ( isset( $settings['show_multiple_pricing_list_disp'] ) && $settings['show_multiple_pricing_list_disp'] != '' ) {
						echo 'checked';}
					?>
					>
					<label for="wp_travel_engine_settings[show_multiple_pricing_list_disp]"></label>
				</div>
				<span class="wpte-tooltip"><?php esc_html_e( 'If checked, multiple pricing options prices will be displayed on the trip page above the booking date selection area, if unchecked, Genereal or Adult prices will only be shown.', 'wp-travel-engine' ); ?></span>
			</div>

			<div class="wpte-field wpte-checkbox advance-checkbox">
				<label class="wpte-field-label" for="wp_travel_engine_settings[show_excerpt]"><?php esc_html_e( 'Show Excerpt', 'wp-travel-engine' ); ?></label>
				<div class="wpte-checkbox-wrap">
					<input type="hidden" name="wp_travel_engine_settings[show_excerpt]" value="no" checked />
					<input type="checkbox" id="wp_travel_engine_settings[show_excerpt]"
						name="wp_travel_engine_settings[show_excerpt]"
						value="1"
						<?php checked( ! isset( $settings['show_excerpt'] ) || '1' == $settings['show_excerpt'], true ); ?> />
					<label for="wp_travel_engine_settings[show_excerpt]" class="checkbox-label"></label>
				</div>
				<span class="wpte-tooltip"><?php esc_html_e( 'Enable to display trip excerpt in the taxonomy pages.', 'wp-travel-engine' ); ?></span>
			</div>
			<?php
			$checked = ! isset( $settings['show_related_trips'] ) || 'yes' == $settings['show_related_trips'];
			$section_title = ! empty( $settings['related_trips_section_title'] ) ? $settings['related_trips_section_title'] : __( 'Related trips you might interested in', 'wp-travel-engine' );
			$no_of_trips = ! empty( $settings['no_of_related_trips'] ) ? (int) $settings['no_of_related_trips'] : 3;
			?>
			<div class="wpte-field wpte-checkbox advance-checkbox">
				<label class="wpte-field-label" data-wte-update="wte_new_5.5.0" for="wp_travel_engine_settings[show_related_trips]"><?php esc_html_e( 'Show Related Trips', 'wp-travel-engine' ); ?></label>
				<div class="wpte-checkbox-wrap">
					<input type="hidden" name="wp_travel_engine_settings[show_related_trips]" value="no" />
					<input type="checkbox" id="wp_travel_engine_settings[show_related_trips]"
						name="wp_travel_engine_settings[show_related_trips]"
						value="yes"
						data-onchange
						data-onchange-toggle-target="[data-show-related-trips]"
						data-onchange-toggle-off-value="no"
						<?php checked( $checked, true ); ?> />
					<label for="wp_travel_engine_settings[show_related_trips]" class="checkbox-label"></label>
				</div>
				<span class="wpte-tooltip"><?php esc_html_e( 'Enable to display related trips in the trip pages.', 'wp-travel-engine' ); ?></span>
			</div>

			<div class="wpte-field wpte-floated<?php echo $checked ? '' : ' hidden' ?>" data-show-related-trips>
				<label class="wpte-field-label" for="related_trips_section_title"><?php echo esc_html( 'Related Section Title' ); ?></label>
				<input type="text" name="wp_travel_engine_settings[related_trips_section_title]" id="related_trips_section_title" value="<?php echo esc_attr( $section_title ); ?>">
			</div>

			<div class="wpte-field wpte-floated <?php echo $checked ? '' : ' hidden' ?>" data-show-related-trips>
				<label class="wpte-field-label" for="no_of_related_trips"><?php echo esc_html( 'No. of Related Trips to display' ); ?></label>
				<input type="number" name="wp_travel_engine_settings[no_of_related_trips]" id="no_of_related_trips"  value="<?php echo esc_attr( $no_of_trips ); ?>">
			</div>

			<div class="wpte-field wpte-select wpte-floated" data-show-related-trips>
				<label for="wpte_related_trips_show_by" class="wpte-field-label"><?php _e( "Show Related Trips By", 'wp-travel-engine' ); ?></label>
				<select name="wp_travel_engine_settings[related_trip_show_by]" id="wpte_related_trips_show_by" class="wpte-enhanced-select">
				<?php
				$trip_taxonomies = get_taxonomies( [ 'object_type' => [ WP_TRAVEL_ENGINE_POST_TYPE ] ], 'objects' );
				$related_trip_show_by = ! empty( $settings['related_trip_show_by'] ) ? $settings['related_trip_show_by'] : 'activities';
				$post_type_object = get_post_type_object( WP_TRAVEL_ENGINE_POST_TYPE );
				echo wp_kses( array_reduce( $trip_taxonomies, function( $carry, $item ) use ( $related_trip_show_by ) {
					$selected = selected( $related_trip_show_by, $item->name, false );
					return $carry . "<option value=\"{$item->name}\" {$selected}>{$item->label}</option>";
				}, '' ), ['option' => ['value' => [], 'selected' => []]] );
				?>
				</select>
			</div>

			<div class="wpte-field wpte-checkbox advance-checkbox">
				<label class="wpte-field-label" for="wp_travel_engine_settings[show_trip_facts_sidebar]"><?php esc_html_e( 'Show Trip Infos on Sidebar', 'wp-travel-engine' ); ?></label>
				<div class="wpte-checkbox-wrap">
					<input type="hidden" name="wp_travel_engine_settings[show_trip_facts_sidebar]" value="no" >
					<input type="checkbox" id="wp_travel_engine_settings[show_trip_facts_sidebar]" name="wp_travel_engine_settings[show_trip_facts_sidebar]" value="yes" <?php checked( $show_trip_facts_sidebar, 'yes' ); ?>>
					<label for="wp_travel_engine_settings[show_trip_facts_sidebar]" class="checkbox-label"></label>
				</div>
				<span class="wpte-tooltip"><?php esc_html_e( 'Check to display the trip info section in the trip single sidebar.', 'wp-travel-engine' ); ?></span>
			</div>

			<div class="wpte-field wpte-checkbox advance-checkbox">
				<label class="wpte-field-label" for="wp_travel_engine_settings[hide_powered_by]"><?php esc_html_e( 'Hide Powered By Link', 'wp-travel-engine' ); ?></label>
				<div class="wpte-checkbox-wrap">
					<input type="hidden" name="wp_travel_engine_settings[hide_powered_by]" value="no" >
					<input type="checkbox" id="wp_travel_engine_settings[hide_powered_by]" class="hide-powered-by" value="yes" name="wp_travel_engine_settings[hide_powered_by]"
					<?php
					$hide_powered_by = isset( $settings['hide_powered_by'] ) && 'yes' === $settings['hide_powered_by'];
					echo $hide_powered_by ? 'checked="checked"' : '';
					?>
					>
					<label for="wp_travel_engine_settings[hide_powered_by]"></label>
				</div>
				<span class="wpte-tooltip"><?php esc_html_e( 'If checked, Powered by Link will be hidden from enquiry and booking emails.', 'wp-travel-engine' ); ?></span>
			</div>

			<?php
			$legacy_version_enabled = get_option( 'enable_legacy_trip', '' ) === 'yes';
			?>
			<?php if ( $legacy_version_enabled ) : ?>
				<div class="wpte-field wpte-checkbox advance-checkbox">
					<label class="wpte-field-label" for="enable_legacy_trip"><?php esc_html_e( 'Use Legacy Version Trip', 'wp-travel-engine' ); ?></label>
					<div class="wpte-checkbox-wrap">
						<input type="hidden" name="enable_legacy_trip" value="no" >
						<input type="checkbox" id="enable_legacy_trip" class="" value="yes" name="enable_legacy_trip"
						<?php
						checked( $legacy_version_enabled, true );
						?>
						 />
						<label for="enable_legacy_trip"></label>
					</div>
					<span class="wpte-tooltip"><?php esc_html_e( 'If checked, the new features like multiple packages, multiple dates will be disabled on the trips and legacy trip settings will be applied. It is not recommend to enable this option as this option will be removed on later releases and new features will be applied.', 'wp-travel-engine' ); ?></span>
				</div>
			<?php endif; ?>
			<?php
			$show_taxonomy_children = isset( $settings['show_taxonomy_children'] ) && 'yes' === $settings['show_taxonomy_children'];
			?>
			<div class="wpte-field wpte-checkbox advance-checkbox">
				<label class="wpte-field-label" for="show_taxonomy_children"><?php esc_html_e( 'Show Taxonomy children terms', 'wp-travel-engine' ); ?></label>
				<div class="wpte-checkbox-wrap">
					<input type="hidden" name="wp_travel_engine_settings[show_taxonomy_children]" value="no" >
					<input type="checkbox" id="show_taxonomy_children" class="" value="yes" name="wp_travel_engine_settings[show_taxonomy_children]"
					<?php
					checked( $show_taxonomy_children, true );
					?>
					/>
					<label for="show_taxonomy_children"></label>
				</div>
				<span class="wpte-tooltip"><?php esc_html_e( 'If checked, the terms with parent will be shown on the taxonomy archive page. This term children are not displayed in default.', 'wp-travel-engine' ); ?></span>
			</div>
			<?php
			$make_tabs_sticky = isset( $settings['wte_sticky_tabs'] ) || 'yes' === $settings['wte_sticky_tabs'];
			?>
			<div class="wpte-field wpte-checkbox advance-checkbox">
				<label class="wpte-field-label" data-wte-update="wte_new_5.5.0" for="wte_sticky_tabs"><?php esc_html_e( 'Make Tabs Sticky and Scrollable', 'wp-travel-engine' ); ?></label>
				<div class="wpte-checkbox-wrap">
					<input type="hidden" name="wp_travel_engine_settings[wte_sticky_tabs]" value="no" >
					<input type="checkbox" id="wte_sticky_tabs" class="" value="yes"
					name="wp_travel_engine_settings[wte_sticky_tabs]"
					<?php checked( $make_tabs_sticky, true ); ?>
					/>
					<label for="wte_sticky_tabs"></label>
				</div>
				<span class="wpte-tooltip"><?php esc_html_e( 'If checked, the trip content will be scrollable.', 'wp-travel-engine' ); ?></span>
			</div>
			<div class="wpte-field wpte-checkbox advance-checkbox">
				<label class="wpte-field-label" data-wte-update="wte_new_5.5.0" for="hide_term_description"><?php esc_html_e( 'Hide taxonomy term description', 'wp-travel-engine' ); ?></label>
				<div class="wpte-checkbox-wrap">
					<input type="hidden" name="wp_travel_engine_settings[hide_term_description]" value="no" >
					<?php $hide_description = isset( $settings['hide_term_description'] ) && 'yes' === $settings['hide_term_description']; ?>
					<input type="checkbox" id="hide_term_description" class="" value="yes"
					name="wp_travel_engine_settings[hide_term_description]"
					<?php checked( $hide_description, true ); ?>
					/>
					<label for="hide_term_description"></label>
				</div>
				<span class="wpte-tooltip"><?php esc_html_e( 'If checked, the taxonomy term description won\'t be displayed on archive pages.', 'wp-travel-engine' ); ?></span>
			</div>
			<?php
				$trip_duration_type    = array(
					'both'  => 'Days and Nights',
					'days'  => 'Days',
					'nights'=> 'Nights',
				);
				$set_duration_type = isset( $settings['set_duration_type'] ) ? $settings['set_duration_type'] : 'days';
				?>
				<div class="wpte-field wpte-select wpte-floated" data-set_duration_type>
				<label for="wpte_set_duration_type" class="wpte-field-label"><?php _e( "Trip Duration Type", 'wp-travel-engine' ); ?></label>
				<select name="wp_travel_engine_settings[set_duration_type]" id="wpte_set_duration_type" class="wpte-enhanced-select">
					<?php
					foreach ( $trip_duration_type as $key => $val ) :
						?>
						<option <?php selected( $set_duration_type, $key ); ?> value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $val ); ?></option>
					<?php
					endforeach;
					?>
				</select>
					<span class="wpte-tooltip"><?php esc_html_e( 'Choose the trip duration type to be displayed on the trip archive page.', 'wp-travel-engine' ); ?></span>
				</div>
		</div>
	</div>
</div>
<?php
