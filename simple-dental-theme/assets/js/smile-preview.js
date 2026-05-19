(function () {
    'use strict';

    const config = window.simpleDentalSmilePreview || {};
    const contractMessages = config.messages || {};
    const MAX_FILE_SIZE = Number(config.maxFileSize || (8 * 1024 * 1024));
    const ALLOWED_TYPES = Array.isArray(config.allowedMimeTypes) ? config.allowedMimeTypes : ['image/jpeg', 'image/png', 'image/webp'];
    const GOALS = Array.isArray(config.goals) ? config.goals : [];
    const MAX_CANVAS_EDGE = 768;
    const PREVIEW_STATES = Object.freeze({
        IDLE: 'idle',
        VALIDATING: 'validating',
        GENERATING: 'generating',
        FALLBACK: 'fallback',
        RESULT: 'result',
        ERROR: 'error'
    });
    let previewState = PREVIEW_STATES.IDLE;

    function message(key, fallback) {
        return contractMessages[key] || fallback;
    }

    function goalLabel(value) {
        const goal = GOALS.find((item) => item.id === value || item.prompt === value || item.label === value);
        return goal ? goal.label : value;
    }

    function setText(id, message) {
        const el = document.getElementById(id);
        if (el) {
            el.textContent = message || '';
        }
    }

    function clearErrors() {
        setText('smile-photo-error', '');
        setText('smile-goal-error', '');
        setText('smile-consent-error', '');
    }

    function selectedGoals(form) {
        const inputName = config.goalInputName || 'smile-goal';
        return Array.from(form.querySelectorAll(`input[name="${inputName}"]:checked`)).map((input) => input.value);
    }

    function selectedGoalLabels(form) {
        return selectedGoals(form).map(goalLabel);
    }

    function getCaptchaResponse(form) {
        const fieldResponse = form ? form.querySelector('[name="g-recaptcha-response"]') : null;
        if (fieldResponse && fieldResponse.value) {
            return fieldResponse.value;
        }

        if (typeof grecaptcha === 'undefined' || typeof grecaptcha.getResponse !== 'function') {
            return '';
        }

        return grecaptcha.getResponse() || '';
    }

    function validate(form, file) {
        let valid = true;
        clearErrors();

        if (!file) {
            setText('smile-photo-error', message('missingPhoto', 'Please choose a smile selfie first.'));
            valid = false;
        } else if (!ALLOWED_TYPES.includes(file.type)) {
            setText('smile-photo-error', message('invalidType', 'Please upload a JPG, PNG, or WebP image.'));
            valid = false;
        } else if (file.size > MAX_FILE_SIZE) {
            setText('smile-photo-error', message('tooLarge', 'Please choose an image smaller than 8 MB.'));
            valid = false;
        }

        if (selectedGoals(form).length === 0) {
            setText('smile-goal-error', message('missingGoal', 'Choose at least one smile goal.'));
            valid = false;
        }

        const consent = document.getElementById('smile-consent');
        if (!consent || !consent.checked) {
            setText('smile-consent-error', message('missingConsent', 'Consent is required before generating a preview.'));
            valid = false;
        }

        if (form.querySelector('.g-recaptcha, .c4wp_captcha_field, .simple-dental-recaptcha-v3') && !getCaptchaResponse(form)) {
            setText('smile-consent-error', message('missingCaptcha', 'Please complete the CAPTCHA before generating your preview.'));
            valid = false;
        }

        return valid;
    }

    function clamp(value, min, max) {
        return Math.max(min, Math.min(max, value));
    }

    function loadImage(dataUrl) {
        return new Promise((resolve, reject) => {
            const image = new Image();
            image.onload = () => resolve(image);
            image.onerror = () => reject(new Error(message('imageProcessFailed', 'Could not process this image. Please try another photo.')));
            image.src = dataUrl;
        });
    }

    function getGoalSettings(goals) {
        const text = goals.join(' ').toLowerCase();
        const settings = {
            whiten: 0.16,
            straighten: 0,
            veneer: 0,
            gap: 0,
            chip: 0,
            subtle: text.includes('natural subtle') ? 1 : 0,
            hollywood: text.includes('hollywood') ? 1 : 0
        };

        if (text.includes('whiter')) settings.whiten += 0.18;
        if (text.includes('straighter')) settings.straighten = 1;
        if (text.includes('gap')) settings.gap = 1;
        if (text.includes('veneer')) settings.veneer = 1;
        if (text.includes('chipped') || text.includes('uneven')) settings.chip = 1;
        if (settings.hollywood) settings.whiten += 0.24;
        if (settings.veneer) settings.whiten += 0.16;
        if (settings.subtle) settings.whiten *= 0.55;

        settings.whiten = clamp(settings.whiten, 0.08, 0.55);
        return settings;
    }

    function drawSmileMask(ctx, width, height, settings) {
        const centerX = width / 2;
        const centerY = height * 0.57;
        const radiusX = width * 0.19;
        const radiusY = height * 0.055;

        ctx.save();
        ctx.globalCompositeOperation = 'soft-light';
        ctx.fillStyle = `rgba(255,255,255,${0.22 + settings.whiten * 0.35})`;
        ctx.beginPath();
        ctx.ellipse(centerX, centerY, radiusX, radiusY, 0, 0, Math.PI * 2);
        ctx.fill();

        if (settings.straighten || settings.veneer || settings.gap || settings.chip || settings.hollywood) {
            const toothCount = settings.veneer || settings.hollywood ? 8 : 6;
            const totalWidth = radiusX * (settings.veneer ? 1.42 : 1.22);
            const toothWidth = totalWidth / toothCount;
            const toothHeight = radiusY * (settings.veneer || settings.hollywood ? 1.15 : 0.88);
            const startX = centerX - totalWidth / 2;
            ctx.globalCompositeOperation = 'screen';

            for (let i = 0; i < toothCount; i += 1) {
                const x = startX + i * toothWidth + toothWidth * 0.08;
                const y = centerY - toothHeight / 2 + (settings.straighten || settings.veneer ? 0 : (i % 2 ? 1.5 : -1.5));
                const radius = settings.veneer || settings.hollywood ? 6 : 4;
                ctx.fillStyle = `rgba(255,255,245,${0.08 + settings.whiten * 0.16})`;
                roundRect(ctx, x, y, toothWidth * 0.84, toothHeight, radius);
                ctx.fill();
            }
        }

        ctx.globalCompositeOperation = 'source-over';
        ctx.strokeStyle = `rgba(255,255,255,${settings.subtle ? 0.14 : 0.24})`;
        ctx.lineWidth = Math.max(1, width * 0.002);
        ctx.beginPath();
        ctx.ellipse(centerX, centerY, radiusX * 0.92, radiusY * 0.72, 0, 0, Math.PI * 2);
        ctx.stroke();
        ctx.restore();
    }

    function roundRect(ctx, x, y, width, height, radius) {
        const r = Math.min(radius, width / 2, height / 2);
        ctx.beginPath();
        ctx.moveTo(x + r, y);
        ctx.arcTo(x + width, y, x + width, y + height, r);
        ctx.arcTo(x + width, y + height, x, y + height, r);
        ctx.arcTo(x, y + height, x, y, r);
        ctx.arcTo(x, y, x + width, y, r);
        ctx.closePath();
    }

    function processPixels(ctx, width, height, settings) {
        const imageData = ctx.getImageData(0, 0, width, height);
        const data = imageData.data;
        const centerX = width / 2;
        const centerY = height * 0.57;
        const radiusX = width * 0.23;
        const radiusY = height * 0.085;

        for (let y = 0; y < height; y += 1) {
            for (let x = 0; x < width; x += 1) {
                const idx = (y * width + x) * 4;
                const dx = (x - centerX) / radiusX;
                const dy = (y - centerY) / radiusY;
                const mask = clamp(1 - (dx * dx + dy * dy), 0, 1);

                if (mask <= 0) continue;

                const r = data[idx];
                const g = data[idx + 1];
                const b = data[idx + 2];
                const brightness = (r + g + b) / 3;
                const toothLike = brightness > 92 && r > 70 && g > 62 && b > 48 ? 1 : 0.35;
                const strength = mask * settings.whiten * toothLike;
                const warmthFix = strength * (settings.hollywood || settings.veneer ? 34 : 22);
                const lift = strength * (settings.hollywood ? 64 : 46);

                data[idx] = clamp(r + lift - warmthFix * 0.1, 0, 255);
                data[idx + 1] = clamp(g + lift - warmthFix * 0.35, 0, 255);
                data[idx + 2] = clamp(b + lift + warmthFix * 0.65, 0, 255);
            }
        }

        ctx.putImageData(imageData, 0, 0);
    }

    async function createSmileConcept(dataUrl, goals) {
        const image = await loadImage(dataUrl);
        const scale = Math.min(1, MAX_CANVAS_EDGE / Math.max(image.naturalWidth, image.naturalHeight));
        const width = Math.max(1, Math.round(image.naturalWidth * scale));
        const height = Math.max(1, Math.round(image.naturalHeight * scale));
        const settings = getGoalSettings(goals);
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d', { willReadFrequently: true });

        canvas.width = width;
        canvas.height = height;
        ctx.drawImage(image, 0, 0, width, height);
        processPixels(ctx, width, height, settings);

        return canvas.toDataURL('image/jpeg', 0.9);
    }

    async function createAiUploadFile(dataUrl, originalName) {
        const image = await loadImage(dataUrl);
        const scale = Math.min(1, MAX_CANVAS_EDGE / Math.max(image.naturalWidth, image.naturalHeight));
        const width = Math.max(1, Math.round(image.naturalWidth * scale));
        const height = Math.max(1, Math.round(image.naturalHeight * scale));
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        canvas.width = width;
        canvas.height = height;
        ctx.drawImage(image, 0, 0, width, height);

        const blob = await new Promise((resolve, reject) => {
            canvas.toBlob((result) => {
                if (result) resolve(result);
                else reject(new Error(message('imagePrepareFailed', 'Could not prepare this image for AI generation.')));
            }, 'image/jpeg', 0.86);
        });
        const defaultFileName = message('defaultFileName', 'smile-selfie');
        const safeBase = (originalName || defaultFileName).replace(/\.[^.]+$/, '').replace(/[^a-z0-9_-]+/gi, '-').replace(/^-+|-+$/g, '') || defaultFileName;
        return new File([blob], safeBase + '.jpg', { type: 'image/jpeg' });
    }

    let latestGoals = [];

    function renderResult(form, originalDataUrl, conceptDataUrl) {
        const before = document.getElementById('smile-before-image');
        const after = document.getElementById('smile-after-image');
        const results = document.getElementById('smile-results');
        const goalsText = document.getElementById('smile-selected-goals');
        const goals = selectedGoals(form);
        const labels = selectedGoalLabels(form);
        latestGoals = labels;

        if (!before || !after || !results) {
            return;
        }

        before.src = originalDataUrl;
        after.src = conceptDataUrl;
        after.dataset.generated = 'local-canvas-goal-based';
        if (goalsText) {
            goalsText.textContent = message(labels.length > 1 ? 'selectedGoalPlural' : 'selectedGoalSingular', labels.length > 1 ? 'Selected goals: ' : 'Selected goal: ') + labels.join(', ');
        }
        results.hidden = false;
        results.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    async function generateAiSmilePreview(file, goals, form) {
        const config = window.simpleDentalSmilePreview || {};
        const data = new FormData();
        data.append('action', 'simple_dental_smile_preview_generate');
        data.append('nonce', config.generateNonce || '');
        data.append('goals', goals.join(', '));
        data.append('lang', config.currentLanguage || 'en');
        data.append('smile_photo', file);
        const captchaResponse = getCaptchaResponse(form);
        if (captchaResponse) {
            data.append('g-recaptcha-response', captchaResponse);
        }

        const response = await fetch(config.ajaxUrl || '/wp-admin/admin-ajax.php', {
            method: 'POST',
            credentials: 'same-origin',
            body: data
        });
        const responseText = await response.text();
        let payload;
        try {
            payload = JSON.parse(responseText);
        } catch (err) {
            throw new Error(message('aiParseFailed', 'Could not generate AI smile preview. Please refresh and try again.'));
        }
        const responseMessage = payload && payload.data && payload.data.message ? payload.data.message : message('aiFailed', 'Could not generate AI smile preview.');

        if (!response.ok || !payload.success || !payload.data || !payload.data.image) {
            const err = new Error(responseMessage);
            err.status = response.status;
            err.canUseFallback = Boolean(payload && payload.data && payload.data.canUseFallback);
            throw err;
        }

        return payload.data.image;
    }

    function canUseLocalFallback(error) {
        return Boolean(error && error.canUseFallback === true && error.status === 503);
    }

    async function submitLead(event) {
        event.preventDefault();
        const form = event.currentTarget;
        const error = document.getElementById('smile-lead-error');
        const success = document.getElementById('smile-lead-success');
        const config = window.simpleDentalSmilePreview || {};

        if (error) error.textContent = '';
        if (success) success.textContent = '';

        const data = new FormData(form);
        data.append('action', 'simple_dental_smile_preview_lead');
        data.append('nonce', config.nonce || '');
        data.append('goals', latestGoals.join(', '));
        data.append('lang', config.currentLanguage || 'en');

        try {
            const response = await fetch(config.ajaxUrl || '/wp-admin/admin-ajax.php', {
                method: 'POST',
                credentials: 'same-origin',
                body: data
            });
            const payload = await response.json();
            const responseMessage = payload && payload.data && payload.data.message ? payload.data.message : message('requestReceived', 'Request received.');

            if (!response.ok || !payload.success) {
                throw new Error(responseMessage);
            }

            form.reset();
            if (success) success.textContent = responseMessage;
        } catch (err) {
            if (error) error.textContent = err.message || message('submitFailed', 'Could not submit request. Please call Simple Dental LV.');
        }
    }

    function renderPreviewState(state, submitButton) {
        const modal = document.getElementById('smile-loading-modal');
        const isBusy = state === PREVIEW_STATES.GENERATING || state === PREVIEW_STATES.FALLBACK;

        if (submitButton) {
            submitButton.disabled = isBusy;
            submitButton.setAttribute('aria-busy', isBusy ? 'true' : 'false');
            submitButton.textContent = isBusy ? message('generatingLabel', 'Generating AI Preview...') : message('generateLabel', 'Generate AI Preview');
        }

        if (modal) {
            modal.hidden = !isBusy;
            modal.setAttribute('aria-hidden', isBusy ? 'false' : 'true');
            document.body.classList.toggle('smile-preview-is-loading', isBusy);
        }
    }

    function transitionPreviewState(nextState, submitButton) {
        previewState = nextState;
        renderPreviewState(previewState, submitButton);
    }

    function populateUtmFields() {
        const params = new URLSearchParams(window.location.search);
        ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term'].forEach((key) => {
            const field = document.getElementById('smile-' + key.replace('_', '-'));
            if (field) {
                field.value = params.get(key) || '';
            }
        });
    }

    function init() {
        const form = document.getElementById('smile-preview-form');
        const leadForm = document.getElementById('smile-lead-form');
        const fileInput = document.getElementById('smile-photo');
        const uploadLabel = document.querySelector('.smile-upload__title');
        const uploadPreview = document.getElementById('smile-upload-preview');
        const uploadIcon = document.querySelector('.smile-upload__icon');
        const submitButton = form ? form.querySelector('.smile-generate') : null;

        if (!form || !fileInput) {
            return;
        }

        populateUtmFields();

        if (leadForm) {
            leadForm.addEventListener('submit', submitLead);
        }

        fileInput.addEventListener('change', () => {
            clearErrors();
            const file = fileInput.files && fileInput.files[0] ? fileInput.files[0] : null;
            if (!file) {
                if (uploadPreview) {
                    uploadPreview.hidden = true;
                    uploadPreview.removeAttribute('src');
                }
                if (uploadIcon) uploadIcon.hidden = false;
                if (uploadLabel) uploadLabel.textContent = message('choosePhoto', 'Choose a photo');
                return;
            }

            if (uploadLabel) {
                uploadLabel.textContent = file.name;
            }

            if (uploadPreview && ALLOWED_TYPES.includes(file.type)) {
                const previewReader = new FileReader();
                previewReader.onload = () => {
                    uploadPreview.src = previewReader.result;
                    uploadPreview.hidden = false;
                    if (uploadIcon) uploadIcon.hidden = true;
                };
                previewReader.readAsDataURL(file);
            }
        });

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const file = fileInput.files && fileInput.files[0] ? fileInput.files[0] : null;

            transitionPreviewState(PREVIEW_STATES.VALIDATING, submitButton);

            if (!validate(form, file)) {
                transitionPreviewState(PREVIEW_STATES.ERROR, submitButton);
                return;
            }

            transitionPreviewState(PREVIEW_STATES.GENERATING, submitButton);

            const reader = new FileReader();
            reader.onload = async () => {
                try {
                    const goals = selectedGoals(form);
                    let conceptDataUrl;
                    try {
                        const aiUploadFile = await createAiUploadFile(reader.result, file.name);
                        conceptDataUrl = await generateAiSmilePreview(aiUploadFile, goals, form);
                    } catch (aiError) {
                        if (!canUseLocalFallback(aiError)) {
                            throw aiError;
                        }
                        transitionPreviewState(PREVIEW_STATES.FALLBACK, submitButton);
                        console.warn('AI smile preview unavailable; using local canvas fallback.', aiError);
                        conceptDataUrl = await createSmileConcept(reader.result, goals);
                    }
                    renderResult(form, reader.result, conceptDataUrl);
                    transitionPreviewState(PREVIEW_STATES.RESULT, submitButton);
                    if (typeof grecaptcha !== 'undefined') {
                        grecaptcha.reset();
                    }
                } catch (err) {
                    setText('smile-photo-error', err.message || message('previewFailed', 'Could not generate the smile preview.'));
                    transitionPreviewState(PREVIEW_STATES.ERROR, submitButton);
                }
            };
            reader.onerror = () => {
                setText('smile-photo-error', message('imageReadFailed', 'Could not read this image. Please try another photo.'));
                transitionPreviewState(PREVIEW_STATES.ERROR, submitButton);
            };
            reader.readAsDataURL(file);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
}());
