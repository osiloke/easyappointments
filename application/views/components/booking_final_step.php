<?php
/**
 * Local variables.
 *
 * @var bool $manage_mode
 * @var string $display_terms_and_conditions
 * @var string $display_privacy_policy
 */
?>

<div id="wizard-frame-4" class="wizard-frame" style="display:none;">
    <div class="frame-container">
        <div class="flex flex-col lg:flex-row w-full justify-between space-x-0 gap-5">
            <div class="w-full lg:w-5/12 flex flex-col gap-10">
                <?php component('provider_card', [
                    'hide_service' => count($available_providers) == 1,
                    'secretary' => vars('secretary')
                ]); ?>
                <?php component('selected_service', ['services' => $available_services, 'step' => '4']); ?>
            </div>
            <div id="step-content">
                <h2 class="frame-title">
                    <?= lang('appointment_confirmation') ?>
                </h2>
                <div class="row frame-content">
                    <div id="appointment-details" class="col-12 col-md-6 text-center text-md-start"></div>
                    <div id="customer-details" class="col-12 col-md-6 text-center text-md-end"></div>
                </div>
                <?php if (setting('require_captcha')): ?>
                    <div class="row frame-content">
                        <div class="col-12 col-md-6">
                            <label class="captcha-title" for="captcha-text">
                                CAPTCHA
                                <button class="btn btn-link text-dark text-decoration-none py-0">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </label>
                            <img class="captcha-image" src="<?= site_url('captcha') ?>" alt="CAPTCHA">
                            <input id="captcha-text" class="captcha-text form-control" type="text" value="" />
                            <span id="captcha-hint" class="help-block" style="opacity:0">&nbsp;</span>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="d-flex fs-6 justify-content-around">
                    <?php if ($display_terms_and_conditions): ?>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="required form-check-input" id="accept-to-terms-and-conditions">
                            <label class="form-check-label" for="accept-to-terms-and-conditions">
                                <?= strtr(lang('read_and_agree_to_terms_and_conditions'), [
                                    '{$link}' =>
                                        '<a href="#" data-bs-toggle="modal" data-bs-target="#terms-and-conditions-modal">',
                                    '{/$link}' => '</a>'
                                ]) ?>
                            </label>
                        </div>
                    <?php endif; ?>

                    <?php if ($display_privacy_policy): ?>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="required form-check-input" id="accept-to-privacy-policy">
                            <label class="form-check-label" for="accept-to-privacy-policy">
                                <?= strtr(lang('read_and_agree_to_privacy_policy'), [
                                    '{$link}' =>
                                        '<a href="#" data-bs-toggle="modal" data-bs-target="#privacy-policy-modal">',
                                    '{/$link}' => '</a>'
                                ]) ?>
                            </label>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="command-buttons">
        <button type="button" id="button-back-4" class="btn button-back btn-outline-secondary" data-step_index="4">
            <i class="fas fa-chevron-left me-2"></i>
            <?= lang('back') ?>
        </button>
        <form id="book-appointment-form" style="display:inline-block" method="post">
            <button id="book-appointment-submit" type="button" class="btn button-submit btn-dark btn-primary">
                <?= $manage_mode ? lang('update') : ($is_paid == 1 ? lang('PROCEED TO PAYMENT') : lang('Complete')) ?>
                <i class="fas fa-chevron-right ms-2"></i>
            </button>
            <input type="hidden" name="csrfToken" />
            <input type="hidden" name="post_data" />
        </form>
    </div>
</div>
