<?php use Core\FormHelpers; ?>
<?php $this->start('content'); ?>
<div class="row">
    <div class="col-md-8 offset-md-4 poster">
        <h2>Registro</h2>

        <form action="" method="POST">
            <div class"row">
               <?= FormHelpers::inputBlock('Primer Nombre', 'fname', '', ['class' => 'form-control'], ['class' => 'form-group col-md-6'], $this->errors); ?>
               <?= FormHelpers::inputBlock('Apellido', 'lname', '', ['class' => 'form-control'], ['class' => 'form-group col-md-6'], $this->errors); ?>
               <?= FormHelpers::inputBlock('Email', 'email', '', ['class' => 'form-control', 'type' => 'email'], ['class' => 'form-group col-md-6'], $this->errors); ?>
 
            </div>

            <div class="row">
            <?= FormHelpers::inputBlock('Contraseña', 'password', '', ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-group col-md-6'], $this->errors); ?>
            <?= FormHelpers::inputBlock('Confirmar contraseña', 'confirm', '', ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-group col-md-6'], $this->errors); ?>

            </div>

            <div class="text-right">
                <a href="#" class="btn btn-secondary">Cancelar</a>
                <input class="btn btn-primary value="Grabar" type="submit" />
            </div>
        </form>
    </div>
</div>

<?php $this->end(); ?>