<?php use Core\FormHelpers; ?>
<?php $this->start('content'); ?>
<div class="row">
    <div class="col-md-8 offset-md-2 poster">
        <h2>Registro</h2>

        <form action="" method="POST">
            <?= FormHelpers::csrfField();?>
            <div class="row">
               <?= FormHelpers::inputBlock('Primer Nombre', 'fname', $this->user->fname, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], $this->errors); ?>
               <?= FormHelpers::inputBlock('Apellido', 'lname', $this->user->lname, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], $this->errors); ?>
               <?= FormHelpers::inputBlock('Email', 'email', $this->user->email, ['class' => 'form-control', 'type' => 'email'], ['class' => 'form-group col-md-6'], $this->errors); ?>
               <?= FormHelpers::selectBlock('Role', 'acl', $this->user->acl, $this->role_options, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], $this->errors); ?>
            </div>

            <div class="row">
            <?= FormHelpers::inputBlock('Contraseña', 'password', $this->user->password, ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-group col-md-6'], $this->errors); ?>
            <?= FormHelpers::inputBlock('Confirmar contraseña', 'confirm', $this->user->confirm, ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-group col-md-6'], $this->errors); ?>

            </div>

            <div class="text-right">
                <a href="#" class="btn btn-secondary">Cancelar</a>
                <input class="btn btn-primary" value="Grabar" type="submit" />
            </div>
        </form>
    </div>
</div>

<?php $this->end(); ?>