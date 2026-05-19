<?php
/**
 * Google Reviews / Testimonials data and render helpers.
 *
 * Real Google review text should be copied from the Simple Dental Google
 * Business Profile into simple_dental_get_google_reviews(). Do not invent
 * patient reviews.
 */
function simple_dental_get_google_reviews_meta() {
    return array(
        'rating' => '5.0',
        'review_count' => '13',
        'google_url' => 'https://maps.app.goo.gl/aEKiZbNFp7SJFG11A',
        'last_updated' => 'May 2026',
    );
}

function simple_dental_get_google_reviews() {
    return array(
        array(
            'name' => 'Alan Wang',
            'initials' => 'AW',
            'rating' => 5,
            'date' => '4 weeks ago',
            'featured' => false,
            'text' => 'Simple Dental LV 超出了我的預期。從走進診所的那一刻起，工作人員就非常貼心又友善。醫師潔牙的技術很好，手法溫柔但非常仔細，也會清楚解釋每個步驟。診所環境乾淨、現代、井然有序。這是我做過最好的潔牙體驗之一，很高興找到一家值得信賴的牙科診所。',
        ),
        array(
            'name' => 'Robert Wu',
            'initials' => 'RW',
            'rating' => 5,
            'date' => 'a week ago',
            'featured' => true,
            'text' => 'Dr Chang is super friendly!! He calms me down when I feel very nervous and makes a crown for me works very well. Very good experience, highly recommend.',
        ),
        array(
            'name' => 'Vivian',
            'initials' => 'V',
            'rating' => 5,
            'date' => 'a week ago',
            'featured' => true,
            'text' => 'Highly recommend this dental office! The clinic is beautiful, clean, and welcoming. The staff are friendly, professional, and made the whole experience very comfortable. Dr. Chang is very professional, and you can really feel the care and attention they give to their patients.',
        ),
        array(
            'name' => 'J L',
            'initials' => 'JL',
            'rating' => 5,
            'date' => '2 weeks ago',
            'featured' => true,
            'text' => 'Really happy with my experience here. The clinic feels clean and up-to-date, and everything was handled smoothly. Dr. Chang was patient, friendly, and took the time to explain things clearly, which I appreciated. The staff made the visit easy, and the location is very convenient. I’d come back and recommend it to others.',
        ),
        array(
            'name' => 'Anna Sun',
            'initials' => 'AS',
            'rating' => 5,
            'date' => '2 weeks ago',
            'featured' => false,
            'text' => 'I had an excellent experience at this dental clinic. The facility is equipped with modern, state-of-the-art technology, which made the entire process smooth and efficient. The dentist was not only highly skilled but also incredibly friendly and patient, taking the time to explain everything clearly. The staff created a warm and welcoming atmosphere, and the clinic itself is clean, comfortable, and thoughtfully designed. Another big plus is the convenient location—it’s very easy to access. I would highly recommend this clinic to anyone looking for quality dental care.',
        ),
        array(
            'name' => 'Ashley Yu',
            'initials' => 'AY',
            'rating' => 5,
            'date' => 'a month ago',
            'featured' => false,
            'text' => 'I had a really lovely experience at Dr. Chang’s office. From the moment I walked in, the clinic felt fresh, bright, and very clean. The space has a simple and welcoming feel that made me feel comfortable right away. Dr. Chang made the whole visit feel calm and reassuring. He was caring, patient, and very skilled, which helped me feel comfortable throughout the entire appointment. I especially appreciated how he checked in during the visit to make sure I was doing okay and felt at ease. What also stood out to me was his honesty. He explained things clearly and never made me feel pushed toward treatments that were not truly needed. That kind of sincerity and openness means a lot to me when choosing a dentist. The office is modern, thoughtfully arranged, and everything felt well managed from beginning to end. Overall, it was such a smooth and positive experience. I would absolutely recommend Dr. Chang to anyone looking for a dentist who is trustworthy, attentive, and provides excellent care.',
        ),
        array(
            'name' => 'Google reviewer',
            'initials' => 'G',
            'rating' => 5,
            'date' => 'a month ago',
            'featured' => false,
            'text' => 'We had a wonderful experience at this dental office! Dr. Chang did an amazing job cleaning my son’s teeth — he was incredibly thorough, and he felt absolutely no pain during the entire process. The staff was very professional and made us feel comfortable from start to finish. The clinic itself was also very clean and well-maintained, which made the visit even more pleasant. Highly recommend to any one looking for a great pediatric dental experience!',
        ),
    );
}

function simple_dental_get_featured_google_reviews($limit = 3) {
    $featured = array();
    $reviews = simple_dental_get_google_reviews();

    foreach ($reviews as $review) {
        if (!empty($review['featured'])) {
            $featured[] = $review;
        }
    }

    if (empty($featured)) {
        $featured = $reviews;
    }

    return array_slice($featured, 0, absint($limit));
}

function simple_dental_render_review_stars($rating) {
    $rating = max(0, min(5, (int) $rating));
    $stars = str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);

    return '<span class="review-stars" role="img" aria-label="' . esc_attr(sprintf(__t('%d out of 5 stars'), $rating)) . '">' . esc_html($stars) . '</span>';
}

function simple_dental_get_review_excerpt($text, $word_limit = 34) {
    $text = trim((string) $text);
    if ($text === '') {
        return '';
    }

    $words = preg_split('/\s+/u', $text);
    if (count($words) <= $word_limit) {
        return $text;
    }

    return implode(' ', array_slice($words, 0, $word_limit)) . '…';
}

function simple_dental_render_google_review_card($review, $is_featured = false, $compact = false) {
    $name = isset($review['name']) ? $review['name'] : __t('Google reviewer');
    $initials = !empty($review['initials']) ? $review['initials'] : strtoupper(substr($name, 0, 1));
    $rating = isset($review['rating']) ? (int) $review['rating'] : 5;
    $date = isset($review['date']) ? $review['date'] : '';
    $text = isset($review['text']) ? $review['text'] : '';
    if ($compact) {
        $text = simple_dental_get_review_excerpt($text, 30);
    }
    $class = $is_featured ? ' review-card-featured' : '';

    ob_start();
    ?>
    <article class="review-card<?php echo esc_attr($class); ?>">
        <div class="review-card-header">
            <div class="review-avatar" aria-hidden="true"><?php echo esc_html($initials); ?></div>
            <div>
                <h3 class="reviewer-name"><?php echo esc_html($name); ?></h3>
                <p class="review-source"><?php echo esc_html(__t('Google review')); ?><?php echo $date ? ' · ' . esc_html($date) : ''; ?></p>
            </div>
        </div>
        <?php echo simple_dental_render_review_stars($rating); ?>
        <blockquote class="review-text">
            <p><?php echo esc_html($text); ?></p>
        </blockquote>
    </article>
    <?php
    return ob_get_clean();
}

function simple_dental_render_reviews_empty_state() {
    ob_start();
    ?>
    <div class="reviews-empty-state">
        <p><strong><?php echo esc_html(__t('Google reviews are being added here soon.')); ?></strong></p>
        <p><?php echo esc_html(__t('This section is ready for real patient reviews copied from the Simple Dental Google Business Profile.')); ?></p>
    </div>
    <?php
    return ob_get_clean();
}

function simple_dental_render_google_reviews_home_section() {
    $meta = simple_dental_get_google_reviews_meta();
    $reviews = simple_dental_get_featured_google_reviews(3);
    $testimonials_url = simple_dental_with_lang(home_url(simple_dental_get_testimonials_path()));
    $google_url = !empty($meta['google_url']) ? $meta['google_url'] : '';

    ob_start();
    ?>
    <section class="section reviews-home-section" id="patient-reviews">
        <div class="container">
            <div class="reviews-home-layout">
                <div class="reviews-home-intro">
                    <p class="section-eyebrow"><?php echo esc_html(__t('Patient Reviews')); ?></p>
                    <h2><?php echo esc_html(__t('What Patients Are Saying About Simple Dental')); ?></h2>
                    <p><?php echo esc_html(__t('See why patients appreciate honest, no-pressure dental care from one experienced Las Vegas dentist.')); ?></p>
                    <div class="google-rating-badge" aria-label="<?php echo esc_attr(__t('Google reviews summary')); ?>">
                        <span class="google-wordmark">Google</span>
                        <?php if (!empty($meta['rating'])) : ?>
                            <strong><?php echo esc_html($meta['rating']); ?></strong>
                            <?php echo simple_dental_render_review_stars((int) round((float) $meta['rating'])); ?>
                        <?php else : ?>
                            <strong><?php echo esc_html(__t('Reviews coming soon')); ?></strong>
                        <?php endif; ?>
                        <?php if (!empty($meta['review_count'])) : ?>
                            <span><?php echo esc_html(sprintf(__t('Based on %s Google reviews'), $meta['review_count'])); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="review-section-actions">
                        <a href="<?php echo esc_url($testimonials_url); ?>" class="btn btn-primary"><?php echo esc_html(__t('Read Patient Reviews')); ?></a>
                        <?php if ($google_url) : ?>
                            <a href="<?php echo esc_url($google_url); ?>" class="btn btn-secondary" target="_blank" rel="noopener noreferrer"><?php echo esc_html(__t('View on Google')); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="reviews-card-grid reviews-home-cards">
                    <?php
                    if (!empty($reviews)) {
                        foreach ($reviews as $review) {
                            echo simple_dental_render_google_review_card($review, true, true);
                        }
                    } else {
                        echo simple_dental_render_reviews_empty_state();
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}

