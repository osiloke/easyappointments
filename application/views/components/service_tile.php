<?php
/**
 * Local variables.
 *
 * @var string $name
 * @var string $description
 * @var string $price
 */
?>
<div class="w-full form-control bg-neutral-100 rounded-lg shadow border border-neutral-50">
    <div class="w-full label relative">
        <input type="radio" name="radio-10"
            class="radio radio-primary checked:radio-primary active:radio-primary absolute top-0" checked />
        <div class="w-full min-h-[5rem] p-2.5 flex-col justify-start items-start gap-2.5 inline-flex pt-10">
            <div class="w-8/12text-center text-base font-bold leading-normal">
                <?= $name ?>
            </div>
            <div class="min-h-6">
                <?= $description ?>
            </div>
            <div class="w-full h-4 justify-between items-end inline-flex">
                <div class="text-gray-400 text-xs font-bold leading-none">
                    NGN
                    <?= $price ?>
                </div>
                <div class="text-right text-gray-400 text-xs font-normal leading-none">15 min</div>
            </div>
        </div>
    </div>
</div>