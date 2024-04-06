<?php
    ob_start();
    session_start();
    $pageTitle = 'Catégories';
    if(isset($_SESSION['userlogin_admin'])) {
        include 'init.php';
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
        if($do == 'Manage') {
            $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
            $count = countItem('id_categorie', 'categorie');
            $perPage = 3;
            $pages = ceil($count / $perPage);
            $offset = $perPage * ($currentPage - 1);
            $stmt = $connect->prepare("SELECT 
                                            * 
                                        FROM 
                                            categorie 
                                        ORDER BY 
                                            nom_categorie 
                                        LIMIT $perPage OFFSET $offset");
            $stmt->execute();
            $cats = $stmt->fetchAll(); 
?>
            <div class="cat-container">
                <div class="bg-gray-200 dash-title dash-title-cat text-center mx-auto py-3">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="categories.php" class="d-inline-flex float-left">
                                <i class="fas fa-angle-right fa-2x ml-2"> Catégories</i>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <form class="form-inline mt-2 mt-md-1 mx-auto d-none">
                                <input
                                    class="form-control mr-sm-2"
                                    type="text"
                                    placeholder="Rechercher"
                                    aria-label="Search"
                                />
                                <button class="btn btn-outline-info my-2 my-sm-1 fa fa-search" type="submit"></button>
                            </form>                
                        </div>
                        <div class="col-md-4">
                            <a href="sousCategories.php" class="float-right">
                                <i class="fas fa-2x"> Sous-Catégories</i>
                            </a>
                        </div>
                    </div>                    
                </div>
                <a href="categories.php?do=Add" class="btn btn-outline-primary add-btn">
                    <i class="fa fa-plus"></i>
                </a> 
                <div class="float-right"> 
                    <nav aria-label="Page navigation example">                        
                        <ul class="pagination float-right">
                            <?php
                                $inactPrev = ($currentPage <= 1) ? 'disabled' : ''; 
                                $inactNext = ($currentPage >= $pages) ? 'disabled' : ''; 
                            ?>
                            <li class="page-item pl-2 <?php echo $inactPrev ?>">
                                <a 
                                    class="page-link" 
                                    href="categories.php?page=<?php echo ($currentPage-1) ?>"
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
                                    href="categories.php?page=<?php echo ($currentPage+1) ?>" 
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
                        <tr class="">
                            <td>#ID</td>
                            <td>Nom</td>
                            <td>Description</td>
                            <td>SousCatégories</td>
                            <td><i class="fa fa-cog"></i></td>
                        </tr>
                        <?php 
                            $i = 1;
                            foreach($cats as $cat) {
                                $parity = !($i % 2) ? 'odd' : 'even'; $i++;
                                echo '<tr class="'. $parity .'">';
                                    echo "<td>" . $cat['id_categorie'] . "</td>";
                                    echo "<td>" . $cat['nom_categorie'] . "</td>";
                                    echo "<td>" . $cat['description_categorie'] . "</td>";
                                    echo "<td>";
                                        $scatStmt = $connect->prepare("SELECT * FROM
                                                                            sous_categorie
                                                                        WHERE 
                                                                            id_categorie = ?
                                                                        ORDER BY 
                                                                            nom_sous_categorie");
                                        $scatStmt->execute(array($cat['id_categorie']));
                                        $scats = $scatStmt->fetchAll();
                                        echo "<ul style='text-align: left !important;'>";
                                            foreach($scats as $scat) {
                                                echo "<li>";
                                                    echo "[ID: ". $scat['id_sous_categorie'] ."] ";
                                                    echo $scat['nom_sous_categorie'];
                                                echo "</li>";
                                            }
                                        echo "</ul>";
                                    echo "</td>";
                                    echo "<td>";
                                        echo "<a href='categories.php?do=Edit&catid=";
                                            echo $cat['id_categorie'] ."' class='btn btn-success btn-circle btn-sm'>";
                                            echo "<i class='fas fa-edit'></i>";
                                        echo "</a>";
                                        echo "<a href='categories.php?do=Delete&catid=";
                                            echo $cat['id_categorie'] ."' class='btn btn-danger btn-circle btn-sm confirm'>";
                                            echo "<i class='fas fa-times'></i>";
                                        echo "</a>";
                                    echo "</td>";                                
                                echo '<tr>';
                            }
                        ?>
                    </table>
                </div>
                <a href="categories.php?do=Add" class="btn btn-outline-primary add-btn">
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
                                    href="categories.php?page=<?php echo ($currentPage-1) ?>"
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
                                    href="categories.php?page=<?php echo ($currentPage+1) ?>" 
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

<?php   } elseif($do == 'Add') { ?>

            <div style="height: 40px"></div>
            <div class='container'>
                <div class="bg-gray-200 dash-title text-center mx-auto py-3">
                    <a href="categories.php?do=Add">
                        <i class="fas fa-plus fa-2x text-gray-700"> Nouvelle catégorie</i>
                    </a>
                </div>
                <form action="?do=Insert" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Nom</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                name="nom" 
                                placeholder="Nom de la catégorie" 
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
                                name="description" >
                            </input>
                        </div>
                    </div>
                            
                    <button 
                        type="submit" 
                        class="btn btn-primary add-btn" 
                        style="margin-top: 20px">Ajouter
                    </button>
                </form>
            </div>

<?php   } elseif($do == 'Insert') {

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                echo '<div class ="container" style="margin-top: 100px">';

                $nom           = $_POST['nom'];
                $description   = $_POST['description'];

                $count = checkItem("nom_categorie", "categorie", $nom);

                if($count == 0) {

                    $stmt = $connect->prepare("INSERT INTO categorie(
                                                                    nom_categorie, 
                                                                    description_categorie) 
                                                            VALUES(:znom, :zdescription)");
                    $stmt->execute(array(
                        'znom'         => $nom,
                        'zdescription' => $description
                    ));

                    $Msg = "<div class='container alert alert-success'>
                                Catégorie ajouté avec succes.
                            </div>";

                    redirect($Msg, 'categories.php', 4);

                } elseif($count > 0) {

                    $Msg = "<div class='container alert alert-danger'>
                                Cette catégorie existe déja.
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
            
        } elseif($do == 'Update') {

            echo '<div class ="container" style="margin-top: 100px">';

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                $catid        = $_POST['catid'];
                $nom          = $_POST['nom'];
                $description  = $_POST['description'];

                $stmt = $connect->prepare("UPDATE 
                                                categorie 
                                            SET 
                                                nom_categorie = ?,
                                                description_categorie = ?
                                            WHERE 
                                                id_categorie = ?");

                $stmt->execute(array($nom, $description, $catid));

                $Msg = '<div class="container alert alert-success">
                            Catégorie mis a jour avec succes.
                        </div>';

                redirect($Msg, 'categories.php');

            } else {

                redirect('', 2);

            }

            echo '</div>';
            
        } elseif($do == 'Edit') {

            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

            $stmt = $connect->prepare("SELECT * FROM categorie WHERE id_categorie = ? ");
            $stmt->execute(array($catid));
            $cat = $stmt->fetch();
            $count = $stmt->rowCount();
            if ($count > 0) {
?>
                <div style="height: 40px"></div>
                <div class='container'>
                    <div class="bg-gray-200 dash-title text-center mx-auto py-3">
                        <a href="categories.php">
                            <i class="fas fa-cog fa-2x text-gray-700"> Modification catégorie</i>
                        </a>
                    </div>
                    <form action="?do=Update" method="POST">
                        <input 
                            type="hidden" 
                            name="catid" 
                            value="<?php echo $catid ?>">
                        </input>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nom</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    name="nom" 
                                    value="<?php echo $cat['nom_categorie'] ?>" 
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
                                    value="<?php echo $cat['description_categorie'] ?>">
                                </input>
                            </div>
                        </div>                                
                        <button 
                            type="submit" 
                            class="btn btn-primary" 
                            style="margin-top: 20px">Enregister
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
            
        } elseif($do == 'Delete') {

            echo '<div class ="container" style="margin-top: 100px">';

            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

            $check = checkItem('id_categorie', 'categorie', $catid);

            if ($check > 0) {

                // Suppression de tous les produits de toutes les sous-categorie de cette categorie

                $stmt = $connect->prepare("SELECT id_sous_categorie FROM sous_categorie WHERE id_categorie = :zcatid");

                $stmt->bindParam(":zcatid", $catid);

                $stmt->execute();

                $rows = $stmt->fetchAll();

                foreach($rows as $row) {

                    $stmt1_0 = $connect->prepare("SELECT id_article FROM article WHERE id_sous_categorie = :zscatid");

                    $stmt1_0->bindParam(":zscatid", $row['id_sous_categorie']);

                    $stmt1_0->execute();

                    $items = $stmt1_0->fetchAll();

                    foreach($items as $item) {

                        // Suppression des approvisionements de cet article

                        $stmtAppr = $connect->prepare("DELETE FROM
                                                                approvisionement
                                                        WHERE id_article = :zitemid");

                                                $stmtAppr->bindParam(":zitemid", $item['id_article']);

                                                $stmtAppr->execute();

                        // Suppression des historiques de cet article

                        $stmtHis = $connect->prepare("DELETE FROM 
                                                                historique_article
                                                        WHERE id_article = :zitemid");

                                                $stmtHis->bindParam(":zitemid",$item['id_article']);

                                                $stmtHis->execute();

                    }

                    // Suppression des articles de cette sous-categorie

                    $stmt1_1 = $connect->prepare("DELETE FROM article WHERE id_sous_categorie = :zscatid");

                    $stmt1_1->bindParam(":zscatid", $row['id_sous_categorie']);

                    $stmt1_1->execute();
                }

                // Suppression des sous-categories de cette categorie

                $stmt2 = $connect->prepare("DELETE FROM sous_categorie WHERE id_categorie = :zcatid");

                $stmt2->bindParam(":zcatid", $catid);

                $stmt2->execute();

                // Suppression de la categorie de la table categorie

                $stmt3 = $connect->prepare("DELETE FROM categorie WHERE id_categorie = :zcatid");

                $stmt3->bindParam(":zcatid", $catid);

                $stmt3->execute();
                
                $Msg = "<div class='container alert alert-success'>
                            Catégorie supprimée.
                        </div>";

                redirect($Msg, 'categories.php', 4);

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