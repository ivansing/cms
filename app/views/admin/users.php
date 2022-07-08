<?php $this->start('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-3">
    <h2>Usuarios</h2>
    <a href="<?=ROOT?>auth/register" class="btn btn sm btn-primary">Nuevo usuario</a>
</div>
<div class="poster">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Nivel de Acceso</th>
                <th>Estado</th>
                <th class="text-right">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($this->users as $user): ?>
                <td><?= $user->displayName();?></td>
                <td><?= $user->email?></td>
                <td><?= ucwords($user->acl)?></td>
                <td></td>
                <td>
                    <a href="<?=ROOT?>auth/register/<?=$user->id?>" class="bth btn-sm-btn-info">Editar</a>
                </td>
             <?php endforeach; ?>   
        </tbody>
    </table>
</div>
<?php $this->end(); ?>