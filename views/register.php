<h1>Register</h1>

<?php $form = \App\Core\Form\Form::begin('', 'post') ?>

    <div class="row">
        <div class="col">
            <?php echo $form->field($model, 'firstName') ?>
        </div>
        <div class="col">
            <?php echo $form->field($model, 'lastName') ?>
        </div>
    </div>

    <?php echo $form->field($model, 'email')->email() ?>
    <?php echo $form->field($model, 'password')->password() ?>
    <?php echo $form->field($model, 'passwordConfirm')->password() ?>

    <button type="submit" class="btn btn-primary">Register</button>
<?php echo \App\Core\Form\Form::end() ?>