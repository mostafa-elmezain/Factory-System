<?php 
    include'file/C68c7cdaaf1631ad30b9711f148205522ore.php';

    notlogin();

    $output = "";

    if(isset($_POST['saveitem'])){
        $name = $_POST['name'];
        $query =  mysqli_query($db, "INSERT INTO  store_item (item) VALUES ('$name')");

        if($query){$output ="<h4 class='text-success'>تـمـت العمـليه بنجـاح</h4><br>";}
        else{$output ="<h4 class='text-danger'>فشل </h4><br>";}
    }
    
    if(isset($_POST['savei'])){
        $item_id = $_POST['item_id'];
        $much = $_POST['much'];
        $type = "عمليه إضافه";

        $store_row1 = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM store_item WHERE id='$item_id'"));
        $name = $store_row1['item'];

        $store_count = mysqli_num_rows(mysqli_query($db, "SELECT * FROM store WHERE item_id='$item_id' "));
        if($store_count == 0){
            $query =  mysqli_query($db, "INSERT INTO  store (item_id,name,much,date,time) VALUES ('$item_id','$name','$much','$dateNow','$timeNow')");
            mysqli_query($db, "INSERT INTO  store_details (type,name,much,date,time) VALUES ('$type','$name','$much','$dateNow','$timeNow')");


            if($query){$output ="<h4 class='text-success'>تـمـت العمـليه بنجـاح</h4><br>";}
            else{$output ="<h4 class='text-danger'>فشل </h4><br>";}
        }
        else{
            $store_row = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM store WHERE item_id='$item_id'"));
            $item_much = $store_row['much'];
            $new_much = $item_much + $much;

            $query =  mysqli_query($db, "UPDATE  store SET much='$new_much' WHERE item_id='$item_id'");
            mysqli_query($db, "INSERT INTO  store_details (type,name,much,date,time) VALUES ('$type','$name','$much','$dateNow','$timeNow')");

            if($query){$output ="<h4 class='text-success'>تـمـت العمـليه بنجـاح</h4><br>";}
            else{$output ="<h4 class='text-danger'>فشل </h4><br>";}
        }

    }

    if(isset($_POST['saved'])){
        $item_id = $_POST['item_id'];
        $much = $_POST['much'];
        $type = "عمليه سحب";

        $store_row1 = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM store_item WHERE id='$item_id'"));
        $name = $store_row1['item'];

        $store_row = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM store WHERE item_id='$item_id'"));
        $item_much = $store_row['much'];
        $new_much = $item_much - $much;

        $query =  mysqli_query($db, "UPDATE  store SET much='$new_much' WHERE item_id='$item_id'");
        mysqli_query($db, "INSERT INTO  store_details (type,name,much,date,time) VALUES ('$type','$name','$much','$dateNow','$timeNow')");


        if($query){$output ="<h4 class='text-success'>تـمـت العمـليه بنجـاح</h4><br>";}
        else{$output ="<h4 class='text-danger'>فشل </h4><br>";}

    }
?>

<!Doctype HTML>
<html>
    <head> <?php echo $head;?> </head>
    <body>
        <div class="wrapper">
            <div id="content">
                <center><br>
                    
                <?php echo $output;?>

                <ul class="nav nav-tabs" id="myTab" role="tablist" style="direction: rtl;padding-right: 0;">
                    <li class="nav-item" role="presentation"><a class="nav-link active" id="tab-1" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">إجـمالي الموجود (حاليا) في المــخزن </a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" id="tab-2" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="true"> إضافه صنف  (جديد) </a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" id="tab-3" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="true"> دخول بضاعه / إضـافه الـي المــخزن</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" id="tab-4" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="true"> سحب من المــخزن</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" id="tab-5" data-toggle="tab" href="#tab5" role="tab" aria-controls="tab5" aria-selected="true"> تقرير / عمليات المخزن</a></li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab-1"><br><br>
                        <input type="text" class="form-control text-right col-md-5" placeholder="فلتر / ابحث هنا" id="myInput5"><br>
                        <table class="table table-bordered text-right" width="100%">
                            <thead>
                                <tr role="row">
                                <th class="sorting">الكميه الموجوده / بالكيلو</th>
                                <th class="sorting">اسـم المنتج / الصنـف</th>
                                <th class="sorting" width="60px">م</th>
                                </tr>
                            </thead>
                            <tbody id="myTable5">
                                <?php
                                $query = mysqli_query($db, "SELECT * FROM store ");
                                $i = 1;
                                while($row = mysqli_fetch_array($query))
                                {
                                    $id = $row['id'];
                                    $name = $row['name'];
                                    $much = number_format($row['much']);
                                    $loop = $i++;

                                    echo "
                                    <tr role='row' class='odd'>
                                        
                                        <td>$much</td>
                                        <td>$name</td>
                                        <td>$loop</td>
                                    </tr>
                                    ";
                                }
                                ?>  
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab-2"><br><br>
                        <form class="col-md-5" action="" method="post" autocomplete="off"><br>
                            <input type="text" class="form-control text-right" placeholder="اســم المنتـج / نـوعه" required="" name="name"><br>
                            <button class="btn btn-primary" type="submit" name="saveitem"> &nbsp; حـفـظ &nbsp;</button>
                        </form><br><br><br>
                    </div>
                    <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab-3"><br><br>
                        <form class="col-md-5" action="" method="post" autocomplete="off"><br>
                            <select class="custom-select" name="item_id" required>
                                <option selected disabled>اختـر من الاصناف الموجوده</option>
                                <?php
                                    $query = mysqli_query($db, "SELECT * FROM store_item ");
                                    while($row = mysqli_fetch_array($query))
                                    {
                                        $id = $row['id'];
                                        $name = $row['item'];

                                        echo "<option value='$id'>$name</option>";
                                    }
                                ?>  
                            </select><br><br>
                            <input type="number" class="form-control text-right" placeholder="إجمـالي الكميـه بالكيلو" required="" name="much"><br>
                            <button class="btn btn-primary" type="submit" name="savei"> &nbsp; اتمـام العمليه &nbsp;</button>
                        </form><br><br><br>
                    </div>
                    <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab-4"><br><br>
                        <form class="col-md-5" action="" method="post" autocomplete="off"><br>
                            <select class="custom-select" name="item_id" required>
                                <option selected disabled>اختـر من الاصناف الموجوده</option>
                                <?php
                                    $query = mysqli_query($db, "SELECT * FROM store_item ");
                                    while($row = mysqli_fetch_array($query))
                                    {
                                        $id = $row['id'];
                                        $name = $row['item'];

                                        echo "<option value='$id'>$name</option>";
                                    }
                                ?>  
                            </select><br><br>
                            <input type="number" class="form-control text-right" placeholder="إجمـالي الكميـه بالكيلو" required="" name="much"><br>
                            <button class="btn btn-primary" type="submit" name="saved"> &nbsp; اتمـام العمليه &nbsp;</button>
                        </form><br><br><br>
                    </div>
                    <div class="tab-pane fade show" id="tab5" role="tabpanel" aria-labelledby="tab-5"><br><br>
                        <input type="text" class="form-control text-right col-md-5" placeholder="فلتر / ابحث هنا" id="myInput6"><br>
                        <table class="table table-bordered text-right" width="100%">
                            <thead>
                                <tr role="row">
                                <th class="sorting">التـاريـخ</th>
                                <th class="sorting">الكميه / بالكيلو</th>
                                <th class="sorting">اسـم المنتج / نوعه</th>
                                <th class="sorting">نوع العمليه </th>
                                <th class="sorting" width="60px">م</th>
                                </tr>
                            </thead>
                            <tbody id="myTable6">
                                <?php
                                $query = mysqli_query($db, "SELECT * FROM store_details ");
                                $i = 1;

                                while($row = mysqli_fetch_array($query))
                                {
                                    $id = $row['id'];
                                    $type = $row['type'];
                                    $name = $row['name'];
                                    $much = number_format($row['much']);
                                    $date = $row['date'];
                                    $time = $row['time'];
                                    $loop = $i++;

                                    echo "
                                    <tr role='row' class='odd'>
                                        <td>$date &nbsp;&nbsp;  $time</td>
                                        <td>$much</td>
                                        <td>$name</td>
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

                <?php echo $CopyRight;?>
                </center>
            </div>
            <?php echo $sideBar . $fixedDiv . $bottom_script;?>
        </div>
    </body>
</html>