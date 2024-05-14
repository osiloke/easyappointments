<?php extend('layouts/backend_layout'); ?>

<?php section('content'); ?>

<div class="form-message alert" style="display:none;"></div>
<div class="backend-page space-y-4 px-4" id="providers-page">
    <div class="w-full flex flex-col md:flex-row justify-center items-center md:justify-between border-b border-gray-200 py-5 gap-4">
        <div class=" text-neutral-600 text-4xl font-bold leading-10"><?= lang("providers") ?></div>
        <a href="<?= site_url("/packages/new") ?>" class="btn justify-center items-center gap-2 btn-primary  rounded-full ">
            <div class="text-center text-white text-sm font-medium leading-tight">Add New Listing</div>
        </a>
    </div>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-3">
        <?php foreach (vars('providers') as $provider) : ?>
            <?php $noServices = count($provider["services"]); ?>
            <a href="<?= site_url("packages/edit") ?>/<?= $provider["id"] ?>" class="h-48 md:h-52 p-2 gap-4 flex flex-row bg-white rounded-lg shadow border border-neutral-50 hover:bg-black">
                <div class="w-28 h-28 md:w-48 md:h-48 bg-gray-100 rounded-lg shadow border border-neutral-50 flex-shrink-0 ">
                    <?php if ($provider["settings"]["image"] != NULL) : ?>
                        <img class="object-cover w-28 h-28 md:w-48 md:h-48 rounded-lg" src="<?= $provider["settings"]["image"] ?>" />
                    <? endif; ?>
                </div>
                <div class="space-y-2 ">
                    <div class="text-black text-base font-bold leading-normal"><?= $provider["first_name"] ?> <?= $provider["last_name"] ?></div>
                    <div class="text-neutral-600 text-sm font-normal leading-tight"><?= $noServices ?> Service<?= $noServices > 1 ? 's' : '' ?></div>
                    <div class="w-52 break-words">
                        <p class="text-black text-sm font-normal leading-tight text-ellipsis line-clamp-3 break-all"><?= $provider["notes"] ?></p>

                    </div>
                    <div class="w-12 h-5 px-2 py-0.5  bg-green-500 rounded-sm flex-col justify-center items-start gap-2 inline-flex">
                        <div class="self-stretch justify-center items-center gap-1 inline-flex">
                            <div class="text-center text-white text-xs font-medium leading-none">Active</div>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
</div>
</div>

<?php end_section('content'); ?>

<?php section('scripts'); ?>
<script src="<?= asset_url('assets/js/utils/string.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/ui.js') ?>"></script>
<script src="<?= asset_url('assets/js/utils/url.js') ?>"></script>

<script src="https://unpkg.com/htmx.org@1.9.12" crossorigin="anonymous"></script>
<?php end_section('scripts'); ?>