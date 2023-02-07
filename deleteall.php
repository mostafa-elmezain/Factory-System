<?php 
    include'file/C68c7cdaaf1631ad30b9711f148205522ore.php';

    notlogin();

    $output = "";
    if(isset($_POST['delete']))
    {
        $password = mysqli_real_escape_string($db, htmlspecialchars(md5($_POST['password'])));
        

        $query = mysqli_query($db, "SELECT * FROM admin WHERE password='$password'");

        if (mysqli_num_rows($query) == 1) {

            mysqli_query($db, "DELETE FROM `banks`");
            mysqli_query($db, "DELETE FROM `customer`");
            mysqli_query($db, "DELETE FROM `customer_history`");
            mysqli_query($db, "DELETE FROM `fatora`");
            mysqli_query($db, "DELETE FROM `fatora_data`");
            mysqli_query($db, "DELETE FROM `recordattendance`");
            mysqli_query($db, "DELETE FROM `salery_details`");
            mysqli_query($db, "DELETE FROM `salery_note`");
            mysqli_query($db, "DELETE FROM `store`");
            mysqli_query($db, "DELETE FROM `store_details`");
            mysqli_query($db, "DELETE FROM `store_item`");
            mysqli_query($db, "DELETE FROM `treasury_details`");
            mysqli_query($db, "DELETE FROM `worker`");

            mysqli_query($db, "UPDATE  treasury SET amount=0 WHERE id=1");
           
        
            $output ="<h4 class='text-success'>نجحت العمليه, تم مسح جميع البيانات</h4><br><br>";

        }
        else{$output ="<h4 class='text-danger'>عذرا ، خطأ في معلومات تسجيل الدخول</h4><br><br>";}


        
    }
?>

<!Doctype HTML>
<html>
    <head> <?php echo $head;?> </head>
    <body>
        <div class="wrapper">
            <div id="content">
                <center><br>
                    <h1 class='text-danger'>اعاده ضبط البيانات - سيتم مسح جميع البيانات</h1><br><br><br>
                    <?php echo $output;?>
                    <form class="col-md-6" action="" method="post" autocomplete="off">
                        <div class="col-md-10 mb-5">
                            <div class="input-group">
                                <span toggle="#Harmpass" class="fa fa-eye toggle-password"></span>
                                <input type="password" id="Harmpass" class="form-control text-right" placeholder="ادخل كلمه المرور" required="" name="password" pattern="[A-Za-z0-9]{4,}">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="iHarm ilock"></i></span></div>
                            </div>
                        </div><br>        
                        <div class="text-left ml-5"><br><button class="btn btn-danger" type="submit" name="delete"> &nbsp;  مسح جميع البيانات &nbsp;</button></div>
                    </form><br><br><br><br><br>
                    <?php echo $CopyRight;?>
                </center>
            </div>
            <?php echo $sideBar . $fixedDiv . $bottom_script;?>
        </div>
    </body>
</html>