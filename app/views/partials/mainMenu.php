<?php
  use Core\H;
  global $currentUser;
  //H::dnd($currentUser);
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="<?=ROOT?>">Curso Alimentos</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav mr-auto my-lg-0 navbar-nav-scroll">
   
  <!--   Inicio Navigation Title       -->
    <?= H::navItem('curso/index', 'Inicio'); ?>  
    
     
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Un enlace
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="#">Acción</a>
          <a class="dropdown-item" href="#">Otra acción</a>
          <a class="dropdown-item" href="#">Algo por aqui</a>
        </div>
      </li>
    </ul>
    <ul class="navbar-nav flex">
       <?php if(!$currentUser): ?>
          <?= H::navItem('auth/login', 'Ingreso'); ?>
        <?php endif; ?>

        <!-- Show current user welcome -->
        <?php if($currentUser): ?>
          <li class="nav-item dropdown">
             <a href="#" class="nav-link dropdown toggle" id="accountDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                Hola <?= $currentUser->fname;?>
             </a>
             <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="accountDropdown">
               <?= H::navItem('admin/cursos', 'Portal Usuario', true);?>
               <li><hr class="dropdown-divider"></li>
               <?= H::navItem('auth/logout', 'Salir', true);?>
             </ul>
          </li>

          
        <?php endif; ?>  
    </ul>
  </div>
</nav>

