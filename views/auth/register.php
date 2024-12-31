<?php 
    include __DIR__.'/../layouts/header.php';
    include '../../database/connection.php';
?>
<?php 
    $user_name = $fullname = $user_password = '';
    $username_error = $full_name_error = $user_password_error = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // die();
        // fullname
        if (empty($_POST['fullname'])){
                $fullname_error = "Attention: nom est obligatoire";
        }else{
            $fullname = check_input($_POST['fullname']);
            // var_dump($fullname);
            // die();
        }
        // username
        if (empty($_POST['username'])){
            $full_name_error = "Attention: username est Obligatoire";
        }
        else{
                $tmp = check_input($_POST['username']);
                $sql = $conn -> prepare ("SELECT * FROM User WHERE username = ?");
                $sql -> bind_param("s", $tmp);
                $sql -> execute();
                $resultat = $sql -> get_result();
                // $row = $resultat->fetch_assoc();
                // echo "<pre>";
                // print_r($row);
                // echo "</pre>";
                // die();
                
                if($resultat -> num_rows > 0) {
                    $username_error = "username deja utilise, Essayer avec autre";
                }else{
                    $tmp = check_input($_POST['username']);
                    if($tmp == "admin"){
                        $id_role = 1;
                    }else{
                        $id_role = 2;
                    }
                    $user_name = $tmp;
                    // var_dump($fullname);
                    // die();
                }
            }
            
        
        // password
        if (empty($_POST['password'])){
            $user_password_error = "Attention: mot de passe et Obligatoire";
        }else {
            $tmp = check_input($_POST['password']);
            if (strlen($tmp) < 4) {
                $user_password_error = "mot de passe doit contient aumoins 4 carecteres";
            }else{
                $user_password = password_hash($tmp, PASSWORD_DEFAULT);
            }
        } 
    
    
    // register user
    // echo $user_name;
    // echo $fullname;
    // echo $user_password;
    // die();
    if (isset($user_name) && isset($fullname) && isset($user_password)){
    
            $sql = "INSERT INTO User(username, fullname, password, role_id) VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $user_name, $fullname, $user_password, $id_role);
            
            if($stmt->execute()){

                header('Location: register.php?added');   
            }else{
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
<h2>Register</h2>
<!-- TODO: Add registration form with input fields for username, password, etc. -->
<!-- Add Bootstrap form classes as needed -->
<form method="post" action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>">
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" name="username" id="username">
        <span><?=$username_error?></span>
    </div>
    <div class="form-group">
        <label for="fullname">Fullname:</label>
        <input type="text" class="form-control" name="fullname" id="fullname">
        <span><?=$full_name_error?></span>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" name="password" id="password">
        <span><?=$user_password_error?></span>
    </div>
    <!-- Add other registration fields as needed -->
    <button type="submit" name="submit" class="btn btn-success">Register</button>
</form>

<?php include __DIR__.'/../layouts/footer.php'; ?>
