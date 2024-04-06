<?php
    ob_start();
    session_start();

    if(isset($_SESSION['userlogin_admin'])) {
        $pageTitle = 'Tableau de bord';
        include 'init.php';
        // Start Dashboard Page
        // For The Latest Added Members
        $latestMembers = 5;
        $theLatestMembers = getLatest("*", 'client', 'id_client', $latestMembers);
        // For The Latest Added Items
        $latestItems = 5;
        $theLatestItems = getLatest("*", 'article', 'id_article', $latestItems);        
         // For The Latest Comments
        $query = 'INNER JOIN article ON article.id_article = commentaire.id_article';
        $select = 'commentaire.*, article.nom_article';
        $latestComments = 3;
        $theLatestComments = getLatest($select, 'commentaire', $query, 'id_commentaire', $latestComments);
        // For The Latest Orders
        $query = 'INNER JOIN client ON client.id_client = commande.id_client WHERE etat_commande = "EN COUR"';
        $select = 'commande.*, client.nom_client, client.prenom_client';
        $latestOrders = 3;
        $theLatestOrders = getLatest($select, 'commande', $query, 'id_commande', $latestOrders);
?>
        <div class="dash-container">
            <div class="home-stats text-center">
                <div class="bg-gray-200 dash-title mx-auto py-3">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="dashboard.php" class="float-left">
                                <i class="fas fa-fw fa-tachometer-alt fa-2x"> Tableau de bord</i>
                            </a> 
                        </div>
                        <div class="col-md-8 text-right">                            
                            <a href="http://hwshop/Accueil" class="d-inline-flex visit-site" target="_blanck">
                                <div>
                                    <h4>Visiter le site</h4>
                                </div>
                                <div class="ml-2">
                                    <i class="fas fa-angle-right fa-2x"></i>
                                </div>                                
                            </a>
                            
                        </div>
                    </div>                                      
                </div>
                <div class="row mt-5 justify-content-around">
                    <div class="col-lg-3 col-md-5 col-sm-8 mx-md-auto mx-sm-2">
                        <div class="stat bg-gradient-primary mx-2 my-2">
                            <a href='items.php'>
                                <div class="row">
                                    <div class="col-md-4">
                                        <i class="fas fa-tasks fa-2x p-2"></i>
                                    </div>
                                    <div class="col-md-8 m-auto">
                                        <h5 class="embed-responsive w-75 m-auto">Taches en cours</h5>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-12">
                                        <span>0</span>
                                    </div>                            
                                </div>
                            </a>
                        </div>                        
                    </div>
                    <div class="col-lg-3 col-md-5 col-sm-8 mx-md-auto mx-sm-2">
                        <div class="stat bg-gradient-success mx-2 my-2">
                            <a href='items.php'>
                                <div class="row">
                                    <div class="col-md-4">
                                        <i class="fas fa-luggage-cart fa-2x p-2"></i>
                                    </div>
                                    <div class="col-md-8 m-auto">
                                        <h5 class="embed-responsive w-75 m-auto">Stock en attente</h5>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-12">
                                        <span>0</span>
                                    </div>                            
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-5 col-sm-8 mx-md-auto mx-sm-2">
                        <div class="stat bg-gradient-warning mx-2 my-2">
                            <a href='commands.php?do=Manage&page=Pending'>
                                <div class="row">
                                    <div class="col-md-4">
                                        <i class="fas fa-cart-arrow-down fa-2x p-2"></i>
                                    </div>
                                    <div class="col-md-8">
                                        <h5 class="embed-responsive m-auto">Commandes en cours</h5>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-12">
                                        <span>
                                            <?php 
                                                $query = 'WHERE etat_commande = ?';
                                                echo countItem('id_commande', 'commande', $query, 'EN COUR')
                                            ?>
                                        </span>
                                    </div>                            
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-5 col-sm-8 mx-md-auto mx-sm-2">
                        <div class="stat stat bg-gradient-danger mx-2 my-2">
                            <a href='statistics'>
                                <div class="row">
                                    <div class="col-md-4">
                                        <i class="fas fa-chart-line fa-2x p-2"></i>
                                    </div>
                                    <div class="col-md-8 m-auto">
                                        <h5 class="embed-responsive w-75 m-auto">Revenus mensuels</h5>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-12">
                                        <span>0</span>
                                    </div>                            
                                </div>
                            </a>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="latest-main">
                <div class="row justify-content-around">
                    <div class="col-lg-3 col-md-5 col-sm-8 mx-md-auto mx-sm-2">
                        <div class="card shadow mb-4">
                            <div class="card-header m-0 font-weight-bold">
                                <i class="fa fa-users"></i> Derniers <?php echo $latestMembers; ?> membres inscrits
                                <span class="toggle-info float-right">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </div>
                            <div class="card-body text-gray-700">
                                <ul class="list-unstyled latest">
                                    <?php
                                        foreach($theLatestMembers as $member) {
                                            echo "<li class='latest-li'>";
                                                echo '<div>';
                                                    echo $member['nom_client'] ." ". $member['prenom_client'];
                                                    echo "<span class='float-right'>". $member['date_inscription'] ."</span><br>";
                                                    echo "<a href='members.php?do=EditMember&userid=";
                                                    echo $member['id_client'] ."' class='btn btn-success btn-sm float-right'>";
                                                    echo "<i class='fas fa-user-edit'></i></a>"; 
                                                echo '</div>';
                                                if($member['approuvation'] == 'PRE_APPROUVE') {
                                                    echo "<a href='members.php?do=Activate&userid=";
                                                    echo $member['id_client'] ."' class='btn btn-info btn-sm float-right'>";
                                                    echo "<i class='fas fa-user-check'></i></a>";                                                
                                                }                                            
                                            echo "</li>";
                                        }
                                    ?>
                                </ul>
                                <div class="dropdown-divider my-2"></div>
                                <div class="text-center">
                                    <a href='members.php'>Voir tous les membres</a>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-5 col-sm-8 mx-md-auto mx-sm-2">
                        <div class="card shadow mb-4">
                            <div class="card-header m-0 font-weight-bold">
                                <i class="fa fa-tag"></i> Derniers <?php echo $latestItems; ?> produits ajoutés
                                <span class="toggle-info float-right">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </div>
                            <div class="card-body text-gray-700">
                                <ul class="list-unstyled latest">
                                    <?php
                                        foreach($theLatestItems as $item) {
                                            echo "<li class='latest-li'>". $item['nom_article'];
                                                echo "<a href='items.php?do=Edit&itemid=";
                                                echo $item['id_article'] ."' class='btn btn-success btn-sm float-right'>";
                                                echo "<i class='fas fa-edit'></i></a>";                                            
                                            echo "</li>";
                                        }
                                    ?>
                                </ul>
                                <div class="dropdown-divider my-2"></div>
                                <div class="text-center">
                                    <a href='items.php'>Voir tous les produits</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-5 col-sm-8 mx-md-auto mx-sm-2">
                        <div class="card shadow mb-4">
                            <div class="card-header m-0 font-weight-bold">
                                <i class="fa fa-luggage-cart"></i> Dernieres <?php echo $latestOrders; ?> commandes
                                <span class="toggle-info float-right">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </div>
                            <div class="card-body text-gray-700">
                                <ul class="list-unstyled latest">
                                    <?php
                                        if(!empty($theLatestOrders)) {
                                            foreach($theLatestOrders as $order) {
                                                echo "<li class='latest-li'>";
                                                    echo "[". $order['date_commande'] ."]</br>";
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
                                                    $stmt2->execute(array($order['id_commande']));
                                                    $items = $stmt2->fetchAll();
                                                    echo "<ul style='list-style-type : disc !important'>";
                                                        foreach($items as $item) {
                                                            echo "<li>". $item['nom_article'];
                                                            echo " [Qte: ". $item['quantite_article_commande'] ."]</li>";
                                                        }
                                                    echo "</ul>";
                                                    echo "[". $order['nom_client'] . " ". $order['prenom_client'] ."]";
                                                    echo "<a href='commands.php?do=Edit&cmdid=";
                                                    echo $order['id_commande'] ."' class='btn btn-success float-right'>";
                                                    echo "<i class='fas fa-edit'></i></a>";                                            
                                                echo "</li>";
                                            }
                                        } else echo "Aucune commande pour le moment.";
                                    ?>
                                </ul>
                                <div class="dropdown-divider my-2"></div>
                                <div class="text-center">
                                    <a href='commands.php'>Voir toutes les commandes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-5 col-sm-8 mx-md-auto mx-sm-2">
                        <div class="card shadow mb-4">
                            <div class="card-header m-0 font-weight-bold">
                                <i class="fa fa-comments"></i> Derniers <?php echo $latestComments; ?> commentaires
                                <span class="toggle-info float-right">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                            </div>
                            <div class="card-body text-gray-700">
                                <ul class="list-unstyled latest">
                                    <?php
                                        if(!empty($theLatestOrders)) {
                                            foreach($theLatestComments as $comment) {
                                                echo "<li class='latest-li'>";
                                                    echo "[". $comment['date_ajout_commentaire'] ."]</br>";
                                                    echo "[". $comment['nom_article'] ."]</br>";
                                                    echo $comment['contenue_commentaire'];
                                                    echo "<a href='comments.php?do=Edit&commentid=";
                                                    echo $comment['id_commentaire'] ."' class='btn btn-success float-right'>";
                                                    echo "<i class='fas fa-edit'></i></a>";                                            
                                                echo "</li>";
                                            }
                                        } else echo "Aucun commentaire pour le moment.";
                                    ?>
                                </ul>
                                <div class="dropdown-divider my-2"></div>
                                <div class="text-center">
                                    <a href='comments.php'>Voir tous les commentaires</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>      
<?php
        // End Dashboard Page        
        include $tpl . 'footer.php';
    } else {
        header('Location: index.php');
        exit();
    }
    ob_end_flush();
?>