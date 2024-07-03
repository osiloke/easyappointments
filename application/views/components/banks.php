<option value="">Select Bank</option>
<?php foreach (vars('banks') as $bank) : ?>
    <option value="<?php echo $bank->code; ?>"><?php echo $bank->name; ?></option>
<?php endforeach; ?>