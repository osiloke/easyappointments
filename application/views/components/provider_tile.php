<?php
/**
 * Local variables.
 *
 * @var string $id
 * @var string $first_name
 * @var string $last_name
 * @var string $image
 * @var string $description
 * @var string $image
 */
?> 
<label class="card shadow-none hover:bg-primary hover:border-primary hover:text-base-100 cursor-pointer transition-all" for="provider-<?= $id ?>" class="w-full cursor-pointer m-0 relative text-sm">
    <input id="provider-<?= $id ?>" name="select-provider-tile" type="radio" value="<?= $id ?>" class="peer radio-primary checked:radio-primary active:radio-primary absolute hidden  
           top-4 left-5 w-4 h-4 cursor-pointer" />
    <figure class="transition-all"><img src="https://daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.jpg" alt="Shoes" /></figure>
    <div class="card-body">
        <h2 class="card-title text-lg font-medium leading-7">
        <?= $first_name ?> <?= $last_name ?>
        <!-- <div class="badge badge-secondary">NEW</div> -->
        </h2>
        <p class="text-sm font-normal leading-tight"><?= $description ?></p>
        <!-- <div class="card-actions justify-end pt-4"> 
            <button data-provider-id="<?= $id ?>" class="btn btn-md rounded-lg btn-primary">Choose Service</button>
        </div> -->
    </div>
</label> 
