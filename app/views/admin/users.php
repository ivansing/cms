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
                <td><?=$user->blocked? "Bloqueado" : "Activo"?></td>
                <td class="text-right">
                    <a href="<?=ROOT?>auth/register/<?=$user->id?>" class="bth btn-sm-btn-info">Editar</a>
                    <a href="<?=ROOT?>admin/toggleBlockUser/<?=$user->id?>" class="btn btn-sm <?= $user->blocked? "btn-warning" : "btn-secondaty"?>">
                        <?= $user->blocked? 'Desbloquear' : "Block" ?>
                    </a> 
                    <button class="btn btn-sm btn-danger" onclick="confirmDelete('<?=$user->id?>')">Borrar</button>
                </td>
             <?php endforeach; ?>   
        </tbody>
    </table>

    <?php $this->partials('partials/pager'); ?>
</div>

<script>
    function confirmDelete(userId){
        if(window.confirm('¿Esta seguro que quiere borrar el usuario? No se puede revert despues!')){
            window.location.href = `<?=ROOT?>admin/deleteUser/${userId}`;
        }
    }
</script>
<?php $this->end(); ?>