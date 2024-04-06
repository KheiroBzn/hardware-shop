<div class='container mb-5'>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-gray-900" >
    <a href="dashboard.php">
      <img class="logo" src="<?php echo $img ?>/logo/logo.svg" alt="">
    </a>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarCollapse"
      aria-controls="navbarCollapse"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="dashboard"> 
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="categories">Catégories</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="items">Produits</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="commands">Commandes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="members">Membres</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="comments">Commentaires</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="statistics">Statistiques</a>
        </li>        
        <li class="nav-item dropdown"></li>
      </ul>
      <div class="form-inline mt-2 mt-md-0"> 
        <div class="navbar-nav mr-5 nav-item dropdown my-sm-0">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            id="navbarDropdownMenuLink"
            role="button"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
          <?php echo $_SESSION['prenom'] ?>
          </a>
          <div class="dropdown-menu animated--grow-in" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="http://hwshop/Accueil" target="_blanck">Visiter le site</a>
            <a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['id'] ?>">Editer mon profil</a>
            <a class="dropdown-item" href="logout.php">Se déconnecter</a>
          </div>
        </div>  
      </div>    
    </div> 
  </nav>
</div> 
