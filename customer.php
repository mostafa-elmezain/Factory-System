<?php 
    include'file/C68c7cdaaf1631ad30b9711f148205522ore.php';

    notlogin();

    $output="";

    $type = $_GET['type'];

    if($type == 1){ $textTotal = "العملاء"; $textMan = "العميل"; }
    elseif($type == 0){ $textTotal = "الموردين"; $textMan = "المورد"; }

    if(isset($_POST['save'])){
        $name = $_POST['name'];
        $adress = $_POST['adress'];
        $phone = $_POST['phone'];
        $zero = 0;
        
        $query =  mysqli_query($db, "INSERT INTO  customer (name,adress,phone,type,blance) VALUES ('$name','$adress','$phone','$type','$zero')");

        if($query){$output ="<h4 class='text-success'>تـم تسجيل بيانات $textMan بنجاح</h4><br>";}
        else{$output ="<h4 class='text-danger'>فشل </h4><br>";}
    }

    $query = mysqli_query($db, "SELECT * FROM customer WHERE type='$type'");
    $count = mysqli_num_rows($query);
?>

<!Doctype HTML>
<html>
    <head> <?php echo $head;?> </head>
    <body>
        <div class="wrapper">
            <div id="content">
                <center><br>
                <?php echo $output;?>
   
                    <form class="col-md-12 row float-right" action="" method="post" autocomplete="off"><br>
                        <button class="btn btn-primary mr-4" type="submit" name="save"> &nbsp;  إضــافه &nbsp;</button>
                        <input type="text" class="form-control text-right col-md-3 mr-4" placeholder=" رقم الموبايل " required="" name="phone"><br><br>
                        <input type="text" class="form-control text-right col-md-3 mr-4" placeholder="العنــوان " required="" name="adress"><br>
                        <input type="text" class="form-control text-right col-md-4" placeholder="اســم <?php echo $textMan;?> " required="" name="name"><br>                                
                    </form><br><br><br>
                    <hr>
                        
                    <input type="text" class="form-control text-right col-md-5 float-right" placeholder="فلتر / ابحث هنا" id="myInput8">
                    <b>إجمــالي عدد <?php echo $textTotal;?> : <?php echo $count;?></b>
                    <br><br>
                    <table class="table table-bordered text-right" width="100%">
                        <thead>
                            <tr role="row">
                            <th class="sorting"></th>
                            <th class="sorting">الرصيد</th>
                            <th class="sorting">رقم الموبايل</th>
                            <th class="sorting">  العنوان</th>
                            <th class="sorting">اسم <?php echo $textMan;?></th>
                            <th class="sorting">#</th>
                            </tr>
                        </thead>
                        <tbody id="myTable8">
                            <?php

                            $i = 1;
                            while($row = mysqli_fetch_array($query))
                            {
                                $id = $row['id'];
                                $name = $row['name'];
                                $adress = $row['adress'];
                                $phone = $row['phone'];
                                $blance = number_format($row['blance']);
                                
                                $loop = $i++;

                                echo "
                                <tr role='row' class='odd'>
                                    <td class='text-center'><a href='addblance?id=$id' class='btn btn-primary'>إضافه رصيد</a></td>
                                    <td>$blance</td>
                                    <td>$phone</td>
                                    <td>$adress</td>
                                    <td>$name</td>
                                    <td>$loop</td>
                                </tr>
                                ";
                            }
                            ?>  
                        </tbody>
                    </table>
                    <?php echo $CopyRight;?>
                </center>
            </div>
            <?php echo $sideBar . $fixedDiv . $bottom_script;?>
        </div>
    </body>
</html>