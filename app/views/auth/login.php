<?php use Core\FH; ?>
<?php $this->start('content');?> 
<div class="row">
    <div class="col-md-8 offset-md-2 poster">
        <h2>Ingreso</h2>

        <form method="POST">
            <?= FH::csrfField(); ?>
            <div class="row">
                <?= FH::inputBlock('Email', 'email', $this->user->email,['class' => 'form-control', 'type'=>'text'],['class' => 'form-group col-md-6'], $this->errors); ?>
                <?= FH::inputBlock('Contraseña', 'password', $this->user->password, ['class' => 'form-control', 'type' => 'password'], ['class' => 'form-group col-md-6'], $this->errors); ?>
            </div>

            <div class="row">
                <div class="col">
                    <?= FH::check('Recuerdame', 'remember', $this->user->remember == 'on', ['class' => 'form-check-input'], ['class' => 'form-group form-check'], $this->errors); ?>
                </div>
            </div>

            <div class="text-right">
                <a href="<?=ROOT?>auth/login" class="btn btn-secondary">Cancelar</a>
                <input class="btn btn-primary" value="Ingreso" type="submit" />
            </div>
        </form>
    </div>
</div>
<?php $this->end(); ?>