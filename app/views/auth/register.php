<?php use Core\FH; ?>
<?php $this->start('content'); ?>
<div class="row">
    <div class="col-md-8 offset-md-2 poster">
        <h2><?= $this->header ?></h2>

        <form action="" method="POST">
            <?= FH::csrfField();?>
            <div class="row">
                <?= FH::inputBlock('Primer Nomber', 'fname', $this->user->fname, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], $this->errors); ?>
                <?= FH::inputBlock('Apellido', 'lname', $this->user->lname, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], $this->errors); ?>
                <?= FH::inputBlock('Email', 'email', $this->user->email, ['class' => 'form-control', 'type' => 'email'], ['class' => 'form-group col-md-6'], $this->errors); ?>
                <?= FH::selectBlock('Función', 'acl', $this->user->acl, $this->role_options, ['class' => 'form-control'], ['class' => 'form-group col-md-6'], $this->errors); ?>
            </div>

            <div class="row">
                <?= FH::inputBlock('Contraseña', 'password', '', ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-group col-md-6'], $this->errors); ?>
                <?= FH::inputBlock('Confirmar Contraseña', 'confirm', '', ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-group col-md-6'], $this->errors); ?>
            </div>

            <div class="text-right">
                <a href="#" class="btn btn-secondary">Cancelar</a>
                <input class="btn btn-primary" value="Grabar" type="submit" />
            </div>
        </form>
    </div>
</div>
<?php $this->end(); ?>