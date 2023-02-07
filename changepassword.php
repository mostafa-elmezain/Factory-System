<?php 
    include'file/C68c7cdaaf1631ad30b9711f148205522ore.php';

    notlogin();

    $output = "";
    if(isset($_POST['change']))
    {
        $password = mysqli_real_escape_string($db, htmlspecialchars(md5($_POST['password'])));
        $query = mysqli_query($db, "UPDATE admin SET password='$password' WHERE  id=1");
        if($query){$output ="<h4 class='text-success'>تـم تغيير كلمه المرور بنجاح</h4><br><br>";}
        else{$output ="<h4 class='text-danger'>فشل , لم يتم تغيير كلمه المرور</h4><br><br>";}
    }
?>

<!Doctype HTML>
<html>
    <head> <?php echo $head;?> </head>
    <body>
        <div class="wrapper">
            <div id="content">
                <center><br>
                    <h1>تغيير كلمه المرور</h1><br><br><br>
                    <?php echo $output;?>
                    <form class="col-md-6" action="" method="post" autocomplete="off">
                        <div class="col-md-10 mb-5">
                            <div class="input-group">
                                <span toggle="#Harmpass" class="fa fa-eye toggle-password"></span>
                                <input type="password" id="Harmpass" class="form-control text-right" placeholder="ادخل كلمه المرور الجديده" required="" name="password" pattern="[A-Za-z0-9]{4,}">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="iHarm ilock"></i></span></div>
                            </div>
                        </div><br>        
                        <div class="text-left ml-5"><br><button class="btn btn-primary" type="submit" name="change"> &nbsp;  تغيير كلمه المرور &nbsp;</button></div>
                    </form><br><br><br><br><br>
                    <?php echo $CopyRight;?>
                </center>
            </div>
            <?php echo $sideBar . $fixedDiv . $bottom_script;?>
        </div>
    </body>
</html>