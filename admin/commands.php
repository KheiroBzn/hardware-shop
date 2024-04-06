<?php
    session_start();

    $pageTitle = 'Commandes';
//    $noNavbar = '';

    if(isset($_SESSION['userlogin_admin'])) {

        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        // Start Manage Page

        if($do == 'Manage') { // Manage Page

            $query = '';
            $title = '';

            if(isset($_GET['page']) && $_GET['page'] == 'Pending') {

                $query = 'WHERE etat_commande = "EN COUR"';
                $title = 'Commandes en cours';
            } else {
                $title = 'Gestion de Commandes';
            }

            $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
            $perPage = 10;
            $count = countItem('id_commande', 'commande');            
            $pages = ceil($count / $perPage);
            $offset = $perPage * ($currentPage - 1);
            $stmt1 = $connect->prepare("SELECT 
                                            commande.*,
                                            admin.nom_admin,
                                            admin.prenom_admin,
                                            client.nom_client,
                                            client.prenom_client
                                        FROM 
                                            commande
                                        LEFT JOIN 
                                            admin
                                        ON
                                            admin.id_admin = commande.id_admin
                                        LEFT JOIN 
                                            client
                                        ON
                                            client.id_client = commande.id_client
                                        $query
                                        ORDER BY 
                                            id_commande DESC
                                        LIMIT $perPage OFFSET $offset");
            $stmt1->execute();
            $rows = $stmt1->fetchAll();
        ?>
            <div class="commands-container">
                <div class="bg-gray-200 dash-title text-center mx-auto py-3">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="commands.php">
                                <i class="fas fa-luggage-cart fa-2x text-gray-700"><?php echo " ". $title ?></i>
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
                <a href="commands.php?do=Add" class="btn btn-outline-primary add-btn">
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
                                    href="commands.php?page=<?php echo ($currentPage-1) ?>"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>                            
                            <li class="page-item">
                                <a class="page-link" href="">
                                    <?php
                                        if($pages > 1) {
                                            echo 'Page: ' . $currentPage . ' sur ' . $pages;
                                        } else {
                                            echo 'Page: ' . $pages;
                                        } 
                                    ?>
                                </a>
                            </li>                            
                            <li class="page-item <?php echo $inactNext ?>">
                                <a 
                                    class="page-link" 
                                    href="commands.php?page=<?php echo ($currentPage+1) ?>" 
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
                            <td>Date</td>
                            <td>Etat</td>
                            <td>Admin</td>
                            <td>Client</td>                           
                            <td>Contenu</td>
                            <td><i class="fa fa-cog"></i></td>
                        </tr>
                        <?php
                            $i = 1;
                            foreach($rows as $row) {
                                $parity = !($i % 2) ? 'odd' : 'even'; $i++;
                                echo '<tr class="'. $parity .'">';
                                    echo "<td>". $row['id_commande'] ."</td>";
                                    echo "<td>". $row['date_commande'] ."</td>";
                                    echo "<td>". $row['etat_commande'] ."</td>";                                    
                                    echo "<td style='text-align: left !important;'>";
                                        echo "[ID:". $row['id_admin'] ."] - ";
                                        echo $row['nom_admin'] ." ". $row['prenom_admin'];
                                    echo "</td>";                                    
                                    echo "<td style='text-align: left !important;'>";
                                        echo "[ID:". $row['id_client'] ."] - ";
                                        echo $row['nom_client'] ." ". $row['prenom_client'];
                                    echo "</td>";
                                    echo "<td>";                                  
                                        $stmt2 = $connect->prepare("SELECT
                                                                        quantite_commande.*,
                                                                        article.nom_article
                                                                    FROM
                                                                        quantite_commande
                                                                    INNER JOIN
                                                                        article
                                                                    ON 
                                                                        article.id_article = quantite_commande.id_article
                                                                    WHERE 
                                                                        quantite_commande.id_commande = ?"); 
                                        $stmt2->execute(array($row['id_commande']));
                                        $items = $stmt2->fetchAll();
                                        echo "<ul style='text-align: left !important;'>";
                                        foreach($items as $item) {
                                            echo "<li>". $item['nom_article'];
                                            echo " - [Qte: ". $item['quantite_article_commande'] ."]</li>";
                                        }
                                        echo "</ul>";
                                    echo "</td>";
                                    echo "<td>";
                                    $etat = $row['etat_commande'];
                                    if( $etat == 'EN COUR' ) {
                                        
                                        echo "<a href='commands.php?do=Validate&cmdid=";
                                            echo $row['id_commande'] ."' class='btn btn-info btn-circle btn-sm'>";
                                            echo "<i class='fas fa-check'></i>";
                                        echo "</a>";
                                        echo "<a href='commands.php?do=Cancel&cmdid=";
                                            echo $row['id_commande'] ."' class='btn btn-warning btn-circle btn-sm'>";
                                            echo "<i class='fas fa-times'></i>";
                                        echo "</a>";
                                        echo "<a href='commands.php?do=Edit&cmdid=";
                                            echo $row['id_commande'] ."' class='btn btn-success btn-circle btn-sm'>";
                                            echo "<i class='fas fa-edit'></i>";
                                        echo "</a>";
                                    } elseif( $etat == 'Non Validée' || $etat == 'VALIDE' ) {
                                        
                                        echo "<a href='commands.php?do=Edit&cmdid=";
                                            echo $row['id_commande'] ."' class='btn btn-success btn-circle btn-sm'>";
                                            echo "<i class='fas fa-edit'></i>";
                                        echo "</a>";
                                    } else {
                                        echo "<a href='commands.php?do=Edit&cmdid=";
                                            echo $row['id_commande'] ."' class='btn btn-success btn-circle btn-sm'>";
                                            echo "<i class='fas fa-edit'></i>";
                                        echo "</a>";
                                        echo "<a href='commands.php?do=Delete&cmdid=";
                                            echo $row['id_commande'] ."' class='btn btn-danger btn-circle btn-sm'>";
                                            echo "<i class='fas fa-trash'></i>";
                                        echo "</a>";
                                    }
                                echo "</td>";                           
                                echo '<tr>';
                            }
                        ?>
                    </table>
                </div>
                <a href="commands.php?do=Add" class="btn btn-outline-primary add-btn">
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
                                    href="commands.php?page=<?php echo ($currentPage-1) ?>"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>                            
                            <li class="page-item">
                                <a class="page-link" href="">
                                    <?php
                                        if($pages > 1) {
                                            echo 'Page: ' . $currentPage . ' sur ' . $pages;
                                        } else {
                                            echo 'Page: ' . $pages;
                                        } 
                                    ?>
                                </a>
                            </li>                            
                            <li class="page-item <?php echo $inactNext ?>">
                                <a 
                                    class="page-link" 
                                    href="commands.php?page=<?php echo ($currentPage+1) ?>" 
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

<?php   } elseif($do == 'Add') { 

            // For Admin Form

            $stmt1 = $connect->prepare("SELECT * FROM admin ORDER BY nom_admin ASC");
            $stmt1->execute();
            $admins = $stmt1->fetchAll();

            // For Client Form

            $stmt2 = $connect->prepare("SELECT * FROM client ORDER BY nom_client ASC");
            $stmt2->execute();
            $clients = $stmt2->fetchAll();

            // For Product Form (max)

            $totalProduct = countItem('id_article', 'article');

            ?>
            <div style="height: 40px"></div>
                <div class='container'>
                    <div class="bg-gray-200 dash-title text-center mx-auto py-3">
                        <a href="commands.php?do=Add">
                            <i class="fas fa-plus fa-2x text-gray-700"> Nouvelle Commande</i>
                        </a>
                    </div>
                    <form action="?do=AddSecond" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Admin</label>
                                <select class="form-control" name="adminid" required="required">>
                                    <?php
                                        foreach($admins as $admin)
                                        {                                           
                                        
                                            if( $admin['userlogin_admin'] == $_SESSION['userlogin_admin'] ) {
                                                echo "<option value='". $admin['id_admin'] ."' selected>";
                                                    echo "[ID: ". $admin['id_admin'] . "] ";
                                                    echo $admin['nom_admin'] ."  ". $admin['prenom_admin'];
                                                echo "</option>";
                                            } else {
                                                echo "<option value='". $admin['id_admin'] ."'>";
                                                    echo "[ID: ". $admin['id_admin'] . "] ";
                                                    echo $admin['nom_admin'] ."  ". $admin['prenom_admin'];
                                                echo "</option>";
                                            } 
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Client</label>
                                <select class="form-control" name="clientid" required="required">>
                                    <?php
                                        foreach($clients as $client)
                                        {
                                            echo "<option value='". $client['id_client'] ."'>";                                                
                                                echo $client['nom_client'] ."  ". $client['prenom_client'];                                                
                                                echo " ----- [". $client['date_naissance_client'] . "] ";
                                                echo "[ID: ". $client['id_client'] . "]";
                                            echo "</option>"; 
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class='form-row'>
                            <div class='col-md-3'>
                                <label>Nombre de produits (différents):</label>
                            </div>
                            <div class='col-md-2'>
                                <input type='number' class='form-control' name='items' value="1" min="1" max="<?php echo $totalProduct ?>"></input>
                            </div>
                            <div class='col-md-1'>
                                <button type="submit" class='add-item btn btn-primary'>OK</button>
                            </div>
                        </div>                         
                    </form>             
                </div>

<?php   } elseif($do == 'AddSecond') { 

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                $adminid  = $_POST['adminid'];
                $clientid   = $_POST['clientid'];
                $numitems   = $_POST['items'];

                // For Admin name

                $stmtAdmin = $connect->prepare("SELECT * FROM admin WHERE id_admin = ?");
                $stmtAdmin->execute(array($adminid));
                $admin = $stmtAdmin->fetch();

                // For Client name

                $stmtClient = $connect->prepare("SELECT * FROM client WHERE id_client = ?");
                $stmtClient->execute(array($clientid));
                $client = $stmtClient->fetch();

                // For Product Form

                $stmt3 = $connect->prepare("SELECT * FROM article");
                $stmt3->execute();
                $items = $stmt3->fetchAll();

                ?>
                <div style="height: 40px"></div>
                <div class='container'>
                    <div class="bg-gray-200 dash-title text-center mx-auto py-3">
                        <a href="commands.php?do=Add">
                            <i class="fas fa-plus fa-2x text-gray-700"> Nouvelle Commande</i>
                        </a>
                    </div>
                    <form action="?do=Insert" method="POST">
                        <input type="hidden" name="adminid" value="<?php echo $adminid ?>">
                        <input type="hidden" name="clientid" value="<?php echo $clientid ?>">
                        <input type="hidden" name="items" value="<?php echo $numitems ?>">
                        </input>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Admin</label>
                                <select class="form-control" name="adminid" required="required" disabled>>
                                    <?php
                                        echo "<option value='". $admin['id_admin'] ."' selected>";
                                            echo "[ID: ". $admin['id_admin'] . "] ";
                                            echo $admin['nom_admin'] ."  ". $admin['prenom_admin'];
                                        echo "</option>";                                    
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Client</label>
                                <select class="form-control" name="clientid" required="required" disabled>>
                                    <?php
                                        echo "<option value='". $client['id_client'] ."' selected>";                                                
                                            echo $client['nom_client'] ."  ". $client['prenom_client'];                                                
                                            echo " ----- [". $client['date_naissance_client'] . "] ";
                                            echo "[ID: ". $client['id_client'] . "]";
                                        echo "</option>";                                    
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php
                            $cpt = $numitems;
                            $add = false;
                            $index = 1;
                            while($cpt > 0) {                                
                                echo "<div class='form-row'>";
                                    echo "<div class='col-md-4'>";
                                        echo "<label>Produit</label>";
                                        echo "<select class='form-control'name='itemid". $index ."' required='required'>";
                                            foreach($items as $item)
                                            {
                                                echo "<option value='". $item['id_article'] ."'>";
                                                    echo $item['nom_article'] ;
                                                echo "</option>";
                                            } 
                                                                            
                                        echo "</select>";
                                    echo "</div>";
                                    echo "<div class='col-md-2'>";
                                        echo "<label>Quantité</label>";
                                        echo "<input type='number' class='form-control' name='quantite". $index ."'";
                                            echo "min='1' max='10' value='1' required='required'></input>";
                                    echo "</div>";
                                echo "</div>";
                                $cpt--;
                                $index++;
                                $add = true;
                            }
                            if($add) {
                                echo "<button type='submit' class='btn btn-primary' style='margin-top: 20px'>Ajouter</button>";
                            }
                        ?>
                        
                    </form>                
                </div>

<?php       } else {

            $Msg = "<div class='container alert alert-danger' style='margin-top: 100px'>
                        Vous ne pouvez pas acceder à cette page directement.
                    </div>";
            redirect($Msg, 'index.php', 6);                
            }
            ?>

<?php   } elseif($do == 'Insert') { // Insert Page

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                echo '<div class ="container" style="margin-top: 100px">';

                $adminid    = $_POST['adminid'];
                $clientid   = $_POST['clientid'];
                $numitems   = $_POST['items'];

                // Insert Into 'commande'

                $stmt = $connect->prepare("INSERT INTO commande(
                                                            date_commande,
                                                            etat_commande,
                                                            id_admin,
                                                            id_client)
                                                    VALUES(now(), 'EN COUR', :zadminid, :zclientid)");
                $stmt->execute(array(
                    'zadminid'  => $adminid,
                    'zclientid' => $clientid
                ));

                $cmcid = $connect->lastInsertId();

                // Insert Into 'quantite_commande'

                $cpt = $numitems;
                $index = 1;
                while( $cpt > 0 ) {

                    $stmt = $connect->prepare("INSERT INTO quantite_commande(
                                                                            id_commande,
                                                                            id_article,
                                                                            quantite_article_commande)
                                                        VALUES(:zcmdid, :zitemid, :zqte)");
                    $stmt->execute(array(
                    'zcmdid'  => $cmcid,
                    'zitemid' => $_POST['itemid'.$index],
                    'zqte'    => $_POST['quantite'.$index]
                    ));

                    $index++;
                    $cpt--;
                }

                $Msg = "<div class='container alert alert-success'>
                            Commande ajoutée avec succes.
                        </div>";

                redirect($Msg, 'commands.php', 4);

            } else {

                $Msg = "<div class='container alert alert-danger'>
                            Vous ne pouvez pas acceder à cette page directement.
                        </div>";
                redirect($Msg, 'index.php', 6);                
            }

            echo '</div>';

        } elseif($do == 'Edit') { // Edit Page 

            $cmdid = isset($_GET['cmdid']) && is_numeric($_GET['cmdid']) ? intval($_GET['cmdid']) : 0;

            $stmt = $connect->prepare("SELECT 
                                            commande.*,
                                            admin.nom_admin,
                                            admin.prenom_admin,
                                            client.nom_client,
                                            client.prenom_client,
                                            client.date_naissance_client
                                        FROM 
                                            commande
                                        LEFT JOIN 
                                            admin
                                        ON
                                            admin.id_admin = commande.id_admin
                                        LEFT JOIN 
                                            client
                                        ON
                                            client.id_client = commande.id_client
                                        WHERE id_commande = ?");
            $stmt->execute(array($cmdid));
            $row = $stmt->fetch();

            $stmt2 = $connect->prepare("SELECT 
                                            quantite_commande.*,
                                            article.nom_article
                                        FROM 
                                            quantite_commande
                                        INNER JOIN 
                                            article
                                        ON
                                            article.id_article = quantite_commande.id_article
                                        WHERE 
                                            id_commande = ?");
            $stmt2->execute(array($cmdid));
            $items = $stmt2->fetchAll();


            $etatCmd = array("Non Validée", "EN COUR", "VALIDE", "ANNULEE");

            $count = $stmt->rowCount();

            if ($count > 0) {
?>
                <div style="height: 40px"></div>
                <div class='container'>
                    <div class="bg-gray-200 dash-title text-center mx-auto py-3">
                        <a href="commands.php">
                            <i class="fas fa-cog fa-2x text-gray-700"> Modification de la commande</i>
                        </a>
                    </div>
                    <form action="?do=Update" method="POST">
                        <input type="hidden" name="cmdid" value="<?php echo $cmdid ?>"></input>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Etat de la commande</label>
                                <select class="form-control" name="etatcmd" required="required">>
                                <?php
                                    foreach($etatCmd as $etat) {
                                        if($etat == $row['etat_commande']) {
                                            echo "<option value='". $etat ."' selected>". $etat ."</option>";
                                        } else {
                                            echo "<option value='". $etat ."'>". $etat ."</option>";
                                        }
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Admin</label>
                                <select class="form-control" name="adminid" required="required" disabled>>
                                    <?php
                                        echo "<option value='". $row['id_admin'] ."' selected>";
                                            echo "[ID: ". $row['id_admin'] . "] ";
                                            echo $row['nom_admin'] ."  ". $row['prenom_admin'];
                                        echo "</option>";                                    
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Client</label>
                                <select class="form-control" name="clientid" required="required" disabled>>
                                    <?php
                                        echo "<option value='". $row['id_client'] ."' selected>";                                                
                                            echo $row['nom_client'] ."  ". $row['prenom_client'];                                                
                                            echo " ----- [". $row['date_naissance_client'] . "] ";
                                            echo "[ID: ". $row['id_client'] . "]";
                                        echo "</option>";                                    
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Contenu de la commande:</label>
                            </div>
                        </div>
                        <?php
                            foreach($items as $item) {
                                echo "<div class='form-row'>";
                                    echo "<div class='col-md-4'>";
                                        echo "<label>Produit</label>";
                                        echo "<select class='form-control'name='itemid' disabled>";
                                            echo "<option value='". $item['id_article'] ."'>";
                                                echo $item['nom_article'] ;
                                            echo "</option>";               
                                        echo "</select>";
                                    echo "</div>";
                                    echo "<div class='col-md-2'>";
                                        echo "<label>Quantité</label>";
                                        echo "<input type='number' class='form-control' name='quantite'";
                                            echo "value='". $item['quantite_article_commande'];
                                            echo "' min='1' max='10' disabled></input>";
                                    echo "</div>";
                                echo "</div>";
                            }   
                        ?>
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

                $cmdid    = $_POST['cmdid'];
                $etatcmd  = $_POST['etatcmd'];

                $stmt = $connect->prepare("UPDATE 
                                                commande 
                                            SET 
                                                etat_commande = ?
                                            WHERE 
                                                id_commande = ?");

                $stmt->execute(array($etatcmd, $cmdid));

                $Msg = '<div class="container alert alert-success">
                            Commande mise à jour avec succes.
                        </div>';

                redirect($Msg, 'commands.php');

            } else {

                redirect('', 2);
            }

            echo '</div>';

        } elseif($do == 'Validate') {

            echo '<div class ="container" style="margin-top: 100px">';

            $cmdid = isset($_GET['cmdid']) && is_numeric($_GET['cmdid']) ? intval($_GET['cmdid']) : 0;

            $check = checkItem('id_commande', 'commande', $cmdid);

            if ($check > 0) {

                $stmt = $connect->prepare("UPDATE 
                                            commande 
                                        SET 
                                            etat_commande = ?
                                        WHERE 
                                            id_commande = ?");

                $stmt->execute(array('VALIDE' , $cmdid));

                
                $Msg = "<div class='container alert alert-success'>
                            Commande validée.
                        </div>";

                redirect($Msg, 'commands.php', 4);

            } else {

                $Msg = '<div class="container alert alert-danger">
                            ID invalide
                        </div>';
                redirect($Msg);
            }

            echo '</div>';

        } elseif($do == 'Cancel') {

            echo '<div class ="container" style="margin-top: 100px">';

            $cmdid = isset($_GET['cmdid']) && is_numeric($_GET['cmdid']) ? intval($_GET['cmdid']) : 0;

            $check = checkItem('id_commande', 'commande', $cmdid);

            if ($check > 0) {

                $stmt = $connect->prepare("UPDATE 
                                                commande 
                                            SET 
                                                etat_commande = ?
                                            WHERE 
                                                id_commande = ?");

                $stmt->execute(array('ANNULEE' , $cmdid));

                
                $Msg = "<div class='container alert alert-success'>
                            Commande annulée.
                        </div>";

                redirect($Msg, 'commands.php', 4);

            } else {

                $Msg = '<div class="container alert alert-danger">
                            ID invalide
                        </div>';
                redirect($Msg);
            }

            echo '</div>';

        } elseif($do == 'Delete') {

            // Set Statu 'Non Validée'

            echo '<div class ="container" style="margin-top: 100px">';

            $cmdid = isset($_GET['cmdid']) && is_numeric($_GET['cmdid']) ? intval($_GET['cmdid']) : 0;

            $check = checkItem('id_commande', 'commande', $cmdid);

            if ($check > 0) {

                $stmt = $connect->prepare("UPDATE 
                                                commande 
                                            SET 
                                                etat_commande = ?
                                            WHERE 
                                                id_commande = ?");

                $stmt->execute(array('Non Validée' , $cmdid));

                
                $Msg = "<div class='container alert alert-success'>
                            Suppression, commande non validée.
                        </div>";

                redirect($Msg, 'commands.php', 4);

            } else {

                $Msg = '<div class="container alert alert-danger">
                            ID invalide
                        </div>';
                redirect($Msg);
            }

            echo '</div>';            

            /*
            
            echo '<div class ="container" style="margin-top: 100px">';

            $cmdid = isset($_GET['cmdid']) && is_numeric($_GET['cmdid']) ? intval($_GET['cmdid']) : 0;

            $check = checkItem('id_commande', 'commande', $cmdid);

            if ($check > 0) {

                // Delete From 'quantite_commande'

                $stmt1 = $connect->prepare("DELETE FROM quantite_commande WHERE id_commande = :zid");

                $stmt1->bindParam(":zid", $cmdid);
                $stmt1->execute();

                // Delete From 'commande'

                $stmt2 = $connect->prepare("DELETE FROM commande WHERE id_commande = :zid");

                $stmt2->bindParam(":zid", $cmdid);
                $stmt2->execute();

                
                $Msg = "<div class='container alert alert-success'>
                            Commande supprimée.
                        </div>";

                redirect($Msg, 'commands.php', 4);

            } else {

                $Msg = '<div class="container alert alert-danger">
                            ID invalide
                        </div>';
                redirect($Msg);
            }

            echo '</div>';
            
            */

        }

        include $tpl . 'footer.php';

    } else {

        header('Location: index.php');
        exit();
    }