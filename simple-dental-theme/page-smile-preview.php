<?php
/**
 * Smile Preview landing page.
 *
 * AI image-editing preview, consent gate, goal selection,
 * and consultation lead form. Uploaded images are processed temporarily.
 */

if (!defined('ABSPATH')) {
    exit;
}

$smile_preview_contract = simple_dental_smile_preview_contract();
$smile_preview_goals = simple_dental_smile_preview_goals();
$t = function ($text, $context = '') {
    return function_exists('__t') ? __t($text, $context) : $text;
};

get_header();
?>

<main id="primary" class="site-main smile-preview-page">
    <section class="smile-hero section">
        <div class="container smile-hero__grid">
            <div class="smile-hero__content">
                <p class="eyebrow"><?php echo esc_html($t('AI Smile Preview')); ?></p>
                <h1><?php echo esc_html($t('See Your Future Smile in 60 Seconds')); ?></h1>
                <p class="lead"><?php echo esc_html($t('Upload a front-facing smile selfie with teeth visible, choose a cosmetic goal, and preview a non-clinical smile concept before booking a consultation with our Las Vegas cosmetic dentist.')); ?></p>
                <div class="smile-hero__actions">
                    <a class="btn btn-primary" href="#smile-preview-tool"><?php echo esc_html($t('Create My Smile Preview')); ?></a>
                    <a class="btn btn-secondary" href="tel:7023024787"><?php echo esc_html($t('Call (702) 302-4787')); ?></a>
                </div>
                <p class="smile-disclaimer"><?php echo esc_html($t('Visual concept only. Not dental advice, diagnosis, treatment planning, or a guarantee of results.')); ?></p>
            </div>
            <div class="smile-hero__card" aria-label="<?php echo esc_attr($t('How the smile preview works')); ?>">
                <p class="smile-hero__card-title"><?php echo esc_html($t('How it works')); ?></p>
                <ol>
                    <li><strong><?php echo esc_html($t('Share')); ?></strong><span><?php echo esc_html($t('Tell us who you are and what you want to improve.')); ?></span></li>
                    <li><strong><?php echo esc_html($t('Upload')); ?></strong><span><?php echo esc_html($t('Use a front-facing smile selfie with visible teeth and good lighting.')); ?></span></li>
                    <li><strong><?php echo esc_html($t('Preview')); ?></strong><span><?php echo esc_html($t('Review your concept and book a cosmetic dentistry consultation in Las Vegas.')); ?></span></li>
                </ol>
            </div>
        </div>
    </section>

    <section id="smile-preview-tool" class="section smile-tool-section">
        <div class="container">
            <div class="section-heading">
                <p class="eyebrow"><?php echo esc_html($t('Private smile preview')); ?></p>
                <h2><?php echo esc_html($t('Create your smile concept')); ?></h2>
                <p><?php echo esc_html($t('Your uploaded selfie is used temporarily to create a non-clinical concept preview. Images are not saved to your patient chart or kept on this site after the preview request is complete.')); ?></p>
            </div>

            <form class="smile-tool" id="smile-preview-form" novalidate>
                <div class="smile-step">
                    <h3><?php echo esc_html($t('1. Tell us where to send follow-up')); ?></h3>
                    <p><?php echo esc_html($t('Simple Dental LV may contact you about your smile preview and consultation request.')); ?></p>
                    <div class="smile-lead-fields smile-intake-fields">
                        <label>
                            <span><?php echo esc_html($t('Name')); ?> <em><?php echo esc_html($t('required')); ?></em></span>
                            <input id="smile-name" name="name" type="text" autocomplete="name" required>
                        </label>
                        <label>
                            <span><?php echo esc_html($t('Email')); ?> <em><?php echo esc_html($t('required')); ?></em></span>
                            <input id="smile-email" name="email" type="email" autocomplete="email" required>
                        </label>
                        <label>
                            <span><?php echo esc_html($t('Phone')); ?> <em><?php echo esc_html($t('optional')); ?></em></span>
                            <input id="smile-phone" name="phone" type="tel" autocomplete="tel" placeholder="<?php echo esc_attr($t('Best phone number')); ?>">
                        </label>
                    </div>
                    <p class="smile-error" id="smile-contact-error" role="alert"></p>
                </div>

                <div class="smile-step">
                    <h3><?php echo esc_html($t('2. Upload a teeth-visible smile selfie')); ?></h3>
                    <p><?php echo esc_html($t('Required for best results: face camera directly, teeth visible, no sunglasses, good lighting. Closed-mouth photos may not produce a useful preview.')); ?></p>
                    <label class="smile-upload" for="smile-photo">
                        <span class="smile-upload__icon" aria-hidden="true">📷</span>
                        <img class="smile-upload__preview" id="smile-upload-preview" alt="<?php echo esc_attr($t('Selected smile selfie preview')); ?>" hidden>
                        <span class="smile-upload__title"><?php echo esc_html($smile_preview_contract['messages']['choosePhoto']); ?></span>
                        <span class="smile-upload__hint"><?php echo esc_html($smile_preview_contract['uploadHint']); ?></span>
                    </label>
                    <input id="smile-photo" name="smile-photo" type="file" accept="<?php echo esc_attr($smile_preview_contract['acceptedFileTypes']); ?>" required>
                    <p class="smile-error" id="smile-photo-error" role="alert"></p>
                </div>

                <div class="smile-step">
                    <h3><?php echo esc_html($t('3. Choose what you want to improve')); ?></h3>
                    <div class="smile-goals" role="group" aria-label="<?php echo esc_attr($t('Smile improvement goals')); ?>">
                        <?php foreach ($smile_preview_goals as $goal) : ?>
                            <label><input type="checkbox" name="<?php echo esc_attr($smile_preview_contract['goalInputName']); ?>" value="<?php echo esc_attr($goal['id']); ?>"> <?php echo esc_html($goal['label']); ?></label>
                        <?php endforeach; ?>
                    </div>
                    <label class="smile-notes" for="smile-improvement-notes">
                        <span><?php echo esc_html($t('Anything else you want to improve?')); ?> <em><?php echo esc_html($t('optional')); ?></em></span>
                        <textarea id="smile-improvement-notes" name="improvement_notes" rows="3" placeholder="<?php echo esc_attr($t('Tell us in your own words.')); ?>"></textarea>
                    </label>
                    <p class="smile-error" id="smile-goal-error" role="alert"></p>
                </div>

                <div class="smile-step smile-consent-box">
                    <label>
                        <input id="smile-consent" name="smile-consent" type="checkbox" required>
                        <?php echo esc_html($smile_preview_contract['consentText']); ?>
                    </label>
                    <p class="smile-error" id="smile-consent-error" role="alert"></p>
                </div>

                <input type="hidden" name="smile_check" value="7">
                <input class="smile-honeypot" name="website" type="text" tabindex="-1" autocomplete="off" aria-hidden="true">
                <input id="smile-utm-source" name="utm_source" type="hidden">
                <input id="smile-utm-medium" name="utm_medium" type="hidden">
                <input id="smile-utm-campaign" name="utm_campaign" type="hidden">
                <input id="smile-utm-content" name="utm_content" type="hidden">
                <input id="smile-utm-term" name="utm_term" type="hidden">

                <?php if (function_exists('simple_dental_has_captcha_field') && simple_dental_has_captcha_field()) : ?>
                <div class="smile-step captcha-row">
                    <?php simple_dental_render_captcha_field(); ?>
                </div>
                <?php endif; ?>

                <button class="btn btn-primary smile-generate" type="submit"><?php echo esc_html($smile_preview_contract['messages']['generateLabel']); ?></button>
            </form>

            <div class="smile-loading-modal" id="smile-loading-modal" role="status" aria-live="polite" aria-hidden="true" hidden>
                <div class="smile-loading-modal__card">
                    <div class="smile-loading-modal__spinner" aria-hidden="true"></div>
                    <h3><?php echo esc_html($t('Creating your smile preview')); ?></h3>
                    <p><?php echo esc_html($t('This can take up to a minute. Please keep this page open and avoid clicking back or refreshing.')); ?></p>
                </div>
            </div>

            <div class="smile-results" id="smile-results" hidden>
                <div class="section-heading">
                    <p class="eyebrow"><?php echo esc_html($t('Your concept preview')); ?></p>
                    <h2><?php echo esc_html($t('Before / after concept')); ?></h2>
                    <p id="smile-selected-goals"></p>
                </div>
                <div class="smile-comparison">
                    <figure>
                        <img id="smile-before-image" alt="<?php echo esc_attr($t('Original uploaded smile selfie preview')); ?>">
                        <figcaption><?php echo esc_html($t('Original')); ?></figcaption>
                    </figure>
                    <figure class="smile-after-frame">
                        <img id="smile-after-image" alt="<?php echo esc_attr($t('AI smile concept preview')); ?>">
                        <span class="smile-after-badge"><?php echo esc_html($t('AI concept')); ?></span>
                        <figcaption><?php echo esc_html($t('Smile concept')); ?></figcaption>
                    </figure>
                </div>
                <p class="smile-disclaimer"><?php echo esc_html($t('This is an AI-generated visual concept only. Actual treatment options require an in-person exam, x-rays when appropriate, and dentist evaluation.')); ?></p>

                <div class="smile-lead-card">
                    <h3><?php echo esc_html($t('Like the direction? Let’s see what’s actually possible.')); ?></h3>
                    <p><?php echo esc_html($t('No obligation. Call Simple Dental LV or request an appointment when you are ready to review what is actually possible.')); ?></p>
                    <div class="smile-hero__actions smile-lead-actions">
                        <a class="btn btn-primary" href="<?php echo esc_url(simple_dental_with_lang(home_url('/contact/'))); ?>"><?php echo esc_html($t('Book Consultation')); ?></a>
                        <a class="btn btn-secondary" href="tel:7023024787"><?php echo esc_html($t('Or call Simple Dental at (702) 302-4787')); ?></a>
                    </div>
                    <p class="form-note"><small><?php echo esc_html($t('We respect your privacy. Uploaded images are processed temporarily for AI generation and are not retained by this site.')); ?></small></p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
