<form name="myform" action="ProsesData_Form.php" method="POST">
    <div class="field">
        <label for="surname">Surname</label>
        <input type="text" id="surname" name="surname" size="31"
            value="<?php echo fieldValue($_POST, 'surname'); ?>"
            aria-invalid="<?php echo isset($errors['surname']) ? 'true' : 'false'; ?>"
            aria-describedby="surname-error">
        <?php echo fieldError($errors, 'surname'); ?>
    </div>
    <div class="field">
        <label for="email">Email address</label>
        <input type="text" id="email" name="email" size="31"
            value="<?php echo fieldValue($_POST, 'email'); ?>"
            aria-invalid="<?php echo isset($errors['email']) ? 'true' : 'false'; ?>"
            aria-describedby="email-error">
        <?php echo fieldError($errors, 'email'); ?>
    </div>
    <div class="field">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" size="31"
            aria-invalid="<?php echo isset($errors['password']) ? 'true' : 'false'; ?>"
            aria-describedby="password-error">
        <?php echo fieldError($errors, 'password'); ?>
    </div>
    <div class="field">
        <label for="address">Street address</label>
        <textarea id="address" name="address" rows="3" cols="22"
            aria-invalid="<?php echo isset($errors['address']) ? 'true' : 'false'; ?>"
            aria-describedby="address-error"><?php echo fieldValue($_POST, 'address'); ?></textarea>
        <?php echo fieldError($errors, 'address'); ?>
    </div>
    <div class="field">
        <label for="state">State</label>
        <select name="state" id="state"
            aria-invalid="<?php echo isset($errors['state']) ? 'true' : 'false'; ?>"
            aria-describedby="state-error">
            <option value="-1" <?php echo fieldValue($_POST, 'state') === '-1' || !isset($_POST['state']) ? 'selected' : ''; ?>>[choose your state]</option>
            <option value="1" <?php echo fieldValue($_POST, 'state') === '1' ? 'selected' : ''; ?>>Australian Capital Territory</option>
            <option value="2" <?php echo fieldValue($_POST, 'state') === '2' ? 'selected' : ''; ?>>Queensland</option>
            <option value="3" <?php echo fieldValue($_POST, 'state') === '3' ? 'selected' : ''; ?>>Victoria</option>
            <option value="4" <?php echo fieldValue($_POST, 'state') === '4' ? 'selected' : ''; ?>>New South Wales</option>
            <option value="5" <?php echo fieldValue($_POST, 'state') === '5' ? 'selected' : ''; ?>>Tasmania</option>
            <option value="6" <?php echo fieldValue($_POST, 'state') === '6' ? 'selected' : ''; ?>>South Australia</option>
            <option value="7" <?php echo fieldValue($_POST, 'state') === '7' ? 'selected' : ''; ?>>Western Australia</option>
            <option value="8" <?php echo fieldValue($_POST, 'state') === '8' ? 'selected' : ''; ?>>Northern Territory</option>
        </select>
        <?php echo fieldError($errors, 'state'); ?>
    </div>
    <input type="hidden" name="country" value="Australia">
    <div class="field">
        <span>Gender</span>
        <input type="radio" id="sex-male" name="sex" value="male"
            <?php echo fieldValue($_POST, 'sex') === 'male' ? 'checked' : ''; ?>
            aria-invalid="<?php echo isset($errors['sex']) ? 'true' : 'false'; ?>"
            aria-describedby="sex-error">
        <label for="sex-male">Male</label>
        <input type="radio" id="sex-female" name="sex" value="female"
            <?php echo fieldValue($_POST, 'sex') === 'female' ? 'checked' : ''; ?>
            aria-invalid="<?php echo isset($errors['sex']) ? 'true' : 'false'; ?>"
            aria-describedby="sex-error">
        <label for="sex-female">Female</label>
        <?php echo fieldError($errors, 'sex'); ?>
    </div>
    <div class="field">
        <input type="checkbox" id="vegetarian" name="vegetarian" value="yes"
            <?php echo fieldValue($_POST, 'vegetarian') === 'yes' ? 'checked' : ''; ?>
            aria-invalid="<?php echo isset($errors['vegetarian']) ? 'true' : 'false'; ?>"
            aria-describedby="vegetarian-error">
        <label for="vegetarian">Vegetarian</label>
        <?php echo fieldError($errors, 'vegetarian'); ?>
    </div>
    <div class="field">
        <input type="submit" value="Submit" name="submit">
        <input type="reset" name="reset" value="Reset">
    </div>
</form>
