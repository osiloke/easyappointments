<?php
/**
 * Local variables.
 *
 * @var array $timezones
 * @var string $timezone
 */
?>

<div id="unavailabilities-modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><?= lang('new_unavailability_title') ?></h3>
                <button class="btn btn-square btn-ghost" data-bs-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="width:24px;height:24px;fill:#fff"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"></path></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-message alert d-none"></div>

                <form>
                    <fieldset>
                        <input id="unavailability-id" type="hidden">

                        <div class="mb-3">
                            <label for="unavailability-provider" class="form-label">
                                <?= lang('provider') ?>
                            </label>
                            <select id="unavailability-provider" class="form-control"></select>
                        </div>

                        <div class="mb-3">
                            <label for="unavailability-start" class="form-label">
                                <?= lang('start') ?>
                                <span class="text-danger">*</span>
                            </label>
                            <input id="unavailability-start" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="unavailability-end" class="form-label">
                                <?= lang('end') ?>
                                <span class="text-danger">*</span>
                            </label>
                            <input id="unavailability-end" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <?= lang('timezone') ?>
                            </label>

                            <div
                                class="border rounded d-flex justify-content-between align-items-center bg-light timezone-info">
                                <div class="border-end w-50 p-1 text-center">
                                    <small>
                                        <?= lang('provider') ?>:
                                        <span class="provider-timezone">
                                                    -
                                                </span>
                                    </small>
                                </div>
                                <div class="w-50 p-1 text-center">
                                    <small>
                                        <?= lang('current_user') ?>:
                                        <span>
                                                    <?= $timezones[session('timezone', 'Africa/Lagos')] ?>
                                                </span>
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="unavailability-notes" class="form-label">
                                <?= lang('notes') ?>
                            </label>
                            <textarea id="unavailability-notes" rows="3" class="form-control"></textarea>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    <?= lang('cancel') ?>
                </button>
                <button id="save-unavailability" class="btn btn-primary">
                    <i class="fas fa-check-square me-2"></i>
                    <?= lang('save') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<?php section('scripts'); ?>

<script src="<?= asset_url('assets/js/components/unavailabilities_modal.js') ?>"></script>

<?php end_section('scripts'); ?> 
