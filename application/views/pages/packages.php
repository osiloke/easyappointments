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
            <div class="items-start relative h-48 md:h-full p-2 gap-4 flex flex-row bg-white rounded-lg shadow border border-neutral-50 hover:bg-black">
                <div class="w-28 h-28 md:w-32 md:h-32 lg:w-40 lg:h-40 bg-gray-100 rounded-lg shadow border border-neutral-50 flex-shrink-0 ">
                    <?php if ($provider["settings"]["image"] != NULL) : ?>
                        <img class="object-cover w-28 h-28 md:w-32 md:h-32 lg:w-40 lg:h-40 rounded-lg" src="<?= $provider["settings"]["image"] ?>" />
                    <? endif; ?>
                </div>
                <div class="space-y-1 flex flex-col overflow-hidden h-full">
                    <div class="text-black text-base font-bold leading-normal text-ellipsis line-clamp-3 break-words"><?= $provider["first_name"] ?> <?= $provider["last_name"] ?></div>
                    <div class="break-words">
                        <p class="text-black text-sm font-normal leading-tight text-ellipsis line-clamp-3 break-words"><?= $provider["notes"] ?></p>
                    </div>
                    <div class="flex flex-grow">
                        <a class="ext-ellipsis break-words link text-sm text-gray-400" target="_blank" href="<?= site_url($provider["settings"]["username"]) ?>">@<?= $provider["settings"]["username"] ?></a>
                    </div>
                    <div class="flex flex-col flex-grow gap-2">
                        <div class="text-neutral-600 text-sm font-normal leading-tight"><?= $noServices ?> Service<?= $noServices > 1 ? 's' : '' ?></div>
                        <div class="w-12 h-5 px-2 py-0.5  bg-green-500 rounded-sm flex-col justify-center items-start gap-2 inline-flex">
                            <div class="self-stretch justify-center items-center gap-1 inline-flex">
                                <div class="text-center text-white text-xs font-medium leading-none">Active</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown dropdown-end absolute right-2 bottom-5">
                    <div tabindex="0" role="button" class="btn rounded-sm btn-ghost hover:bg-transparent p-0 m-0 fill-primary">
                        <i data-lucide="ellipsis-vertical" class="fill-primary"></i>
                    </div>
                    <div tabindex="0" class="dropdown-content z-[1] shadow bg-base-100 rounded-box w-64">
                        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                            <li><a href="<?= site_url("packages/edit") ?>/<?= $provider["id"] ?>">Edit listing</a></li>
                            <li><a target="_blank" href="<?= site_url($provider["settings"]["username"]) ?>">View booking page</a></li>
                        </ul>
                    </div>
                </div>
            </div>
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
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
<script src="https://unpkg.com/htmx.org@1.9.12" crossorigin="anonymous"></script>
<?php end_section('scripts'); ?>