<?php 
    include'file/C68c7cdaaf1631ad30b9711f148205522ore.php';

    notlogin();

    $output = "";

    $treasury_query = mysqli_query($db, "SELECT * FROM treasury WHERE id='1'");
    $treasury_row = mysqli_fetch_array($treasury_query);
    $treasury_amount = $treasury_row['amount'];

    if(isset($_POST['saveN'])){
        $amount = $_POST['amount'];
        $new_treasury_amount = $amount + $treasury_amount;
        $type = "عمليه ايداع";
        $query =  mysqli_query($db, "UPDATE  treasury SET amount='$new_treasury_amount' WHERE id='1'");
        mysqli_query($db, "INSERT INTO  treasury_details (type,amount,date,time) VALUES ('$type','$amount','$dateNow','$timeNow')");

        if($query){$output ="<h4 class='text-success'>تـم ايـداع المبلغ بنجاح</h4><br>";}
        else{$output ="<h4 class='text-danger'>فشل </h4><br>";}
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
                        <li class="nav-item" role="presentation"><a class="nav-link active" id="tab-1" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">إجـمالي الموجود في الخزنـه (حاليا)</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="tab-2" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="true">إيـداع في الخزنـه</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="tab-4" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="true"> التقرير / عمليات الخزنـه </a></li>
                    </ul>

                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab-1"><br><br>
                            <h4>إجـمالي الموجود في الخزنـه</h4><br>
                            <?php 
                                $treasury_query = mysqli_query($db, "SELECT * FROM treasury WHERE id='1'");
                                $treasury_row = mysqli_fetch_array($treasury_query);
                                $treasury_amount = $treasury_row['amount'];
                                echo "<h4 class='text-white bg-dark col-md-5 p-2'>" . number_format($treasury_amount) . "</h4>";
                            ?>
                        </div>
                        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab-2"><br><br>
                            <form class="col-md-5" action="" method="post" autocomplete="off"><br>
                                <input type="number" class="form-control text-right" placeholder="المـبـلغ" required="" name="amount"><br>
                                <button class="btn btn-primary" type="submit" name="saveN"> &nbsp; حــفــظ الايداع &nbsp;</button>
                            </form><br><br><br>
                        </div>
                        <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab-4"><br><br>
                        <img src="/file/image/i68c7cdaaf1631ad30b9711f148205522con.png" class="printImage">
                            <h1 class="justPrint">الايـــمــــــان بـــــاك</h1>
                            <h3 class="justPrint">كشف حساب "إجمالي" لعمليات الخزينه</h3>
                            <button type="button" onclick="window.print()" class="printHide btn btn-primary"> طبـاعه الكشف</button><br><br>

                            <input type="text" class="form-control text-right col-md-5 printHide" placeholder="فلتر / ابحث هنا" id="myInput4"><br>
                            <table class="table table-bordered text-right" width="100%">
                                <thead>
                                    <tr role="row">
                                    <th class="sorting">التـاريـخ</th>
                                    <th class="sorting">المـبـلغ</th>
                                    <th class="sorting">بيــان الحركه</th>
                                    <th class="sorting" width="60px">م</th>
                                    </tr>
                                </thead>
                                <tbody id="myTable4">
                                    <?php
                                    $query = mysqli_query($db, "SELECT * FROM treasury_details");
                                    $i =1;
                                    while($row = mysqli_fetch_array($query))
                                    {
                                        $id = $row['id'];
                                        $type = $row['type'];
                                        $amount = number_format($row['amount']);
                                        $date = $row['date'];
                                        $time = $row['time'];
                                        $loop = $i++;

                                        echo "
                                        <tr role='row' class='odd'>
                                            <td>$date &nbsp; &nbsp; $time</td>
                                            <td>$amount</td>
                                            <td>$type</td>
                                            <td>$loop</td>
                                        </tr>
                                        ";
                                    }
                                    ?>  
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <br><br><?php echo $CopyRight;?>
                </center>
            </div>
            <?php echo $sideBar . $fixedDiv . $bottom_script;?>
        </div>
    </body>
</html>