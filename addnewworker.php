<?php 
    include'file/C68c7cdaaf1631ad30b9711f148205522ore.php';

    notlogin();

    $output = "";
    if(isset($_POST['save']))
    {
        $name = mysqli_real_escape_string($db, htmlspecialchars($_POST['name']));
        $adress = mysqli_real_escape_string($db, htmlspecialchars($_POST['adress']));
        $id_num = mysqli_real_escape_string($db, htmlspecialchars($_POST['id_num']));
        $phone = mysqli_real_escape_string($db, htmlspecialchars($_POST['phone']));
        $salery = mysqli_real_escape_string($db, htmlspecialchars($_POST['salery']));

        $query = mysqli_query($db, "INSERT INTO worker (name,adress,id_num,phone,salery) VALUES ('$name','$adress','$id_num','$phone','$salery')");
        if($query){$output ="<h4 class='text-success'>نجاح , تم حـفظ بيانات العـامل</h4><br>";}
        else{$output ="<h4 class='text-danger'>فشل , لم يتم حـفظ بيانات العـامل</h4><br>";}
    }
?>

<!Doctype HTML>
<html>
    <head> <?php echo $head;?> </head>
    <body>
        <div class="wrapper">
            <div id="content">
                <center><br>
                    <h1>إضافه عامل جديد</h1><br><br>
                    <?php echo $output;?>
                    <form class="col-md-5" action="" method="post" autocomplete="off">
                        <div class="col-md-12 mb-2"><br>
                            <div class="input-group">
                                <input type="text" class="form-control text-right" placeholder="إسـم العـامـل" required="" name="name">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="iHarm iuser"></i></span></div>                                    
                            </div>
                        </div>
                        <div class="col-md-12 mb-2"><br>
                            <div class="input-group">
                                <input type="text" class="form-control text-right" placeholder="عنـوان العـامـل" required="" name="adress">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="iHarm ipaper"></i></span></div>                                    
                            </div>
                        </div>
                        <div class="col-md-12 mb-2"><br>
                            <div class="input-group">
                                <input type="text" class="form-control text-right" placeholder="رقـم البـطـاقه" required="" name="id_num">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="iHarm itag"></i></span></div>                                    
                            </div>
                        </div>
                        <div class="col-md-12 mb-2"><br>
                            <div class="input-group">
                                <input type="text" class="form-control text-right" placeholder="رقـم المـوبايل" required="" name="phone">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="iHarm iphone"></i></span></div>                                    
                            </div>
                        </div>
                        <div class="col-md-12 mb-2"><br>
                            <div class="input-group">
                                <input type="text" class="form-control text-right" placeholder="الراتـب الثـابت" required="" name="salery">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="iHarm ivisa"></i></span></div>                                    
                            </div>
                        </div><br>                        <br>
                        <button class="btn btn-primary" type="submit" name="save"> &nbsp; حـفظ بيانات العـامـل &nbsp;</button>
                    </form><br><br><br><br>
                    <?php echo $CopyRight;?>
                </center>
            </div>
            <?php echo $sideBar . $fixedDiv . $bottom_script;?>
        </div>
    </body>
</html>