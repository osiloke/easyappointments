<?php
/**
 * Local variables.
 *
 * @var string $id
 * @var string $name
 * @var string $description
 * @var string $price
 * @var string $fee
 * @var string $duration
 */
$fmt = numfmt_create('en_NG', NumberFormatter::CURRENCY);
?>
<label for="service-<?= $id ?>" class="w-full cursor-pointer m-0 relative text-sm">
    <input id="service-<?= $id ?>" name="select-service-tile" type="radio" value="<?= $id ?>" class="peer radio-primary checked:radio-primary active:radio-primary absolute 
           top-4 left-5 w-4 h-4 cursor-pointer" />
    <div
        class="flex flex-col justify-between items-start gap-2.5 h-full bg-neutral-100 text-sm rounded-lg shadow border border-neutral-50 w-full min-h-[5rem] px-4 pb-4 pt-10 cursor-pointer peer-checked:bg-black peer-checked:text-white">
        <div class="w-8/12text-center text-base font-bold leading-normal cursor-pointer">
            <?= $name ?>
        </div>
        <div class="min-h-6 cursor-pointer">
            <?= $description ?>
        </div>
        <div class="w-full h-4 justify-between items-end inline-flex cursor-pointer bottom-0 ">
            <div class="text-gray-400 text-xs font-bold leading-none cursor-pointer">
                <?= numfmt_format_currency($fmt, $price, 'NGN') ?>
            </div>
            <!-- <?php if ((int) $fee > 0) { ?>
            <div class="text-gray-400 text-xs font-bold leading-none cursor-pointer">
                <?= numfmt_format_currency($fmt, $fee, 'NGN') ?>
            </div>
            <?php }?> -->
            <div class="text-right text-gray-400 text-xs font-normal leading-none cursor-pointer">
                <?= $duration ?> min
            </div>
        </div>
    </div>
</label>
