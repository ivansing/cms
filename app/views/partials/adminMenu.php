<?php 
    use Core\H; 
    use App\Models\Users;  
    global $currentUser;
      
?>

<ul class="side-nav">
    <li class="nav-title">Panel Administrativo</li>

    
    <?= H::navItem('admin/cursos', 'Cursos'); ?>
    <?php 
    
        if($currentUser->hasPermission('admin')) {
           echo  H::navItem('admin/categories', 'Categorias'); 
           echo  H::navItem('admin/users', 'Clientes'); 
        }
    ?>
    
</ul>