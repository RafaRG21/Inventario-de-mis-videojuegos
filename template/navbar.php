<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar"  href="index.php?vista=home">
      <img src="./img/control.png" width="70px" height="70px">   
     </a>

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">
      
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link"> <i class="bi bi-people-fill"></i>Usuarios </a>
        <div class="navbar-dropdown">
          <a class="navbar-item" href="index.php?vista=user_new"><i class="bi bi-person-plus-fill"></i> Nuevo </a>
          <a class="navbar-item" href="index.php?vista=user_list"><i class="bi bi-person-lines-fill"></i>Lista </a>
          <a class="navbar-item" href="index.php?vista=user_search"><i class="bi bi-search"></i>Buscar</a>
        </div>
      </div>

      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link"> <i class="bi bi-bookmarks-fill"></i>Categorías </a>
        <div class="navbar-dropdown">
          <a class="navbar-item" href="index.php?vista=category_new"><i class="bi bi-plus-circle"></i>Nuevo </a>
          <a class="navbar-item" href="index.php?vista=category_list"><i class="bi bi-list-ul"></i>Lista </a>
          <a class="navbar-item" href="index.php?vista=category_search"><i class="bi bi-search"></i>Buscar</a>
        </div>
      </div>

      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link"> <i class="bi bi-joystick"></i>Videojuegos </a>
        <div class="navbar-dropdown">
          <a class="navbar-item" href="index.php?vista=videogame_new"><i class="bi bi-plus-circle"></i>Nuevo </a>
          <a class="navbar-item" href="index.php?vista=videogame_list"><i class="bi bi-list-ul"></i>Lista </a>
          <a class="navbar-item" href="index.php?vista=videogame_category"><i class="bi bi-bookmark-star-fill"></i>Por categorías </a>
          <a class="navbar-item" href="index.php?vista=videogame_search"><i class="bi bi-search"></i>Buscar</a>
        </div>
      </div>
    </div>

    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a href="index.php?vista=user_update&user_id_up=<?php echo $_SESSION['id']; ?>" class="button is-primary">
          <i class="bi bi-person-circle" ></i>Mi cuenta
          </a>
          <a href="index.php?vista=logout" class="button is-link">
          <i class="bi bi-box-arrow-left"></i>Salir
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>