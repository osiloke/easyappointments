<?php
/**
 * Local variables.
 *
 * @var string $name
 * @var string $description
 * @var string $price
 */
?>
<div class="w-44 h-44 relative">
    <div class="w-44 h-44 left-[2px] top-0 absolute bg-black rounded-lg shadow border border-neutral-50"></div>
    <div class="w-44 h-28 p-2.5 left-0 top-[24.07px] absolute flex-col justify-start items-center gap-2.5 inline-flex">
        <div class="w-36 text-center text-neutral-50 text-base font-bold leading-normal">
            <?= $name ?>
        </div>
        <?= $description ?>
        <div class="text-center text-neutral-50 text-xs font-light leading-none">
            NGN
            <?= $price ?>
        </div>
    </div>
</div>