<?php
/**
 * Shared service catalog used across homepage and services page.
 */
function simple_dental_get_service_catalog() {
    return array(
        'existing_patient_exam' => array(
            'name' => 'Existing Patient Exam and X-rays',
            'name_key' => 'services.preventive.existing_patient_exam.name',
            'price' => '$99',
            'description' => 'Comprehensive exam with digital X-rays for existing patients.',
            'description_key' => 'services.preventive.existing_patient_exam.description',
        ),
        'adult_cleaning' => array(
            'name' => 'Adult Cleaning',
            'name_key' => 'services.preventive.adult_cleaning.name',
            'price' => '$150',
            'description' => 'Professional teeth cleaning and polishing',
            'description_key' => 'services.preventive.adult_cleaning.description',
        ),
        'deep_cleaning' => array(
            'name' => 'Deep Cleaning (per quadrant)',
            'name_key' => 'services.preventive.deep_cleaning.name',
            'price' => '$225',
            'description' => 'Deep scaling and root planing treatment',
            'description_key' => 'services.preventive.deep_cleaning.description',
        ),
        'fluoride_treatment' => array(
            'name' => 'Fluoride Treatment',
            'name_key' => 'services.preventive.fluoride_treatment.name',
            'price' => '$39',
            'description' => 'Professional fluoride application for cavity prevention',
            'description_key' => 'services.preventive.fluoride_treatment.description',
        ),
        'tooth_colored_filling' => array(
            'name' => 'Tooth-Colored Filling',
            'name_key' => 'services.restorative.tooth_colored_filling.name',
            'price' => '$180-250',
            'description' => 'Composite fillings depending on surfaces treated',
            'description_key' => 'services.restorative.tooth_colored_filling.description',
        ),
        'same_day_crown' => array(
            'name' => 'Same-Day Crown (Ceramic)',
            'name_key' => 'services.restorative.same_day_crown.name',
            'price' => '$899',
            'description' => 'Complete crown restoration in one visit',
            'description_key' => 'services.restorative.same_day_crown.description',
        ),
        'core_buildup' => array(
            'name' => 'Core Buildup (if needed)',
            'name_key' => 'services.restorative.core_buildup.name',
            'price' => '$150',
            'description' => 'Foundation preparation for crown placement',
            'description_key' => 'services.restorative.core_buildup.description',
        ),
        'simple_extraction' => array(
            'name' => 'Simple Extraction',
            'name_key' => 'services.extraction.simple_extraction.name',
            'price' => '$180',
            'description' => 'Routine tooth removal procedure',
            'description_key' => 'services.extraction.simple_extraction.description',
        ),
        'surgical_extraction' => array(
            'name' => 'Surgical Extraction',
            'name_key' => 'services.extraction.surgical_extraction.name',
            'price' => '$280',
            'description' => 'Complex tooth removal requiring surgical technique',
            'description_key' => 'services.extraction.surgical_extraction.description',
        ),
        'front_tooth_root_canal' => array(
            'name' => 'Front Tooth Root Canal',
            'name_key' => 'services.endodontics.front_tooth.name',
            'price' => '$650',
            'description' => 'Root canal therapy for anterior teeth',
            'description_key' => 'services.endodontics.front_tooth.description',
        ),
        'premolar_root_canal' => array(
            'name' => 'Premolar Root Canal',
            'name_key' => 'services.endodontics.premolar.name',
            'price' => '$800',
            'description' => 'Root canal therapy for bicuspid teeth',
            'description_key' => 'services.endodontics.premolar.description',
        ),
        'molar_root_canal' => array(
            'name' => 'Molar Root Canal',
            'name_key' => 'services.endodontics.molar.name',
            'price' => '$1000',
            'description' => 'Root canal therapy for back teeth',
            'description_key' => 'services.endodontics.molar.description',
        ),
        'full_denture' => array(
            'name' => 'Full Denture (per arch)',
            'name_key' => 'services.prosthetics.full_denture.name',
            'price' => '$2000',
            'description' => 'Complete denture for upper or lower jaw',
            'description_key' => 'services.prosthetics.full_denture.description',
        ),
        'partial_denture' => array(
            'name' => 'Partial Denture',
            'name_key' => 'services.prosthetics.partial_denture.name',
            'price' => '$1600',
            'description' => 'Removable partial denture to replace missing teeth',
            'description_key' => 'services.prosthetics.partial_denture.description',
        ),
        'denture_reline' => array(
            'name' => 'Denture Reline',
            'name_key' => 'services.prosthetics.denture_reline.name',
            'price' => '$250',
            'description' => 'Adjusting denture fit for comfort',
            'description_key' => 'services.prosthetics.denture_reline.description',
        ),
        'night_guard' => array(
            'name' => 'Night Guard',
            'name_key' => 'services.other.night_guard.name',
            'price' => '$365',
            'description' => 'Custom-made night guard for teeth grinding protection',
            'description_key' => 'services.other.night_guard.description',
        ),
        'retainers' => array(
            'name' => 'Retainers (per arch)',
            'name_key' => 'services.other.retainers.name',
            'price' => '$200',
            'description' => 'Custom retainers for maintaining tooth position',
            'description_key' => 'services.other.retainers.description',
        ),
    );
}

/**
 * Get comprehensive service data.
 */
function get_dental_services_data() {
    return array(
        'preventive' => array(
            'title' => 'Preventive & Diagnostic',
            'title_key' => 'services.category.preventive',
            'service_ids' => array('existing_patient_exam', 'adult_cleaning', 'deep_cleaning', 'fluoride_treatment'),
        ),
        'restorative' => array(
            'title' => 'Restorative Dentistry',
            'title_key' => 'services.category.restorative',
            'service_ids' => array('tooth_colored_filling', 'same_day_crown', 'core_buildup'),
        ),
        'extraction' => array(
            'title' => 'Tooth Removal',
            'title_key' => 'services.category.extraction',
            'service_ids' => array('simple_extraction', 'surgical_extraction'),
        ),
        'endodontics' => array(
            'title' => 'Root Canals',
            'title_key' => 'services.category.endodontics',
            'service_ids' => array('front_tooth_root_canal', 'premolar_root_canal', 'molar_root_canal'),
        ),
        'prosthetics' => array(
            'title' => 'Dentures & Partials',
            'title_key' => 'services.category.prosthetics',
            'service_ids' => array('full_denture', 'partial_denture', 'denture_reline'),
        ),
        'other' => array(
            'title' => 'Other Services',
            'title_key' => 'services.category.other',
            'service_ids' => array('night_guard', 'retainers'),
        ),
    );
}

/**
 * Featured services for homepage (top 6)
 */
function featured_services_display($atts) {
    $catalog = simple_dental_get_service_catalog();
    $featured_ids = array(
        'existing_patient_exam',
        'adult_cleaning',
        'tooth_colored_filling',
        'same_day_crown',
        'simple_extraction',
        'front_tooth_root_canal',
    );

    ob_start();
    echo '<div class="services-grid">';
    foreach ($featured_ids as $service_id) {
        if (empty($catalog[$service_id])) {
            continue;
        }

        $service = $catalog[$service_id];
        echo '<div class="service-card">';
        echo '<h3 class="service-title">' . esc_html(simple_dental_translate_structured_text($service, 'name')) . '</h3>';
        echo '<div class="service-price">' . esc_html($service['price']) . '</div>';
        echo '<p class="service-description">' . esc_html(simple_dental_translate_structured_text($service, 'description')) . '</p>';
        echo '</div>';
    }
    echo '</div>';
    return ob_get_clean();
}
add_shortcode('featured_services', 'featured_services_display');

/**
 * New Patient Special callout
 */
function new_patient_special_display($atts) {
    $booking_url = simple_dental_get_booking_url();
    ob_start();
    ?>
    <div class="new-patient-special">
        <h3><?php echo __t('Opening Promotion', 'key:promo.new_patient.heading'); ?></h3>
        <div class="special-offers">
            <article class="special-offer-card special-offer-card--starter">
                <h4><?php echo __t('New Patient Exam + X-rays', 'key:promo.new_patient.exam.name'); ?></h4>
                <div class="special-price">$59</div>
                <p><?php echo __t('A simple first-visit exam with digital X-rays for new patients.', 'key:promo.new_patient.exam.description'); ?></p>
            </article>
            <article class="special-offer-card special-offer-card--featured">
                <h4><?php echo __t('New Patient Special', 'key:promo.new_patient.special.name'); ?></h4>
                <div class="special-price">$199</div>
                <ul class="special-offer-list">
                    <li><?php echo __t('Comprehensive exam', 'key:promo.new_patient.special.includes.exam'); ?></li>
                    <li><?php echo __t('Digital X-rays', 'key:promo.new_patient.special.includes.xrays'); ?></li>
                    <li><?php echo __t('Regular cleaning', 'key:promo.new_patient.special.includes.cleaning'); ?></li>
                    <li><?php echo __t('Complimentary digital 3D scan', 'key:promo.new_patient.special.includes.scan'); ?></li>
                </ul>
            </article>
        </div>
        <div class="special-features">
            <span class="feature">✓ <?php echo __t('Call or book online to schedule', 'key:promo.new_patient.cta.note'); ?></span>
        </div>
        <a href="tel:7023024787" class="btn btn-coral"><?php echo __t('Call for New Patient Visit', 'key:promo.new_patient.cta.call'); ?></a>
        <p class="special-secondary-cta"><?php echo wp_kses_post(sprintf(__t('Prefer online booking? %s', 'key:promo.new_patient.cta.online'), '<a href="' . esc_url($booking_url) . '">' . esc_html(__t('Book online')) . '</a>')); ?></p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('new_patient_special', 'new_patient_special_display');

/**
 * Services by category for full services page
 */
function services_by_category_display($atts) {
    $catalog = simple_dental_get_service_catalog();
    $services_data = get_dental_services_data();
    
    ob_start();
    echo '<div class="services-by-category">';
    
    foreach ($services_data as $category_key => $category) {
        echo '<div class="service-category" data-category="' . esc_attr($category_key) . '">';
        echo '<h3 class="category-title">' . esc_html(simple_dental_translate_structured_text($category, 'title')) . '</h3>';
        echo '<div class="services-grid category-grid">';
        
        foreach ($category['service_ids'] as $service_id) {
            if (empty($catalog[$service_id])) {
                continue;
            }

            $service = $catalog[$service_id];
            echo '<div class="service-card category-card">';
            echo '<h4 class="service-title">' . esc_html(simple_dental_translate_structured_text($service, 'name')) . '</h4>';
            echo '<div class="service-price">' . esc_html($service['price']) . '</div>';
            echo '<p class="service-description">' . esc_html(simple_dental_translate_structured_text($service, 'description')) . '</p>';
            echo '</div>';
        }
        
        echo '</div>';
        echo '</div>';
    }
    
    echo '</div>';
    return ob_get_clean();
}
add_shortcode('services_by_category', 'services_by_category_display');

/**
 * Legacy services display shortcode (for backward compatibility)
 */
function simple_dental_services_display($atts) {
    // Use featured services for existing shortcode
    return featured_services_display($atts);
}
add_shortcode('simple_dental_services', 'simple_dental_services_display');

