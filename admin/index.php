<?php
    session_start();
    $noNavbar = '';
    $pageTitle = 'Login';

    if(isset($_SESSION['userlogin_admin'])) {
        header('Location: dashboard.php');
    } elseif(isset($_SESSION['id_client'])) {
        include_once 'connect.php';
        $stmt = $connect->prepare("SELECT id_utilisateur FROM client WHERE id_client = ?");
        $stmt->execute(array($_SESSION['id_client']));
        $userID = $stmt->fetch()['id_utilisateur'];
        $req = $connect->prepare("SELECT group_utilisateur FROM utilisateur WHERE id_utilisateur = ?");
        $req->execute(array($userID));
        $userGroup = $req->fetch()['group_utilisateur'];
        if($userGroup == 'ADMIN') {
            header('Location: dashboard.php');
        }
    }

    include 'init.php';

    // Check if User coming from HTTP Post Request

    if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hashedPass = sha1($password);

        // Check if User exists in DataBase

        $stmt = $connect->prepare("SELECT * FROM admin WHERE userlogin_admin = ? AND password_admin = ? ");
        $stmt->execute(array($username, $hashedPass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        // If count > 0 This means that the Database contain record about this username

        if( $count > 0 ) {
            $_SESSION['userlogin_admin'] = $username; // Register Session Name
            $_SESSION['prenom'] = $row['prenom_admin'];
            $_SESSION['id'] = $row['id_admin']; // Register Session ID
            header('Location: dashboard.php');  // Redirect To Dashboard Page
            exit();
        }
    }
?>
    <div class="login m-auto p-3 justify-content-center row">
        <div class="w-50 text-center form">
            <h4>Admin Login</h4>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off" required="required"/>
                <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password" required="required"/>
                <input class="btn btn-primary btn-user btn-block" type="submit" value="login">
            </form>
        </div>
    </div>

<?php
    include $tpl . 'footer.php';
?>
