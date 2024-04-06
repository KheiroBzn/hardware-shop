<?php
    session_start();

    $pageTitle = 'Commentaires';
//    $noNavbar = '';

    if(isset($_SESSION['userlogin_admin'])) {

        include 'init.php';

        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        // Start Manage Page

        if($do == 'Manage') { // Manage Page

            $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
            $perPage = 10;
            $count = countItem('id_commentaire', 'commentaire');            
            $pages = ceil($count / $perPage);
            $offset = $perPage * ($currentPage - 1);

            $stmt = $connect->prepare("SELECT
                                            commentaire.*,
                                            admin.userlogin_admin,
                                            client.userlogin_client,
                                            article.nom_article,
                                            utilisateur.group_utilisateur
                                        FROM
                                            commentaire 
                                        LEFT JOIN
                                            admin
                                        ON
                                            admin.id_utilisateur = commentaire.id_utilisateur
                                        LEFT JOIN
                                            client
                                        ON
                                            client.id_utilisateur = commentaire.id_utilisateur
                                        LEFT JOIN
                                            utilisateur
                                        ON 
                                            utilisateur.id_utilisateur = commentaire.id_utilisateur
                                        LEFT JOIN
                                            article
                                        ON 
                                            article.id_article = commentaire.id_article
                                        ORDER BY 
                                            id_commentaire DESC
                                        LIMIT $perPage OFFSET $offset"); 
            $stmt->execute();
            $rows = $stmt->fetchAll();
        ?>
            <div class="comments-container">
                <div class="bg-gray-200 dash-title text-center mx-auto py-3">                    
                    <div class="row">
                        <div class="col-md-4">
                            <a href="comments.php">
                                <i class="fas fa-comments fa-2x text-gray-700"> Gestion de Commentaires</i>
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
                <a href="comments.php?do=Add" class="btn btn-outline-primary add-btn">
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
                                    href="comments.php?page=<?php echo ($currentPage-1) ?>"
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
                                    href="comments.php?page=<?php echo ($currentPage+1) ?>" 
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
                            <td style="width: 35%">Commentaire</td>
                            <td>Date</td>
                            <td>Utilisateur</td>                         
                            <td>Produit</td>
                            <td style="width: 25%">Reponse de l'equipe</td>
                            <td><i class="fa fa-cog"></i></td>
                        </tr>
                        <?php
                            $i = 1;
                            foreach($rows as $row) {
                                $parity = !($i % 2) ? 'odd' : 'even'; $i++;
                                $group = $row['group_utilisateur'];
                                echo '<tr class="'. $parity .'">';
                                    echo "<td>". $row['id_commentaire'] ."</td>";
                                    echo "<td style='text-align: left;'>";
                                        echo $row['contenue_commentaire'];
                                    echo "</td>";
                                    echo "<td>". $row['date_ajout_commentaire'] ."</td>";
                                    if( $group == 'ADMIN' ) {
                                        echo "<td style='text-align: left'>";
                                            echo "<i class='fas fa-user-shield'></i> ";
                                            echo "[ID: ". $row['id_utilisateur'] ."] ";                                            
                                            echo $row['userlogin_admin'];
                                        echo "</td>";
                                    } else {
                                        echo "<td style='text-align: left'>";
                                            echo "<i class='fas fa-user'></i>";
                                            echo " [ID: ". $row['id_utilisateur'] ."] ";
                                            echo $row['userlogin_client'];
                                        echo "</td>";
                                    }
                                    echo "<td>[ID: ". $row['id_article'] ."] - ". $row['nom_article'] ."</td>";
                                    echo "<td>";
                                        if(!empty($row['reponse_admin'])) {
                                            echo "[". $row['date_reponse_admin'] ."]<br>". $row['reponse_admin'];
                                        }
                                    echo"</td>";
                                    echo "<td>";
                                        echo "<a href='comments.php?do=Edit&commentid=";
                                            echo $row['id_commentaire'] ."' class='btn btn-success btn-circle btn-sm'>";
                                            echo "<i class='fas fa-edit'></i>";
                                        echo "</a>";
                                        echo "<a href='comments.php?do=Delete&commentid=";
                                            echo $row['id_commentaire'] ."' class='btn btn-danger btn-circle btn-sm confirm'>";
                                            echo "<i class='fas fa-times'></i>";
                                        echo "</a>"; 
                                    echo "</td>";                                
                                echo '<tr>';
                            }
                        ?>
                    </table>
                </div>
                <a href="comments.php?do=Add" class="btn btn-outline-primary add-btn">
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
                                    href="comments.php?page=<?php echo ($currentPage-1) ?>"
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
                                    href="comments.php?page=<?php echo ($currentPage+1) ?>" 
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

            // For Users Form

            $userStmt = $connect->prepare("SELECT 
                                                utilisateur.*,
                                                admin.userlogin_admin,
                                                client.userlogin_client
                                            FROM
                                                utilisateur
                                            LEFT JOIN 
                                                admin
                                            ON 
                                                admin.id_utilisateur = utilisateur.id_utilisateur
                                            LEFT JOIN 
                                                client
                                            ON 
                                                client.id_utilisateur = utilisateur.id_utilisateur");
            $userStmt->execute();
            $users = $userStmt->fetchAll();

            // For Items Form

            $itemsStmt = $connect->prepare("SELECT * FROM article ORDER BY nom_article");
            $itemsStmt->execute();
            $items = $itemsStmt->fetchAll();

            ?>
            <div style="height: 40px"></div>
                <div class='container'>
                    <div class="bg-gray-200 dash-title text-center mx-auto py-3">
                        <a href="comments.php?do=Add">
                            <i class="fas fa-plus fa-2x text-gray-700"> Nouveau Commentaire</i>
                        </a>
                    </div>
                    <form action="?do=Insert" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Utilisateur</label>
                                <select class="form-control" name="userid" required="required">>
                                    <?php
                                        foreach($users as $user)
                                        {                                           
                                            if( $user['group_utilisateur'] == 'ADMIN' ) {
                                                if( $user['userlogin_admin'] == $_SESSION['userlogin_admin'] ) {
                                                    echo "<option value='". $user['id_utilisateur'] ."' selected>";
                                                        echo $user['userlogin_admin'] ."  [Admin]";
                                                    echo "</option>";
                                                } else {
                                                    echo "<option value='". $user['id_utilisateur'] ."'>";
                                                        echo $user['userlogin_admin'] ."  [Admin]";
                                                    echo "</option>";
                                                }
                                            } else {
                                                echo "<option value='". $user['id_utilisateur'] ."'>";
                                                    echo $user['userlogin_client'];
                                                echo "</option>";
                                            }  
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Produit</label>
                                <select class="form-control" name="itemid" required="required">>
                                    <?php
                                        foreach($items as $item)
                                        {
                                            echo "<option value='". $item['id_article'] ."'>";
                                                echo $item['nom_article'] ;
                                            echo "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="">Commentaire</label>
                                <textarea
                                    class="form-control" 
                                    name="comment" 
                                    required="required">
                                </textarea>
                            </div>           
                        </div>                                
                        <button 
                            type="submit" 
                            class="btn btn-primary" 
                            style="margin-top: 20px">Ajouter
                        </button>
                    </form>
                </div>

<?php   } elseif($do == 'Insert') { // Insert Page

            if($_SERVER['REQUEST_METHOD'] == 'POST') {

                echo '<div class ="container" style="margin-top: 100px">';

                $comment  = $_POST['comment'];
                $userid   = $_POST['userid'];
                $itemid   = $_POST['itemid'];

                $stmt = $connect->prepare("INSERT INTO commentaire(
                                                            date_ajout_commentaire,
                                                            contenue_commentaire,
                                                            id_utilisateur,
                                                            id_article)
                                            VALUES(now(), :zcomment, :zuserid, :zitemid)");
                $stmt->execute(array(
                    'zcomment'               => $comment,
                    'zuserid'                => $userid,
                    'zitemid'                => $itemid
                ));
                $Msg = "<div class='container alert alert-success'>
                            Commentaire ajouté avec succes.
                        </div>";
                redirect($Msg, 'comments.php', 4);
            } else {
                $Msg = "<div class='container alert alert-danger'>
                            Vous ne pouvez pas acceder à cette page directement.
                        </div>";
                redirect($Msg, 'index.php', 6);                
            }
            echo '</div>';
        } elseif($do == 'Edit') { // Edit Page 
            $commentid = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : 0;
            $stmt = $connect->prepare("SELECT 
                                            commentaire.*,
                                            utilisateur.*,
                                            client.userlogin_client,
                                            admin.userlogin_admin,
                                            article.nom_article,
                                            article.id_article  
                                        FROM  
                                            commentaire
                                        LEFT JOIN 
                                            utilisateur
                                        ON 
                                            utilisateur.id_utilisateur = commentaire.id_utilisateur
                                        LEFT JOIN 
                                            client
                                        ON 
                                            client.id_utilisateur = commentaire.id_utilisateur
                                        LEFT JOIN 
                                            admin
                                        ON 
                                            admin.id_utilisateur = commentaire.id_utilisateur
                                        LEFT JOIN 
                                            article
                                        ON  
                                            article.id_article = commentaire.id_article
                                        WHERE 
                                            id_commentaire = ?");
            $stmt->execute(array($commentid));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
            if ($count > 0) {
?>
                <div style="height: 40px"></div>
                <div class='container'>
                    <div class="bg-gray-200 dash-title text-center mx-auto py-3">
                        <a href="comments.php">
                            <i class="fas fa-cog fa-2x text-gray-700"> Modification du commentaire</i>
                        </a>
                    </div>
                    <form action="?do=Update" method="POST">
                        <div class="row">
                            <div class="col-md-7">
                                <input type="hidden" name="commentid" value="<?php echo $commentid ?>"></input>
                                <div class="form-row">
                                    <div class="form-group col-md-11">
                                        <label>Utilisateur</label>
                                        <select class="form-control" name="userid" required="required">>
                                            <?php                                        
                                                if( $row['group_utilisateur'] == 'ADMIN' ) {
                                                    echo "<option value='". $row['id_utilisateur'] ."' selected>";
                                                        echo $row['userlogin_admin'] ."  [Admin]";
                                                    echo "</option>";                                            
                                                } else {
                                                    echo "<option value='". $row['id_utilisateur'] ."' selected>";
                                                        echo $row['userlogin_client'];
                                                    echo "</option>";
                                                }                                         
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-11">
                                        <label>Produit</label>
                                        <select class="form-control" name="userid" required="required">>
                                            <?php
                                                echo "<option value='". $row['id_article'] ."' selected>";
                                                    echo $row['nom_article'];
                                                echo "</option>";                                        
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-11">
                                        <label for="">Commentaire</label>
                                        <textarea class="form-control" name="comment" disabled>
                                            <?php echo $row['contenue_commentaire'] ?>
                                        </textarea>
                                    </div>           
                                </div>  
                            </div>
                            <div class="col-md-5">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="">Répondre à ce commentaire</label>
                                        <textarea class="form-control" name="reply">
                                            <?php echo $row['reponse_admin'] ?>
                                        </textarea>
                                    </div>   
                                </div> 
                            </div>
                        </div>                                                   
                        <button 
                            type="submit" 
                            class="btn btn-primary btn-sm m-2 float-right" 
                            style="margin-top: 20px">Enregistrer
                        </button>
                        <button 
                            type="reset" 
                            class="btn btn-primary btn-sm m-2 float-right" 
                            style="margin-top: 20px">Annuler
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
                $commentid  = $_POST['commentid'];
                $reply    = $_POST['reply'];
                $stmt = $connect->prepare("UPDATE 
                                                commentaire 
                                            SET 
                                                reponse_admin = ?,
                                                date_reponse_admin = now()
                                            WHERE 
                                                id_commentaire = ?");
                $stmt->execute(array($reply, $commentid));
                $Msg = '<div class="container alert alert-success">
                            Commentaire mis à jour avec succes.
                        </div>';
                redirect($Msg, 'comments.php');
            } else {
                redirect('', 2);
            }
            echo '</div>';
        } elseif($do == 'Delete') {
            echo '<div class ="container" style="margin-top: 100px">';
            $commentid = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : 0;
            $check = checkItem('id_commentaire', 'commentaire', $commentid);
            if ($check > 0) {
                $stmt = $connect->prepare("DELETE FROM commentaire WHERE id_commentaire = :zid");
                $stmt->bindParam(":zid", $commentid);
                $stmt->execute();                
                $Msg = "<div class='container alert alert-success'>
                            Commentaire supprimé.
                        </div>";
                redirect($Msg, 'comments.php', 4);
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

        header('Location: index.php');
        exit();
    }