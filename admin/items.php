<?php

    ob_start();
    session_start();
    $pageTitle = 'Produits';
//    $noNavbar = '';
    if(isset($_SESSION['userlogin_admin'])) {
        include 'init.php';
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
        if($do == 'Manage') {
            $section = isset($_GET['section']) ? $_GET['section'] : 'Info';
            $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
            $perPage = 10;
            $count = countItem('id_article', 'article');            
            $pages = ceil($count / $perPage);
            $offset = $perPage * ($currentPage - 1);
            $stmt = $connect->prepare("SELECT 
                                            article.*,
                                            sous_categorie.nom_sous_categorie,
                                            sous_categorie.id_sous_categorie
                                        FROM 
                                            article
                                        LEFT JOIN 
                                            sous_categorie 
                                        ON
                                            sous_categorie.id_sous_categorie = article.id_sous_categorie
                                        ORDER BY 
                                            article.nom_article
                                        LIMIT $perPage OFFSET $offset");
            $stmt->execute();
            $items = $stmt->fetchAll(); 
            if($section == 'Info') { ?>
                <div class="items-container">
                    <div class="bg-gray-200 dash-title text-center mx-auto py-3">
                        <div class="row">
                            <div class="col-md-4">
                                <a href="items.php" class="float-left">
                                    <i class="fas fa-cog fa-2x text-gray-700"> Gestion de Produits</i>
                                </a>
                            </div>
                            <div class="col-md-8">
                                <form class="form-inline mt-2 mt-md-0 float-md-right d-none">
                                    <input
                                        class="form-control mr-sm-2 "
                                        type="text"
                                        placeholder="Rechercher"
                                        aria-label="Search"
                                    />
                                    <button class="btn btn-outline-info my-2 my-sm-1 fa fa-search" type="submit"></button>
                                </form>
                            </div>
                        </div>    
                    </div>
                    <a href="items.php?do=Add" class="btn btn-outline-primary add-btn">
                        <i class="fa fa-plus"></i>
                    </a>
                    <div class="float-right">  
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php
                                    $inactPrev = ($currentPage <= 1) ? 'disabled' : ''; 
                                    $inactNext = ($currentPage >= $pages) ? 'disabled' : ''; 
                                ?>
                                <li class="page-item pl-2 <?php echo $inactPrev ?>">
                                    <a 
                                        class="page-link" 
                                        href="items.php?page=<?php echo ($currentPage-1) ?>"
                                        aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>                            
                                <li class="page-item">
                                    <a class="page-link" href="">
                                        <?php echo 'Page: ' . $currentPage . ' sur ' . $pages ?>
                                    </a>
                                </li>                            
                                <li class="page-item <?php echo $inactNext ?>">
                                    <a 
                                        class="page-link" 
                                        href="items.php?page=<?php echo ($currentPage+1) ?>" 
                                        aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                                <li class="page-item disabled">
                                    <a class="page-link" href="" aria-label="">
                                        <span aria-hidden="true"><?php echo 'Total: ' . $count ?></span>
                                    </a>
                                </li>
                            </ul>
                            
                        </nav>
                    </div>
                    <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                            <tr>
                                <td>#ID</td>
                                <td>Nom</td>
                                <td>Prix</td>
                                <td>Dispo</td>
                                <td>MAJ-Prix</td>                         
                                <td>Sous-catégorie</td>
                                <td>Infos</td>
                                <td>Détails</td>
                                <td><i class="fa fa-comments"></i></td>
                                <td><i class="fa fa-cog"></i></td>
                            </tr>
                            <?php 
                                $i = 1;
                                $query = 'WHERE id_article = ?';
                                foreach($items as $item) {
                                    $parity = !($i % 2) ? 'odd' : 'even'; $i++;
                                    $comments = countItem('id_commentaire', 'commentaire', $query, $item['id_article']);
                                    echo '<tr class="'. $parity .'">';
                                        echo "<td>". $item['id_article'] ."</td>";
                                        echo "<td>". $item['nom_article'] ."</td>";
                                        echo "<td>". $item['prix_article'] ."</td>";
                                        echo "<td>". $item['nombre_exemplaire_article'] ."</td>";
                                        echo "<td>". $item['date_modif_prix_article'] ."</td>";
                                        echo "<td>". "[ID: ". $item['id_sous_categorie'] ."] - ";
                                            echo $item['nom_sous_categorie'];
                                        echo "</td>";
                                        echo "<td style='text-align: left'>";
                                            echo "<ul>";
                                                echo "<li>";
                                                    echo "<a href='items.php?do=Manage&section=Details&filter=Desc&itemid=";
                                                        echo $item['id_article'] ."'>";
                                                        echo "Description";
                                                    echo "</a>";
                                                echo "</li>";
                                                echo "<li>";
                                                    echo "<a href='items.php?do=Manage&section=Details&filter=Tech&itemid=";
                                                        echo $item['id_article'] ."'>";
                                                        echo "Fiche";
                                                    echo "</a>";
                                                echo "</li>";
                                            echo "</ul>";
                                        echo "</td>";
                                        echo "<td style='text-align: left'>";
                                            echo "<ul>";
                                                echo "<li>";
                                                    echo "<a href='items.php?do=Manage&section=Details&filter=History&itemid=";
                                                        echo $item['id_article'] ."&action=Show'>";
                                                        echo "Historique";
                                                    echo "</a>";
                                                echo "</li>";
                                                echo "<li>";
                                                    echo "<a href='items.php?do=Manage&section=Details&filter=Supply&itemid=";
                                                        echo $item['id_article'] ."'>";
                                                        echo "Approvisionement";
                                                echo "</a>";
                                                echo "</li>";
                                            echo "</ul>";
                                        echo "</td>";
                                        echo "<td>". $comments ."</td>";
                                        echo "<td>";
                                            echo "<a href='items.php?do=Edit&itemid=";
                                                echo $item['id_article'];
                                                echo "' class='btn btn-success btn-circle btn-sm'>";
                                                echo "<i class='fas fa-edit'></i>";
                                            echo "</a>";
                                            echo "<a href='items.php?do=Delete&itemid=";
                                                echo $item['id_article'];
                                                echo "' class='btn btn-danger btn-circle btn-sm confirm'>";
                                                echo "<i class='fas fa-times'></i>";
                                            echo "</a>";
                                        echo "</td>";                                
                                    echo '<tr>';
                                }
                            ?>
                        </table>
                    </div>
                    <a href="items.php?do=Add" class="btn btn-outline-primary add-btn">
                        <i class="fa fa-plus"></i>
                    </a>
                    <div class="float-right">
                        <nav aria-label="Page navigation example">                        
                            <ul class="pagination">
                                <?php
                                    $inactPrev = ($currentPage <= 1) ? 'disabled' : ''; 
                                    $inactNext = ($currentPage >= $pages) ? 'disabled' : ''; 
                                ?>
                                <li class="page-item pl-2 <?php echo $inactPrev ?>">
                                    <a 
                                        class="page-link" 
                                        href="items.php?page=<?php echo ($currentPage-1) ?>"
                                        aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>                            
                                <li class="page-item">
                                    <a class="page-link" href="">
                                        <?php echo 'Page: ' . $currentPage . ' sur ' . $pages ?>
                                    </a>
                                </li>                            
                                <li class="page-item <?php echo $inactNext ?>">
                                    <a 
                                        class="page-link" 
                                        href="items.php?page=<?php echo ($currentPage+1) ?>" 
                                        aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                                <li class="page-item disabled">
                                    <a class="page-link" href="" aria-label="">
                                        <span aria-hidden="true"><?php echo 'Total: ' . $count ?></span>
                                    </a>
                                </li>
                            </ul>                            
                        </nav>
                    </div>
                </div>
            <?php 
            } elseif($section == 'Details') {
                $filter = isset($_GET['filter']) ? $_GET['filter'] : 'Desc'; ?>
<?php           if($filter == 'Desc') {
                    $stmt = $connect->prepare("SELECT description_article FROM article WHERE id_article = ?");
                    $stmt->execute(array($_GET['itemid']));
                    $description = $stmt->fetch()['description_article'];
?>
                    <div class="container my-5 mx-auto p-4 bg-light border rounded-sm shadow-sm" style="margin-top: 100px !important;">
                        <p>
                            <?= $description ?>
                        </p>
                    </div>

<?php           } elseif($filter == 'Tech') {
                    $stmt = $connect->prepare("SELECT fiche_technique_article FROM article WHERE id_article = ?");
                    $stmt->execute(array($_GET['itemid']));
                    $fiche = $stmt->fetch()['fiche_technique_article'].'.xml';
?>
                    <div class="container-fluid my-5 mx-auto" style="margin-top: 100px !important;">
                        <?php
                            $directory = '../public/fiche technique/xml/'.$fiche;
                            if (file_exists($directory)) {
                                $xml = simplexml_load_file($directory);
                                echo "<div class='table-responsive border rounded-sm shadow-sm'>";
                                echo "<table class='table table-bordered description-table'>";
                                $i = 1;
                                foreach( $xml->children() as $element ) {
                                    $parity = !($i % 2) ? 'odd' : 'even'; $i++;
                                    echo '<tr class="'. $parity .'">';
                                    echo "<td>".$element->Attribut."</td><td>".$element->Valeur."</td>" ;
                                    echo "</tr>";
                                }
                                echo "</table>";
                                echo "</div>";
                            } else {
                                exit('Echec lors de l\'ouverture du fichier fiche.xml.');
                            }
                        ?>
                    </div>
<?php           } elseif($filter == 'History') { 
                    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
                    $action = isset($_GET['action']) ? $_GET['action'] : 'Show';
                    $itemStmt = $connect->prepare("SELECT * FROM article WHERE id_article = ?");                        
                    $itemStmt->execute(array($itemid));
                    $item = $itemStmt->fetch();
                    $count = $itemStmt->rowCount();
                    if ($count > 0) {
                        if($action == 'Show') {
                            $historyStmt = $connect->prepare("SELECT 
                                                                    * 
                                                                FROM 
                                                                    historique_article 
                                                                WHERE 
                                                                    id_article = ? 
                                                                ORDER BY
                                                                    id_historique_article DESC");                        
                            $historyStmt->execute(array($itemid));
                            $rows = $historyStmt->fetchAll();
                            ?>
                            <div class="items-container">
                                <div class="bg-gray-200 dash-title text-center mx-auto py-3">
                                    <a href="items.php">
                                        <i class="fas fa-history fa-2x text-gray-700">
                                            <?php 
                                                echo "Historique pour: ". $item['nom_article'];
                                                echo " [ID: ". $item['id_article'] ."]";
                                            ?>
                                        </i>
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table class="main-table text-center table table-bordered">
                                        <tr>
                                            <td>#ID</td>
                                            <td>Prix de sortie</td>
                                            <td>Nombre d'articles vendus</td>
                                            <td>Date de debut</td>
                                            <td>Date de fin</td>
                                            <td><i class="fa fa-cog"></i></td>
                                        </tr>
                                        <?php 
                                            foreach($rows as $row) {                                        
                                                echo '<tr>';
                                                    echo "<td>". $row['id_historique_article'] ."</td>";
                                                    echo "<td>". $row['prix_sortie'] ."</td>";
                                                    echo "<td>". $row['nombre_article_vendu'] ."</td>";
                                                    echo "<td>". $row['date_debut'] ."</td>";
                                                    echo "<td>". $row['date_fin'] ."</td>";
                                                    echo "<td>";
                                                        echo "<a href='items.php?do=Manage&page=Details&filter=History&itemid=";
                                                            echo $row['id_article'] ."&action=Delete&histid=";
                                                            echo $row['id_historique_article'];
                                                            echo "' class='btn btn-danger btn-circle btn-sm confirm'>";
                                                            echo "<i class='fas fa-times'></i>";
                                                        echo "</a>";
                                                    echo "</td>";                                
                                                echo '<tr>';
                                            }
                                        ?>
                                    </table>
                                </div>
                                <div>
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">1</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">2</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">3</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
<?php
                        } elseif($action == 'Delete') {
                            $histid = isset($_GET['histid']) && is_numeric($_GET['histid']) ? intval($_GET['histid']) : 0;
                            echo "<div class='container alert alert-success'>Hello from 'Delete History Page'</div>";
                            echo "<div class='container alert alert-info'>History ID = ". $histid ."</div>";
                        } else {
                            redirect('items.php');
                        }                
                    } else {
                        $Msg = "<div class='container alert alert-danger'>
                                    ID invalide.
                                </div>";
                        redirect($Msg, 'back');
                    }  
                } elseif($filter == 'Supply') {     
                    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
                    $action = isset($_GET['action']) ? $_GET['action'] : 'Show';
                    $itemStmt = $connect->prepare("SELECT * FROM article WHERE id_article = ?");                        
                    $itemStmt->execute(array($itemid));
                    $item = $itemStmt->fetch();
                    $count = $itemStmt->rowCount();
                    if ($count > 0) { 
                        if($action == 'Show') {
                            $supplyStmt = $connect->prepare("SELECT
                                                                    * 
                                                                FROM
                                                                    approvisionement 
                                                                WHERE 
                                                                    id_article = ? 
                                                                ORDER BY 
                                                                    id_approvisionement DESC"); 
                            $supplyStmt->execute(array($itemid));
                            $rows = $supplyStmt->fetchAll();
                            ?>
                            <div class="items-container">
                                <div class="bg-gray-200 dash-title text-center mx-auto py-3">
                                    <a href="items.php">
                                        <i class="fas fa-tag fa-2x text-gray-700">
                                            <?php 
                                                echo "Approvisionements pour: ". $item['nom_article'];
                                                echo " [ID: ". $item['id_article'] ."]";
                                            ?>
                                        </i>
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table class="main-table text-center table table-bordered">
                                        <tr>
                                            <td>#ID</td>
                                            <td>Quantité</td>
                                            <td>Date</td>
                                            <td>Prix Entrée</td>
                                            <td><i class="fa fa-cog"></i></td>
                                        </tr>
                                        <?php 
                                            foreach($rows as $row) {                                        
                                                echo '<tr>';
                                                    echo "<td>". $row['id_approvisionement'] ."</td>";
                                                    echo "<td>". $row['quantite_approvisionement'] ."</td>";
                                                    echo "<td>". $row['date_approvisionement'] ."</td>";
                                                    echo "<td>". $row['prix_entree'] ."</td>";
                                                    echo "<td>";
                                                        if( $row['etat_approvisionement'] == 'EN_ATTENTE' ) {
                                                            echo "<a href='items.php?do=Manage&page=Details&filter=Supply&itemid=";
                                                                echo $itemid ."&action=Activate&apprid=";
                                                                echo $row['id_approvisionement'];
                                                                echo "' class='btn btn-info btn-circle btn-sm confirm'>";
                                                                echo "<i class='fas fa-check'></i>";
                                                            echo "</a>";
                                                            echo "<a href='items.php?do=Manage&page=Details&filter=Supply&itemid=";
                                                                echo $itemid ."&action=Edit&apprid=";
                                                                echo $row['id_approvisionement'];
                                                                echo "' class='btn btn-success btn-circle btn-sm'>";
                                                                echo "<i class='fas fa-edit'></i>";
                                                            echo "</a>";
                                                            echo "<a href='items.php?do=Manage&page=Details&filter=Supply&itemid=";
                                                                echo $itemid ."&action=Delete&apprid=";
                                                                echo $row['id_approvisionement'];
                                                                echo "' class='btn btn-danger btn-circle btn-sm confirm'>";
                                                                echo "<i class='fas fa-times'></i>";
                                                            echo "</a>";
                                                        }                                                        
                                                    echo "</td>";             
                                                echo '<tr>';
                                            }
                                        ?>
                                    </table>
                                </div>
                                <div>
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">1</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">2</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">3</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                                <a href="items.php?do=Manage&page=Details&filter=Supply&
                                        itemid=<?php  echo $row['id_article'] ?>&action=Add"
                                    class="btn btn-primary add-btn">
                                    <i class="fa fa-plus"></i> Ajouter
                                </a>
                            </div>
<?php
                        } elseif ($action == 'Add') { ?>
                            <div style="height: 40px"></div>
                            <div class='container'>
                                <div class="bg-gray-200 dash-title text-center mx-auto py-3">
                                    <a href="#">
                                        <i class="fas fa-plus fa-2x text-gray-700"> Nouveau approvisionement</i>
                                    </a>
                                </div>
                                <form action="?do=Manage&page=Details&filter=Supply&itemid=<?php echo $itemid ?>&action=Insert" method="POST">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Produit</label>
                                            <select class="form-control" name="itemid">
                                                <?php
                                                    echo "<option value='". $item['id_article'] ."'>";
                                                        echo "[ID: ". $item['id_article'] ."] ". $item['nom_article'];
                                                    echo "</option>";
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Quantité d'approvisionement</label>
                                            <input 
                                                type="number" 
                                                class="form-control" 
                                                name="quantite" 
                                                placeholder="Quantité approvisionée du produit" 
                                                min="0"
                                                required="required">
                                            </input>
                                        </div>
                                    </div>   
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Prix unitaire d'achat</label>
                                            <input 
                                                type="number" 
                                                class="form-control" 
                                                name="prixunitEntree" 
                                                placeholder="Prix unitaire d'entrée (approvisionement)" 
                                                min="0"
                                                required="required">
                                            </input>
                                        </div>
                                    </div>
                                    <button 
                                        type="submit" 
                                        class="btn btn-primary" 
                                        style="margin-top: 20px">Ajouter
                                    </button>
                                </form>
                            </div>
<?php
                        } elseif($action == 'Insert') {
                            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                                echo '<div class ="container" style="margin-top: 100px">';                
                                $itemid      = $_POST['itemid'];
                                $quantite    = $_POST['quantite'];
                                $prixEntree  = $_POST['prixunitEntree']; 
                                // Insertion de l'approvisionement
                                $stmt = $connect->prepare("INSERT INTO approvisionement(
                                                                                        quantite_approvisionement,
                                                                                        date_approvisionement,
                                                                                        prix_entree,
                                                                                        id_article)
                                                                VALUES(:zquantite, :zdate, :zprix, :zitemid)");            
                                $stmt->execute(array(  'zquantite'  => $quantite,
                                                        'zdate'     => date("Y-m-d H:i:s"),
                                                        'zprix'     => $prixEntree,
                                                        'zitemid'   => $itemid  ));            
                                $Msg = "<div class='container alert alert-success'>
                                            Approvisionement ajouté avec succes.
                                        </div>";            
                                redirect($Msg, 'items.php', 4);   
                            } else {
                                $Msg = "<div class='container alert alert-danger'>
                                            Vous ne pouvez pas acceder à cette page directement.
                                        </div>";
                                redirect($Msg, 'index.php', 6);                                
                            }
                            echo '</div>';
                        } elseif($action == 'Edit') {
                            $apprid = isset($_GET['apprid']) && is_numeric($_GET['apprid']) ? intval($_GET['apprid']) : 0;
                            $stmt = $connect->prepare("SELECT * FROM approvisionement WHERE id_approvisionement = ? ");
                            $stmt->execute(array($apprid));
                            $row = $stmt->fetch();
                            $count = $stmt->rowCount();                
                            if ($count > 0) {
                ?>
                                <div style="height: 40px"></div>
                                <div class='container'>
                                    <div class="bg-gray-200 dash-title text-center mx-auto py-3">
                                        <a href="#">
                                            <i class="fas fa-cog fa-2x text-gray-700"> Modification de l'approvisionnement</i>
                                        </a>
                                    </div>
                                    <form action="?do=Manage&page=Details&filter=Supply&itemid=<?php echo $itemid ?>&action=Update" method="POST">
                                        <input type="hidden" name="apprid" value="<?php echo $apprid ?>"></input>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Produit</label>
                                                <select class="form-control" name="itemid">
                                                    <?php
                                                        echo "<option value='". $item['id_article'] ."'>";
                                                            echo "[ID: ". $item['id_article'] ."] ". $item['nom_article'];
                                                        echo "</option>";
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Quantité d'approvisionement</label>
                                                <input 
                                                    type="number" 
                                                    class="form-control" 
                                                    name="quantite" 
                                                    value="<?php echo $row['quantite_approvisionement'] ?>"
                                                    placeholder="Quantité approvisionée du produit" 
                                                    min="0"
                                                    required="required">
                                                </input>
                                            </div>
                                        </div>   
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Prix unitaire d'achat</label>
                                                <input 
                                                    type="number" 
                                                    class="form-control" 
                                                    name="prixunitEntree" 
                                                    value="<?php echo $row['prix_entree'] ?>"
                                                    placeholder="Prix unitaire d'entrée (approvisionement)" 
                                                    min="0"
                                                    required="required">
                                                </input>
                                            </div>
                                        </div>                                 
                                        <button 
                                            type="submit" 
                                            class="btn btn-primary" 
                                            style="margin-top: 20px">Enregistrer
                                        </button>
                                    </form>
                                </div>
<?php   
                            } else {                
                                $Msg = "<div class='container alert alert-danger'>
                                            ID invalide.
                                        </div>";                
                                redirect($Msg, 'back');
                            }
                        } elseif($action == 'Update') {
                            echo '<div class ="container" style="margin-top: 100px">';
                            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $apprid          = $_POST['apprid'];
                                $quantite        = $_POST['quantite'];
                                $prixunitEntree  = $_POST['prixunitEntree'];
                                $stmt = $connect->prepare("SELECT * FROM approvisionement WHERE id_approvisionement = ?");
                                $stmt->execute(array($apprid));
                                $row = $stmt->fetch();
                                $stmt = $connect->prepare("UPDATE 
                                                                approvisionement 
                                                            SET 
                                                                quantite_approvisionement = ?,
                                                                prix_entree = ?
                                                            WHERE 
                                                                id_approvisionement = ?");
                                $stmt->execute(array($quantite, $prixunitEntree, $apprid));
                                $Msg = '<div class="container alert alert-success">
                                            Approvisionement mis à jour avec succes.
                                        </div>';
                                redirect($Msg, 'items.php');
                            } else {
                                redirect('', 2);
                            }
                            echo '</div>';
                        } elseif ($action == 'Activate') {
                            echo '<div class ="container" style="margin-top: 100px">';
                            $apprid = isset($_GET['apprid']) && is_numeric($_GET['apprid']) ? intval($_GET['apprid']) : 0;
                            $check = checkItem('id_approvisionement', 'approvisionement', $apprid);
                            if ($check > 0) {
                                $stmt = $connect->prepare("SELECT * FROM approvisionement WHERE id_approvisionement = ? ");
                                $stmt->execute(array($apprid));
                                $row = $stmt->fetch();
                                $stmt = $connect->prepare("UPDATE 
                                                                approvisionement 
                                                            SET 
                                                                etat_approvisionement = ?
                                                            WHERE 
                                                                id_approvisionement = ?");
                                $stmt->execute(array('EN_COURS', $apprid));                            
                                $newQte = $item['nombre_exemplaire_article'] + $row['quantite_approvisionement'];
                                // Mise a jour de nombres d'articles disponibles en lignes
                                $stmt1 = $connect->prepare("UPDATE 
                                                                article 
                                                            SET 
                                                                nombre_exemplaire_article = ?
                                                            WHERE 
                                                                id_article = ?");
                                $stmt1->execute(array($newQte , $itemid));
                                $Msg = '<div class="container alert alert-success">
                                            Approvisionement mis en ligne avec succes.
                                        </div>';
                                redirect($Msg, 'items.php');
                            } else {
                                $Msg = '<div class="container alert alert-danger">
                                            ID invalide
                                        </div>';
                                redirect($Msg);
                            }                       
                            echo '</div>';
                        } elseif ($action == 'Delete') {
                            echo '<div class ="container" style="margin-top: 100px">';
                            $apprid = isset($_GET['apprid']) && is_numeric($_GET['apprid']) ? intval($_GET['apprid']) : 0;
                            $check = checkItem('id_approvisionement', 'approvisionement', $apprid);
                            if ($check > 0) {
                                $stmt = $connect->prepare("SELECT * FROM approvisionement WHERE id_approvisionement = ? ");
                                $stmt->execute(array($apprid));
                                $row = $stmt->fetch();
                                if( $row['etat_approvisionement'] == 'EN_ATTENTE' ) {
                                    $stmt = $connect->prepare("DELETE FROM 
                                                                    approvisionement 
                                                                WHERE 
                                                                    id_approvisionement = ?");
                                    $stmt->execute(array( $apprid ));
                                    $Msg = '<div class="container alert alert-success">
                                                Approvisionement supprimé avec succes.
                                            </div>';
                                    redirect($Msg, 'items.php');
                                } else {                                    
                                    redirect('items.php');
                                }
                            } else {
                                $Msg = '<div class="container alert alert-danger">
                                            ID invalide
                                        </div>';
                                redirect($Msg);
                            }                       
                            echo '</div>';
                        } else {
                            redirect('items.php');
                        }
                    } else {
                        $Msg = "<div class='container alert alert-danger'>
                                    ID invalide.
                                </div>";
                        redirect($Msg, 'back');
                    }
                } else {
                    redirect('items.php');
                }
            } else {
                redirect('items.php');
            }
        } elseif($do == 'Add') {
            // Select sCategories For The Select Form
            $stmt = $connect->prepare("SELECT * FROM sous_categorie");
            $stmt->execute();
            $scats = $stmt->fetchAll();
            ?>
            <div style="height: 40px"></div>
            <div class='container'>
                <div class="bg-gray-200 dash-title text-center mx-auto py-3">
                    <a href="items.php?do=Add">
                        <i class="fas fa-plus fa-2x text-gray-700"> Nouveau produit</i>
                    </a>
                </div>
                <form action="?do=Insert" method="POST">
                    <div class="row justify-content-around">
                        <div class="col-md-5">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Sous-Catégorie</label>
                                    <select class="form-control" name="souscategorie">
                                        <?php
                                            foreach($scats as $scat)
                                            {
                                                echo "<option value='". $scat['id_sous_categorie'] ."'>";
                                                    echo $scat['nom_sous_categorie'];
                                                echo "</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Nom</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        name="nom" 
                                        placeholder="Nom du produit" 
                                        required="required">
                                    </input>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Prix unitaire d'achat</label>
                                    <input 
                                        type="number" 
                                        class="form-control" 
                                        name="prixunitEntree" 
                                        placeholder="Prix unitaire d'entrée (approvisionement)" 
                                        min="0"
                                        required="required">
                                    </input>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Prix unitaire de vente</label>
                                    <input 
                                        type="number" 
                                        class="form-control" 
                                        name="prixunitSortie" 
                                        placeholder="Prix unitaire du sortie" 
                                        min="0"
                                        required="required">
                                    </input>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Quantité approvisionée</label>
                                    <input 
                                        type="number" 
                                        class="form-control" 
                                        name="quantite" 
                                        placeholder="Quantité approvisionée du produit" 
                                        min="0"
                                        required="required">
                                    </input>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Description</label>
                                    <textarea 
                                        class="form-control" 
                                        rows="5"   
                                        name="description" 
                                        required="required"
                                        placeholder="Description du produit">
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Marque</label>
                                    <select  class="form-control"  name="marque">
                                        <?php
                                            $allMarque=$connect->query("SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE  
                                                TABLE_SCHEMA = 'hwshop'AND TABLE_NAME='article' AND COLUMN_NAME='marque_article';");
                                            $allMarque=$allMarque->fetch(PDO::FETCH_ASSOC);
                                            $result=explode("enum(", $allMarque['COLUMN_TYPE']);
                                            $result=explode(")", $result[1]);
                                            $result=explode(",", $result[0]);
                                            sort( $result);
                                            $allOption='';
                                            
                                            foreach(  $result as $element  ){
                                                $without_quotes=(explode("'", $element ))[1];
                                                if($without_quotes=='AUTRE')
                                                    $allOption .='<option  value="'.$without_quotes.'" selected>'.$without_quotes.'</option> ';
                                                else
                                                    $allOption .='<option  value="'.$without_quotes.'">'.$without_quotes.'</option> ';
                                            }
                                            echo $allOption;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2"></div>
                        <div class="col-md-5">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="control-label">Fiche technique</label>
                                    <input 
                                        type="text" 
                                        class="form-control"
                                        name="fiche" 
                                        required="required"
                                        placeholder="nom du fichier sans l extension .xml">
                                    </input>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="control-label">Images</label>
                                    <input 
                                        type="file"
                                        class="form-control-file"
                                        name="images[]" 
                                        required="required"
                                        placeholder="Emplacement du fichier" multiple>
                                    </input>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="control-label">Filtre</label>
                                    <div id="display-filtre"style="min-height: 180px;" ></div> 
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label >Fiche Technique</label>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <button 
                                                type="button" 
                                                class="btn btn-secondary btn-sm m-2 addchamp">Ajouter ligne
                                            </button>
                                        </div>
                                    </div>
                                    <div class="div-champ form-row justify-content-around">
                                        <input 
                                            type="text"
                                            class="form-control col-md-6"
                                            name="champ" 
                                            placeholder="champ" >
                                        </input>
                                        <input 
                                            type="text" 
                                            class="form-control col-md-6" 
                                            name="valeur" 
                                            placeholder="valeur" >
                                        </input>
                                    </div>
                                    <label class="control-label">Nom de la fiche technique</label>
                                    <input 
                                        type="text" 
                                        class="form-control d-inline-block w-75"
                                        name="nomfichier" 
                                        placeholder="nom du fichier sans l extension .xml">
                                    </input>                        
                                    <button
                                        type="button" 
                                        class="btn btn-secondary btn-sm float-right mt-4 creer-fichier">Creer Fiche Technique
                                    </button>
                                </div>                   
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row justify-content-center pb-5">
                        <button 
                            type="submit" 
                            class="btn btn-primary" 
                            style="margin-top: 20px">Ajouter
                        </button>
                    </div>                    
                </form>
            </div>
<?php   } elseif($do == 'Insert') {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                echo '<div class ="container" style="margin-top: 100px">';
                $nom              = $_POST['nom'];
                $prixEntree       = $_POST['prixunitEntree'];
                $prixSortie       = $_POST['prixunitSortie'];
                $quantite         = $_POST['quantite'];
                $description      = $_POST['description'];
                $caracteristique  = $_POST['caracteristique'];
                $fiche            = $_POST['fiche'];
                $scatid = isset($_POST['souscategorie']) && is_numeric($_POST['souscategorie']) ? intval($_POST['souscategorie']) : 0;
                $query = "AND id_sous_categorie = ?";
                $count = checkItem("nom_article", "article", $nom, $query, $scatid);
                if($count == 0) {
                    // Insertion  du nouveau produit
                    $stmt = $connect->prepare(
                        "INSERT INTO article(
                                            nom_article,
                                            prix_article, 
                                            nombre_exemplaire_article, 
                                            description_article, 
                                            caracteristique_article, 
                                            date_modif_prix_article,
                                            fiche_technique_article,
                                            id_sous_categorie) 
                                        VALUES( 
                                            :znom, 
                                            :zprix, 
                                            :zquantite, 
                                            :zdescription, 
                                            :zcaracteristique, 
                                            :zdate, 
                                            :zfiche, 
                                            :zscatid)");
                    $stmt->execute(array(
                        'znom'             => $nom,
                        'zprix'            => $prixSortie,
                        'zquantite'        => $quantite,
                        'zdescription'     => $description,
                        'zcaracteristique' => $caracteristique,
                        'zdate'            => date("Y-m-d H:i:s"),
                        'zfiche'           => $fiche,
                        'zscatid'          => $scatid
                    ));
                    $itemid = $connect->lastInsertId();
                    // Creation de la premiere historique de produit
                    $stmt1 = $connect->prepare("INSERT INTO historique_article(
                                                                            prix_sortie,
                                                                            nombre_article_vendu,
                                                                            date_debut,
                                                                            id_article)
                                                    VALUES(:zprix, 0, :zdate, :zitemid)");
                    $stmt1->execute(array(  'zprix'   => $prixSortie,
                                            'zdate'   => date("Y-m-d H:i:s"),
                                            'zitemid' => $itemid ));
                    // Insertion de l'approvisionement
                    $stmt2 = $connect->prepare("INSERT INTO approvisionement(
                                                                            quantite_approvisionement,
                                                                            date_approvisionement,
                                                                            prix_entree,
                                                                            etat_approvisionement,
                                                                            id_article)
                                                    VALUES(:zquantite, :zdate, :zprix, :zetat, :zitemid)");
                                                    $stmt2->execute(array(  'zquantite' => $quantite,
                                                                            'zdate'     => date("Y-m-d H:i:s"),
                                                                            'zprix'     => $prixEntree,
                                                                            'zetat'     => 'EN_COURS',
                                                                            'zitemid'   => $itemid  ));
                    $Msg = "<div class='container alert alert-success'>
                                Produit ajouté avec succes.
                            </div>";
                    redirect($Msg, 'items.php', 4);
                } elseif($count > 0) {
                    $Msg = "<div class='container alert alert-danger'>
                                Ce produit existe déja.
                            </div>";
                    redirect($Msg, 'back', 4);
                } 
            } else {
                $Msg = "<div class='container alert alert-danger'>
                            Vous ne pouvez pas acceder à cette page directement.
                        </div>";
                redirect($Msg, 'index.php', 6);                
            }
            echo '</div>';            
        } elseif($do == 'Edit') {
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
            $stmt = $connect->prepare("SELECT * FROM article WHERE id_article = ? ");
            $stmt->execute(array($itemid));
            $item = $stmt->fetch();
            $count = $stmt->rowCount();
            if ($count > 0) {
                // Select sCategories For The Select Form
                $scatStmt = $connect->prepare("SELECT * FROM sous_categorie");
                $scatStmt->execute();
                $scats = $scatStmt->fetchAll();
?>
                <div style="height: 40px"></div>
                <div class='container'>
                    <div class="bg-gray-200 dash-title text-center mx-auto py-3">
                        <a href="#">
                            <i class="fas fa-cog fa-2x text-gray-700"> Modification produit</i>
                        </a>
                    </div>
                    <form action="?do=Update" method="POST">
                        <input type="hidden" name="itemid" value="<?php echo $itemid ?>"></input>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Sous-Catégorie</label>
                                <select class="form-control" name="souscategorie">
                                    <?php
                                        foreach($scats as $scat)
                                        {
                                            if($scat['id_sous_categorie'] == $item['id_sous_categorie']) {
                                                echo "<option value='" . $scat['id_sous_categorie'] ."' selected >";
                                                    echo $scat['nom_sous_categorie'];
                                                echo "</option>";
                                            } else {                                                
                                                echo "<option value='" . $scat['id_sous_categorie'] ."'>";
                                                    echo $scat['nom_sous_categorie'];
                                                echo "</option>";
                                            }                                            
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nom</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    name="nom" 
                                    value="<?php echo $item['nom_article'] ?>"
                                    placeholder="Nom du produit" 
                                    required="required">
                                </input>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Prix unitaire</label>
                                <input 
                                    type="number" 
                                    class="form-control" 
                                    name="prixunit" 
                                    value="<?php echo $item['prix_article'] ?>"
                                    placeholder="Prix unitaire du produit" 
                                    required="required">
                                </input>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nombre</label>
                                <input 
                                    type="number" 
                                    class="form-control" 
                                    name="nombre" 
                                    value="<?php echo $item['nombre_exemplaire_article'] ?>"
                                    placeholder="Nombre d'exemplaire du produit" 
                                    required="required">
                                </input>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Description</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    name="description" 
                                    value="<?php echo $item['description_article'] ?>"
                                    placeholder="Description du produit">
                                </input>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Caractéristique</label>
                                <input 
                                    type="text" 
                                    class="form-control"
                                    name="caracteristique" 
                                    value="<?php echo $item['caracteristique_article'] ?>"
                                    placeholder="Emplacement du fichier de 'caractéristique.xml'">
                                </input>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Fiche technique</label>
                                <input 
                                    type="text"
                                    class="form-control" 
                                    name="fiche" 
                                    value="<?php echo $item['fiche_technique_article'] ?>"
                                    placeholder="Emplacement du fichier 'fiche_technique.xml'">
                                </input>
                            </div>
                        </div>                                
                        <button 
                            type="submit" 
                            class="btn btn-primary" 
                            style="margin-top: 20px">Enregistrer
                        </button>
                    </form>
                </div>
<?php   
            } else {
                $Msg = "<div class='container alert alert-danger'>
                            ID invalide.
                        </div>";
                redirect($Msg, 'back');
            }            
        } elseif($do == 'Update') {
            echo '<div class ="container" style="margin-top: 100px">';
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $itemid = $_POST['itemid'];
                $stmt1 = $connect->prepare("SELECT * FROM article WHERE id_article = ?");
                $stmt1->execute(array($itemid));
                $item = $stmt1->fetch();
                $oldPrice        = $item['prix_article'];
                $oldDate         = $item['date_modif_prix_article'];
                $nom             = $_POST['nom'];
                $prixunit        = $_POST['prixunit'];
                $nombre          = $_POST['nombre'];
                $description     = $_POST['description'];
                $caracteristique = $_POST['caracteristique'];
                $fiche           = $_POST['fiche'];
                $stmt2 = $connect->prepare("UPDATE 
                                                article 
                                            SET 
                                                nom_article = ?,
                                                prix_article = ?,
                                                nombre_exemplaire_article = ?,
                                                description_article = ?,
                                                caracteristique_article = ?,
                                                date_modif_prix_article = ?,
                                                fiche_technique_article = ?
                                            WHERE 
                                                id_article = ?");
                if( $prixunit == $oldPrice ) {
                    $stmt2->execute(array(
                                        $nom, 
                                        $prixunit, 
                                        $nombre, 
                                        $description, 
                                        $caracteristique, 
                                        $oldDate, 
                                        $fiche, 
                                        $itemid)); 
                } else {
                    $stmt2->execute(array(
                                        $nom, 
                                        $prixunit, 
                                        $nombre,
                                        $description, 
                                        $caracteristique, 
                                        date("Y-m-d H:i:s"), 
                                        $fiche, 
                                        $itemid));
                    // Recuperation de la derniere historique de ce produit
                    $stmt3 = $connect->prepare("SELECT 
                                                    * 
                                                FROM 
                                                    historique_article
                                                WHERE 
                                                    id_article = ? 
                                                ORDER BY 
                                                    id_historique_article DESC
                                                LIMIT 1");
                    $stmt3->execute(array($itemid));
                    $row = $stmt3->fetch();
                    $lastHistoryId = $row['id_historique_article'];
                    // Mise a jour de la date de fin de l'historique
                    $stmt4 = $connect->prepare("UPDATE 
                                                    historique_article 
                                                SET 
                                                    date_fin = ? 
                                                WHERE 
                                                    id_historique_article = ?");
                    $stmt4->execute(array(date("Y-m-d H:i:s"), $lastHistoryId));
                    // Creation de la nouvelle historique avec le nouveau prix
                    $stmt5 = $connect->prepare("INSERT INTO historique_article(
                                                                            prix_sortie,
                                                                            date_debut,
                                                                            nombre_article_vendu,
                                                                            id_article)
                                                    VALUES(:zprix, :zdate, 0, :zitemid)");
                    $stmt5->execute(array(  'zprix'   => $prixunit,
                                            'zdate'   => date("Y-m-d H:i:s"),
                                            'zitemid' => $itemid ));
                }
                $Msg = '<div class="container alert alert-success">
                            Produit mis à jour avec succes.
                        </div>';
                redirect($Msg, 'items.php');
            } else {
                redirect('', 2);
            }
            echo '</div>';            
        } elseif($do == 'Delete') {
            echo '<div class ="container" style="margin-top: 100px">';
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
            $check = checkItem('id_article', 'article', $itemid);
            if ($check > 0) {
                // Suppression des approvisionements de cet article
                $stmtAppr = $connect->prepare("DELETE FROM
                                                        approvisionement
                                                WHERE id_article = :zitemid");
                $stmtAppr->bindParam(":zitemid", $itemid);
                $stmtAppr->execute();
                // Suppression des historiques de cet article
                $stmtHis = $connect->prepare("DELETE FROM 
                                                        historique_article
                                                WHERE id_article = :zitemid");
                $stmtHis->bindParam(":zitemid", $itemid);
                $stmtHis->execute();
                // Suppression des quantité commandés de cet article
                $stmtHis = $connect->prepare("DELETE FROM 
                                                        quantite_commande
                                                WHERE id_article = :zitemid");
                $stmtHis->bindParam(":zitemid", $itemid);
                $stmtHis->execute();
                // Suppression de l'article de la table article
                $stmt = $connect->prepare("DELETE FROM article 
                                            WHERE id_article = :zitemid");
                $stmt->bindParam(":zitemid", $itemid);
                $stmt->execute();                
                $Msg = "<div class='container alert alert-success'>
                            Article supprimée.
                        </div>";
                redirect($Msg, 'items.php', 4);
            } else {
                $Msg = '<div class="container alert alert-danger">
                            ID invalide
                        </div>';
                redirect($Msg);
            }
            echo '</div>';
        }
        include $tpl . 'footer.php';
    } else {
        header("Location: index.php");
        exit();
    }
    ob_end_flush();
?>