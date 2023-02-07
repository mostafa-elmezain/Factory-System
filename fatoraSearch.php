<?php 
    include'file/C68c7cdaaf1631ad30b9711f148205522ore.php';

    notlogin();

    if(isset($_POST['searchInput'])){
        $fatoraCode = $_POST['codeInput'];
    }

    if(isset($_GET['code'])){
        $fatoraCode = $_GET['code'];
    }


    $query1 =  mysqli_query($db, "SELECT * FROM fatora WHERE code='$fatoraCode'");
    $query2 =  mysqli_query($db, "SELECT * FROM fatora_data WHERE fatore_code='$fatoraCode'");

    if (mysqli_num_rows($query1) == 0) {
        $OutPut = "<h2>برجاء التاكد من كود الفاتوره</h2>";
    }
    else 
    {
        $FatoraRow = mysqli_fetch_array($query1);

        $fatoraId = $FatoraRow['id'];
        $fatoraCode = $FatoraRow['code'];
        $CustomerId = $FatoraRow['3ameel_id'];
        $TotalMoney = $FatoraRow['total_money'];
        $date = $FatoraRow['date'];
        $time = $FatoraRow['time'];
        $type = $FatoraRow['type'];

        $query3 = mysqli_query($db, "SELECT * FROM customer WHERE id='$CustomerId'");
        $CustomerRow = mysqli_fetch_array($query3);
        $CustomerName = $CustomerRow['name'];

        if($type == 1){ $textType = "مبيعات"; $textMan = "العميل"; }
        if($type == 0){ $textType = "مشتريات"; $textMan = "المورد"; }


        $OutPut = "
            <h1>الايـــمــــــان بـــــاك</h1>
            <h3>فاتـوره $textType</h3>
            <h4>$fatoraCode &nbsp; كود الفاتورة</h4>
            
            <hr>
            <div class='text-right'>
                <h4 class='pr-5'>$date &nbsp;&nbsp;  $time &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; التاريخ</h4>
                <hr>
                <h4 class='pr-5'>  اسم  $textMan : $CustomerName</h4>
                <hr>
            </div>

        
            <table id='table1' class='table table-bordered text-right' width='100%'>
                <thead>
                    <tr>
                        <th>القيمه</th>
                        <th>الكميه</th>
                        <th>سعر الوحده</th>
                        <th>البيان</th>
                        <th>م</th>
                    </tr>
                </thead>
                <tbody>";


                $k = 0;
                while($DataRow = mysqli_fetch_array($query2))
                {
                    $item_name = $DataRow['item_name'];
                    $item_price = $DataRow['item_price'];
                    $item_count = $DataRow['item_count'];
                    $item_cost = $DataRow['item_cost'];
                    $k++;
                    
                    $OutPut.= "
                    <tr>
                        <td>$item_cost</td>
                        <td>$item_count</td>
                        <td>$item_price</td>
                        <td>$item_name</td>
                        <td>$k</td>
                    </tr>
                    ";
                }

                
        $OutPut.="        
                </tbody>
            </table>
            <table class='table-bordered text-left' width='100%' style='margin-top: -17px;'>
                <tbody>
                    <tr><td  style='padding-left:100px'><h5 class=''>$TotalMoney  &nbsp; الإجمـالي</h5></td></tr>
                    <tr><td  style='padding-left:100px'><h5 class='justPrint'> ض . القيمه المضافه</h5></td></tr>
                    <tr><td  style='padding-left:100px'><h5 class='justPrint'>الاجمالي بعد ض . القيمه المضافه</h5></td></tr>
                </tbody>
            </table>

            <br>
            <table class='table table-bordered text-center justPrint-t' width='100%'>
                <tbody>
                    <tr>
                        <td><h5>اسم السائق</h5></td>
                        <td><h5>مسؤل المخزن</h5></td>
                        <td><h5>المستلم</h5></td>
                    </tr>
                    <tr>
                        <td><h5>..........................</h5></td>
                        <td><h5>..........................</h5></td>
                        <td><h5>..........................</h5></td>
                    </tr>
                </tbody>
            </table>
            <br><br>
            <button type='button' onclick='window.print()' class='printHide btn btn-primary'>طبـاعه </button>
            <br><br>
        ";
    }
?>

<!Doctype HTML>
<html>
    <head> <?php echo $head;?> </head>
    <body>
        <div class="wrapper">
            <div id="content" class="mainPrint">
                <center><br>
                    <form class="row float-right printHide" action="" method="post" autocomplete="off"><br>
                        <button class="btn btn-primary mr-4" type="submit" name="searchInput"> &nbsp;  استـعلام &nbsp;</button>
                        <input type="text" class="form-control text-right col-md-6" placeholder="كــود الفاتوره" required="" name="codeInput"><br>                                
                    </form><br><br><br>

                    <?php echo $OutPut .  $CopyRight;?>
                </center>
            </div>
            <?php echo $sideBar . $fixedDiv . $bottom_script;?>
        </div>
    </body>
</html>