<select id="bank-name" class="form-control required" maxlength="128" disabled>
    <option value="">Select Bank</option>
    <?php foreach (vars('banks') as $bank) : ?>
        <option value="<?php echo $bank->code; ?>"><?php echo $bank->name; ?></option>
    <?php endforeach; ?>
</select>