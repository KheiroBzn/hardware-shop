<?php if(!isset($_SESSION)){
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>
      <?php echo
      htmlspecialchars(ucfirst($current_sous_categorie['nom_sous_categorie']) );
      ?>
    </title>
    <link rel="icon" href="/public/images/logo/ver4/PNG/logo.png" />
    <link
      rel="stylesheet"
      href="/public/framework/bootstrap4.4.1/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="/public/framework/font-awesome-4.7.0/font-awesome-4.7.0/css/font-awesome.min.css"
    />
    <link rel="stylesheet" href="/public/css/navigationbar.css" />
    <link rel="stylesheet" href="/public/css/footerbar.css" />

    <link rel="stylesheet" href="/public/css/sous-categorie.css" />

    <!-- Custom Css Filter Select  with checkbox-->
    <link
      href="/public/includes/filter/css/jquery.multiselect.css"
      rel="stylesheet"
      type="text/css"
    />
    <link href="/public/includes/filter/css/app_style.css" rel="stylesheet" />
    <link
      href="/public/includes/filter/css/checkbox-style.css"
      rel="stylesheet"
    />

    <!-- slider price range -->
    <link rel="stylesheet" href="/public/css/jquery-ui.css" />

    <!-- switch  -->
    <link rel="stylesheet" href="/public/css/switch-style.css" />

    <!-- alert info style -->
    <link rel="stylesheet" type="text/css" href="/public/css/notie.css" />
  </head>

  <body>
    <?php include  $_SERVER['DOCUMENT_ROOT'] . "/public/includes/menu.php";  ?>

    <!-- categories name -->
    <section class="section-pagetop bg pt-2">
      <div class="container">
        <nav>
          <ol
            class="breadcrumb text-white justify-content-center"
            style="background-color: unset;"
          >
            <li class="breadcrumb-item">
              <a href="<?php echo $url_accueil ; ?>">Accueil</a>
            </li>
            <li class="breadcrumb-item">
              <a
                href="<?php echo $url_categorie[$current_sous_categorie['nom_categorie']] ; ?>"
                ><?php echo ucfirst($current_sous_categorie['nom_categorie']) ;?>
              </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              <?php echo ucfirst($current_sous_categorie['nom_sous_categorie']) ;?>
            </li>
          </ol>
        </nav>
      </div>
    </section>

    <section class="section-content padding-y mb-5">
      <div class="container">
        <div class="row">
          <aside class="col-lg-3 col-md-4">
            <div class="card">
              <article class="filter-group">
                <header class="card-header style-card-header py-2">
                  <a
                    href="#"
                    data-toggle="collapse"
                    data-target="#collapse_1"
                    aria-expanded="true"
                    class="d-inline-flex"
                  >
                    <i class="icon-control fa fa-chevron-down mr-2"></i>
                    <h6
                      id="sous-categorie-title"
                      data-id="<?php echo $_GET['id_sous_categorie'] ; ?>"
                      data_href=""
                      class="title text-capitalize"
                    >
                      <?php echo $current_sous_categorie['nom_categorie'] ; ?>
                    </h6>
                  </a>
                </header>
                <div
                  class="filter-content collapse show"
                  id="collapse_1"
                  style=""
                >
                  <div class="card-body">
                    <ul class="list-menu">
                      <?php while($element= $all_sous_categorie->fetch()){ ?>
                      <li>
                        <a
                          href="<?php echo $url_sous_categorie[$element['nom_sous_categorie']]; ?>"
                          class="text-capitalize text-dark"
                          ><?php echo $element['nom_sous_categorie'] ; ?>
                        </a>
                      </li>
                      <?php }?>
                    </ul>
                  </div>
                  <!-- card-body.// -->
                </div>
              </article>
              <!-- filter-group  .// -->
              <?php 
						if($filter_xml!=null){
							include  $_SERVER['DOCUMENT_ROOT'] . "/public/includes/multiSelectFilter.php"; 
						}
							
					?>
              <article class="filter-group">
                <header class="card-header style-card-header py-2">
                  <a
                    href="#"
                    data-toggle="collapse"
                    data-target="#collapse_3"
                    aria-expanded="true"
                    class="d-inline-flex"
                  >
                    <i class="icon-control fa fa-chevron-down mr-2"></i>
                    <h6 class="title"> Marques</h6>
                  </a>
                </header>
                <div
                  class="filter-content collapse show"
                  id="collapse_3"
                  style=""
                >
                  <div class="card-body">
                    <?php while($element = $marque_sous_categorie->fetch() ){ ?>

                    <label class="custom-control custom-checkbox">
                      <input
                        type="checkbox"
                        value="<?php echo $element['marque_article']; ?>"
                        class="custom-control-input marque-checkbox"
                      />
                      <div class="custom-control-label">
                        <?php echo $element['marque_article']; ?>
                        <b class="badge badge-pill badge-light float-right"
                          ><?php echo $element['total_article']; ?></b
                        >
                      </div>
                    </label>

                    <?php } ?>
                  </div>
                </div>
              </article>

              <article class="filter-group">
                <header class="card-header style-card-header py-2">
                  <a
                    href="#"
                    data-toggle="collapse"
                    data-target="#collapse_4"
                    aria-expanded="true"
                    class="d-inline-flex"
                  >
                    <i class="icon-control fa fa-chevron-down mr-2"></i>
                    <h6 class="title"> Prix en DZD</h6>
                  </a>
                </header>
                <div
                  class="filter-content collapse show"
                  id="collapse_4"
                  style=""
                >
                  <div class="card-body">
                    <p>
                      <input
                        type="text"
                        id="amount"
                        readonly=""
                        class="text-dark text-center"
                        style="
                          border: 0;
                          font-weight: bold;
                          width: -webkit-fill-available;
                        "
                      />
                    </p>

                    <div
                      id="slider-range"
                      class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                    >
                      <div
                        class="ui-slider-range ui-corner-all ui-widget-header"
                        style="left: 0%; width: 99.6%;"
                      ></div>

                      <span
                        tabindex="0"
                        class="ui-slider-handle ui-corner-all ui-state-default"
                        style="left: 0%;"
                      >
                      </span>
                      <span
                        tabindex="0"
                        class="ui-slider-handle ui-corner-all ui-state-default"
                        style="left: 99.6%;"
                      ></span>
                    </div>

                    <button
                      id="price-filter"
                      class="btn btn-block btn-sm btn-primary w-50 mt-3 mx-auto"
                    >
                      Confirmer
                    </button>
                    <button
                      id="price-reset"
                      class="btn btn-block btn-sm btn-primary w-50 mt-3 mx-auto"
                    >
                      Reinitialiser
                    </button>
                  </div>
                </div>
              </article>

              <article class="filter-group">
                <header class="card-header style-card-header py-2">
                  <a
                    href="#"
                    data-toggle="collapse"
                    data-target="#collapse_5"
                    aria-expanded="true"
                    class="d-inline-flex"
                  >
                    <i class="icon-control fa fa-chevron-down mr-2"></i>
                    <h6 class="title"> Autre Filtres</h6>
                  </a>
                </header>
                <div
                  class="filter-content collapse show"
                  id="collapse_5"
                  style=""
                >
                  <div class="card-body">
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item switch-list">
                        <label class="switch">
                          <input
                            type="checkbox"
                            value="disponible"
                            class="primary more-filter"
                          />
                          <span class="slider round"></span>
                        </label>
                        <p class="pl-2 switch-text">
                          Afficher les Articles Disponible
                        </p>
                      </li>

                      <li class="list-group-item switch-list">
                        <label class="switch">
                          <input
                            type="checkbox"
                            value="indisponible"
                            class="primary more-filter"
                          />
                          <span class="slider round"></span>
                        </label>
                        <p class="pl-2 switch-text">
                          Afficher les Articles Indisponible
                        </p>
                      </li>
                    </ul>
                  </div>
                </div>
              </article>
            </div>
          </aside>
          <main class="col-lg-9 col-md-8">
            <header class="border-bottom mb-4 pb-3">
              <div class="form-inline">
                <span id="nombre-article" class="mr-md-auto"
                  ><?php echo  $nbr_article; ?>
                  Articles Trouve
                </span>
                <select
                  id="order-select"
                  class="mr-2 form-control"
                  style="display: none;"
                >
                  <option value="plus recent" selected="selected"
                    >Les Plus Récent</option
                  >
                  <option value="plus ancien">Les Plus Ancien</option>
                  <option value="plus vues">Les Plus Vues</option>
                  <option value="plus vendus">Les Plus Vendus</option>
                  <option value="prix croissant">Prix Croissant</option>
                  <option value="prix decroissant">Prix Decroissant</option>
                </select>
                <select
                  id="number-per-page"
                  class="mr-2 form-control"
                  style="display: none;"
                >
                  <option value="6">6</option>
                  <option value="9" selected="selected">9</option>
                  <option value="12">12</option>
                  <option value="15">15</option>
                  <option value="18">18</option>
                  <option value="21">21</option>
                </select>
                <div class="btn-group">
                  <a
                    href="#"
                    class="btn btn-outline-secondary"
                    data-toggle="tooltip"
                    title=""
                    data-original-title="List view"
                  >
                    <i class="fa fa-bars"></i
                  ></a>
                  <a
                    href="#"
                    class="btn btn-outline-secondary active"
                    data-toggle="tooltip"
                    title=""
                    data-original-title="Grid view"
                  >
                    <i class="fa fa-th"></i
                  ></a>
                </div>
              </div>
            </header>
            <div id="display-article" class="row">
              <?php echo $currentArticlesDisplay;?>
            </div>
            <!-- row end.// -->
            <div>
              <nav class="mt-4" aria-label="Page navigation sample">
                <ul id="display-page" class="pagination float-right">
                  <?php echo $currentPaginationNumber ;?>
                </ul>
              </nav>
            </div>
          </main>
        </div>
      </div>
    </section>

    <?php include  $_SERVER['DOCUMENT_ROOT'] . "/public/includes/footer.php"; ?>

    <script src="/public/framework/jquery/jquery-3.4.1.min.js"></script>
    <script src="/public/framework/jquery/popper.min.js"></script>
    <script src="/public/framework/bootstrap4.4.1/js/bootstrap.min.js"></script>
    <script src="/public/js/navigationbar.js"></script>
    <!-- range price slide -->
    <script src="/public/js/jquery-ui.js"></script>
    <script src="/public/js/slider-range.js"></script>

    <!-- Custom css Filter Select Checkbox-->
    <script src="/public/includes/filter/js/jquery.multiselect.js"></script>
    <script src="/public/includes/filter/js/multiselect.js"></script>

    <!-- ajax filter -->
    <script src="/public/includes/filterAjax.js"></script>

    <!-- script alert info-->
    <script src="/public/js/notie.js"></script>
    <script src="/public/includes/alert-info.js"></script>

    <!-- ajouter panier-->
    <script src="/public/includes/panier.js"></script>

    <!-- recherche autcomplete -->
    <link rel="stylesheet" href="/public/css/jquery-ui.css" />
    <script src="/public/js/jquery-ui.js"></script>
    <script src="/public/includes/recherche-autocomplete.js"></script>
  </body>
</html>
