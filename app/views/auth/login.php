<?php use Core\FormHelpers; ?>
<?php $this->start('content');?>
<div class="row">
    <div class="col-md-8 offset-md-2 poster">
        <h2>Ingreso</h2>

        <form method="POST">
            <?= FormHelpers::csrfField(); ?>
            <div class="row">
                <?= FormHelpers::inputBlock('Email', 'email', $this->user->email,['class' => 'form-control', 'type' => 'text'], ['class' => 'form-group col-md-6'], $this->errors) ?>
                <?= FormHelpers::inputBlock('Contraseña', 'password', $this->user->password,['class' => 'form-control', 'type' => 'password'], ['class' => 'form-group col-md-6'], $this->errors) ?>

            </div>

            <!--  Recuerdame checkbox  -->
            <div class="row">
                <div class="col">
                <?= FormHelpers::check('Recuerdame', 'recordar', $this->user->remember == 'on', ['class' => 'form-check-input'], ['class' => 'form-group form-check'], $this->errors)?>
                </div>
            </div>

            <div class="text-right">
                <a href="<?=ROOT?>auth/login" class="btn btn-secondary">Cancelar</a>
                <input class="btn btn-primary" value="Ingreso" type="submit" />
            </div>
        </form>
    </div>

<?php $this->end(); ?>