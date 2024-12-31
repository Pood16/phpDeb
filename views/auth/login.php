<?php
include __DIR__.'/../layouts/header.php';
include '../../database/connection.php';


$user_name = $user_password = '';
$username_error = $user_password_error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
    // username
    if (empty($_POST['username'])) {
        $full_name_error = "Attention: username est Obligatoire";
    } else {
        $user_name = check_input($_POST['username']);
    }

    // password
    if (empty($_POST['password'])) {
        $user_password_error = "Attention: mot de passe et Obligatoire";
    } else {
        $tmp = check_input($_POST['password']);
        if (strlen($tmp) < 4) {
            $user_password_error = "mot de passe doit contient aumoins 4 carecteres";
        } else {
            $user_password = $tmp;
        }
    }

    // Login
    if (!empty($user_name) && !empty($user_password)) {
        $sql = "SELECT * FROM User WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $resultat = $stmt->get_result();

        if ($resultat->num_rows == 1) {
            $user = $resultat -> fetch_assoc();
            // echo "<pre>";
            // print_r($user);
            // echo "</pre>";
            // die();
            header('Location: login.php?logged');
        } else {
            echo "failed";
        }
    }
}

function check_input($input_value){
    $input_value = trim($input_value);
    $input_value = htmlspecialchars($input_value);
    return $input_value;
}
?>




<h2>Login</h2>

<form method="post" action="">
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" name="username" id="username">
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" name="password" id="password">
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
</form>

<?php include __DIR__.'/../layouts/footer.php'; ?>
