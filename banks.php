<?php 
    include'file/C68c7cdaaf1631ad30b9711f148205522ore.php';

    notlogin();

    $output="";

    $ThisMonth = date("m");
    $ThisYear = date("Y");

    $i = 1;

    if(isset($_POST['save'])){
        $name = $_POST['name'];
        $much = $_POST['much'];

        $type = "مصروفات - $name";

        $query =  mysqli_query($db, "INSERT INTO  banks (name,much,date,time) VALUES ('$name','$much','$dateNow','$timeNow')");

        $treasury_row = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM treasury WHERE id='1'"));
        $treasury_amount = $treasury_row['amount'];
        $new_treasury_amount = $treasury_amount - $much;
        mysqli_query($db, "UPDATE  treasury SET amount='$new_treasury_amount' WHERE id='1'");
        mysqli_query($db, "INSERT INTO  treasury_details (type,amount,date,time) VALUES ('$type','$much','$dateNow','$timeNow')");

        if($query){$output ="<h4 class='text-success'>تـمـت العمـليه بنجـاح</h4><br>";}
        else{$output ="<h4 class='text-danger'>فشل </h4><br>";}
    }

    if(isset($_GET['delete'])){
        $rowID = $_GET['data'];

        $query = mysqli_query($db, "DELETE FROM `items` WHERE id='$rowID'");
        if($query){$output ="<h4 class='text-success'>تـم حذف بنجاح</h4><br>";}
        else{$output ="<h4 class='text-danger'>فشل </h4><br>";}
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
?>

<!Doctype HTML>
<html>
    <head> <?php echo $head;?> </head>
    <body>
        <div class="wrapper">
            <div id="content" class="mainPrint">
                <center><br>
                <?php echo $output;?>

                    <ul class="nav nav-tabs printHide" id="myTab" role="tablist" style="direction: rtl;padding-right: 0;">
                        <li class="nav-item" role="presentation"><a class="nav-link active" id="tab-1" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true"> تســجيل مصاريف جديده  </a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="tab-2" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="true"> مصاريف اليوم</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="tab-3" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="true"> مصاريف شهريه (للشهر الحالي)</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="tab-4" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="true"> مصاريف سنويه (للسنه الحاليه)</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="tab-5" data-toggle="tab" href="#tab5" role="tab" aria-controls="tab5" aria-selected="true"> عرض قائمه المصروفات (الإجماليه)</a></li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab-1"><br><br>
                            <form class="col-md-5" action="" method="post" autocomplete="off"><br>
                                <input type="number" class="form-control text-right" placeholder="المبــلغ المصروف" required="" name="much"><br>
                                <textarea type="text" class="form-control text-right" placeholder="بيـان / سبب حركه الصرف" required="" name="name"></textarea><br><br>
                                <button class="btn btn-primary" type="submit" name="save"> &nbsp; حفــظ العمـليه  &nbsp;</button>
                            </form><br><br><br>
                        </div>

                        <div class="tab-pane fade show" id="tab2" role="tabpanel" aria-labelledby="tab-2"><br><br>
                        
                            <h4><span id='total2'></span>  : الإجمـالي</h4>
                            <input type="text" class="form-control text-right col-md-5 printHide" placeholder="فلتر / ابحث هنا" id="myInput7"><br>
                            <table class="table table-bordered text-right" width="100%">
                                <thead>
                                    <tr role="row">
                                    <th class="sorting">التـاريـخ</th>
                                    <th class="sorting">  المبــلغ المصروف</th>
                                    <th class="sorting">بيـان  حركه الصرف</th>
                                    <th class="sorting" width="60px">م</th>
                                    </tr>
                                </thead>
                                <tbody id="myTable7">
                                    <?php
                                    $query = mysqli_query($db, "SELECT * FROM banks WHERE date='$dateNow'");
                                    while($row = mysqli_fetch_array($query))
                                    {
                                        $id = $row['id'];
                                        $name = $row['name'];
                                        $much = $row['much'];
                                        $date = $row['date'];
                                        $time = $row['time'];
                                        $loop = $i++;

                                        $newmuch2 += $much;
                                        $money = number_format($much);

                                        echo "
                                        <tr role='row' class='odd'>
                                            <td>$date &nbsp;&nbsp; $time</td>
                                            <td class='total2'>$money</td>
                                            <td>$name</td>
                                            <td>$loop</td>
                                        </tr>
                                        ";
                                    }
                                    ?>  
                                </tbody>
                            </table><br>
                        </div>

                        <div class="tab-pane fade show" id="tab3" role="tabpanel" aria-labelledby="tab-3"><br>
                            <img src="/file/image/i68c7cdaaf1631ad30b9711f148205522con.png" class="printImage">
                            <h1 class="justPrint">الايـــمــــــان بـــــاك</h1>
                            <h3 class="justPrint"><?php echo $ThisYear;?> / <?php echo $ThisMonth?> كشف حساب لمصاريف شهر </h3>
                            <button type="button" onclick="window.print()" class="printHide btn btn-primary"> طبـاعه الكشف</button><br><br>
                        
                            <h4><span id='total3'></span>  : الإجمـالي</h4>
                            <input type="text" class="form-control text-right col-md-5 printHide" placeholder="فلتر / ابحث هنا" id="myInput7"><br>
                            <table class="table table-bordered text-right" width="100%">
                                <thead>
                                    <tr role="row">
                                    <th class="sorting">التـاريـخ</th>
                                    <th class="sorting">  المبــلغ المصروف</th>
                                    <th class="sorting">بيـان  حركه الصرف</th>
                                    <th class="sorting" width="60px">م</th>
                                    </tr>
                                </thead>
                                <tbody id="myTable7">
                                    <?php

                                    $i =  1;
                                    $query = mysqli_query($db, "SELECT * FROM banks WHERE MONTH(Date) ='$ThisMonth' and YEAR(Date) ='$ThisYear'");
                                    while($row = mysqli_fetch_array($query))
                                    {
                                        $id = $row['id'];
                                        $name = $row['name'];
                                        $much = $row['much'];
                                        $date = $row['date'];
                                        $time = $row['time'];
                                        $loop = $i++;

                                        $newmuch3 += $much;
                                        $money = number_format($much);
                                        
                                        echo "
                                        <tr role='row' class='odd'>
                                            <td>$date &nbsp;&nbsp; $time</td>
                                            <td class='total3'>$money</td>
                                            <td>$name</td>
                                            <td>$loop</td>
                                        </tr>
                                        ";
                                    }
                                    ?>  
                                </tbody>
                            </table><br>
                        </div>

                        <div class="tab-pane fade show" id="tab4" role="tabpanel" aria-labelledby="tab-4"><br>
                            <img src="/file/image/i68c7cdaaf1631ad30b9711f148205522con.png" class="printImage">
                            <h1 class="justPrint">الايـــمــــــان بـــــاك</h1>
                            <h3 class="justPrint"><?php echo $ThisYear;?> كشف حساب لمصاريف سنه </h3>
                            <button type="button" onclick="window.print()" class="printHide btn btn-primary"> طبـاعه الكشف</button><br><br>
                        
                            <h4><span id='total4'></span>  : الإجمـالي</h4>
                            <input type="text" class="form-control text-right col-md-5 printHide" placeholder="فلتر / ابحث هنا" id="myInput7"><br>
                            <table class="table table-bordered text-right" width="100%">
                                <thead>
                                    <tr role="row">
                                    <th class="sorting">التـاريـخ</th>
                                    <th class="sorting">  المبــلغ المصروف</th>
                                    <th class="sorting">بيـان  حركه الصرف</th>
                                    <th class="sorting" width="60px">م</th>
                                    </tr>
                                </thead>
                                <tbody id="myTable7">
                                    <?php

                                    $i = 1;
                                    $query = mysqli_query($db, "SELECT * FROM banks WHERE YEAR(Date) ='$ThisYear'");
                                    while($row = mysqli_fetch_array($query))
                                    {
                                        $id = $row['id'];
                                        $name = $row['name'];
                                        $much = $row['much'];
                                        $date = $row['date'];
                                        $time = $row['time'];
                                        $loop = $i++;

                                        $newmuch4 += $much;
                                        $money = number_format($much);

                                        echo "
                                        <tr role='row' class='odd'>
                                            <td>$date &nbsp;&nbsp; $time</td>
                                            <td class='total4'>$money</td>
                                            <td>$name</td>
                                            <td>$loop</td>
                                        </tr>
                                        ";
                                    }
                                    ?>  
                                </tbody>
                            </table><br>
                        </div>
                        

                        <div class="tab-pane fade show" id="tab5" role="tabpanel" aria-labelledby="tab-5"><br>
                            <img src="/file/image/i68c7cdaaf1631ad30b9711f148205522con.png" class="printImage">
                            <h1 class="justPrint">الايـــمــــــان بـــــاك</h1>
                            <h3 class="justPrint">كشف حساب "اجمالي" للمصاريف</h3>
                            <button type="button" onclick="window.print()" class="printHide btn btn-primary"> طبـاعه الكشف</button><br><br>
                            <h4><span id='total'></span>  : الإجمـالي</h4>
                            <input type="text" class="form-control text-right col-md-5 printHide" placeholder="فلتر / ابحث هنا" id="myInput7"><br>
                            <table class="table table-bordered text-right" width="100%">
                                <thead>
                                    <tr role="row">
                                    <th class="sorting">التـاريـخ</th>
                                    <th class="sorting">  المبــلغ المصروف</th>
                                    <th class="sorting">بيـان  حركه الصرف</th>
                                    <th class="sorting" width="60px">م</th>
                                    </tr>
                                </thead>
                                <tbody id="myTable7">
                                    <?php
                                    $i=1;
                                    $newmuch = 0;
                                    $query = mysqli_query($db, "SELECT * FROM banks ");
                                    while($row = mysqli_fetch_array($query))
                                    {
                                        $id = $row['id'];
                                        $name = $row['name'];
                                        $much = $row['much'];
                                        $date = $row['date'];
                                        $time = $row['time'];
                                        $loop = $i++;

                                        $newmuch += $much;
                                        $money = number_format($much);

                                        echo "
                                        <tr role='row' class='odd'>
                                            <td>$date &nbsp;&nbsp; $time</td>
                                            <td class='total'> $money</td>
                                            <td>$name</td>
                                            <td>$loop</td>
                                        </tr>
                                        ";
                                    }
                                    ?>  
                                </tbody>
                            </table><br>
                        </div>
                        


                    </div>



                <?php echo $CopyRight;?>
                </center>
            </div>
            <?php echo $sideBar . $fixedDiv . $bottom_script;?>
        </div>
        <script>
            $('#total').html("<?php echo number_format($newmuch);?>");
            $('#total2').html("<?php echo number_format($newmuch2);?>");
            $('#total3').html("<?php echo number_format($newmuch3);?>");
            $('#total4').html("<?php echo number_format($newmuch4);?>");
        </script>
    </body>
</html>