<?php 
    include'file/C68c7cdaaf1631ad30b9711f148205522ore.php';

    islogin();

    $errors = array();

    if(isset($_POST['login']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(empty($username) || empty($password)){
            array_push($errors, "عذرا ، خطأ في معلومات تسجيل الدخول");
        }
        elseif(!preg_match("/^[a-zA-Z_]{4,50}$/", $username)){
            array_push($errors, "عذرا ، خطأ في معلومات تسجيل الدخول");
        }
        else
        {
            $username = mysqli_real_escape_string($db, htmlspecialchars($username));
            $password = mysqli_real_escape_string($db, htmlspecialchars(md5($password)));

            if (count($errors) == 0)
            {
                $query = mysqli_query($db, "SELECT * FROM admin WHERE username='$username' AND password='$password'");

                if (mysqli_num_rows($query) == 1) {
                    setcookie("username", $username, time() + (31536000));
                    setcookie("password", $password, time() + (31536000));
                    $_SESSION['login'] = $username;
                    header('location: Home');     
                }
                else {array_push($errors, "عذرا ، خطأ في معلومات تسجيل الدخول");}
            }
        }
    }
?>
<!Doctype HTML>
<html>
    <head> <?php echo $head;?> </head>
    <body>
        <center><br><br><br>
        <h1>الإيمان باك - تسجيل الدخول</h1><br><br>
        <h4 class='text-danger'><?php  if (count($errors) > 0){foreach ($errors as $error){echo $error;}}?></h4><br><br>
        <form class="col-md-5" action="" method="post" autocomplete="off">
            <div class="col-md-10 mb-4"><br>
                <div class="input-group">
                    <input type="text" class="form-control text-right" placeholder="إسم المستخدم" required="" name="username" value="admin">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="iHarm iuser"></i></span></div>                                    
                </div>
            </div>
            <div class="col-md-10 mb-5">
                <div class="input-group">
                    <span toggle="#Harmpass" class="fa fa-eye toggle-password"></span>
                    <input type="password" id="Harmpass" class="form-control text-right" placeholder="ادخل كلمه المرور" required="" name="password">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="iHarm ilock"></i></span></div>
                </div>
            </div><br>        
            <div class="text-left ml-5"><br><button class="btn btn-primary" type="submit" name="login"> &nbsp; تسجيل الدخول &nbsp;</button></div>
        </form><br><br><br><br><br>
        <?php echo $CopyRight;?>
        </center>
        <?php echo $bottom_script;?>
    </body>
</html>