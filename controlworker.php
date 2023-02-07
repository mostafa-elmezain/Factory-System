<?php 
    include'file/C68c7cdaaf1631ad30b9711f148205522ore.php';

    notlogin();

    $workerId = $_GET['i'];

    $query = mysqli_query($db, "SELECT * FROM worker WHERE id=$workerId");
    $row = mysqli_fetch_array($query);

    $id = $row['id'];
    $name = $row['name'];
    $adress = $row['adress'];
    $phone = $row['phone'];
    $id_num = $row['id_num'];
    $salery = $row['salery'];

    $output = "";
    if(isset($_POST['edite']))
    {
        $name = mysqli_real_escape_string($db, htmlspecialchars($_POST['name']));
        $adress = mysqli_real_escape_string($db, htmlspecialchars($_POST['adress']));
        $id_num = mysqli_real_escape_string($db, htmlspecialchars($_POST['id_num']));
        $phone = mysqli_real_escape_string($db, htmlspecialchars($_POST['phone']));
        $salery = mysqli_real_escape_string($db, htmlspecialchars($_POST['salery']));


        $query = mysqli_query($db, "UPDATE  worker SET name='$name',adress='$adress',id_num='$id_num',phone='$phone',salery='$salery' WHERE id='$workerId'");
        if($query){$output ="<h4 class='text-success'>نجاح , تم تعديل بيانات العـامل</h4><br>";}
        else{$output ="<h4 class='text-danger'>فشل , لم يتم تعديل بيانات العـامل</h4><br>";}
    }

    if(isset($_POST['savediscount'])){
        $amount = $_POST['amount'];
        $note = $_POST['note'];
        $type = "0";

        $query = mysqli_query($db, "INSERT INTO salery_note (workerid,amount,note,type,date,time) VALUES ('$workerId','$amount','$note','$type','$dateNow','$timeNow')");
        if($query){$output ="<h4 class='text-success'>تم اضافه الخصم بنجاح سيتم الخصم عند القبض</h4><br>";}
        else{$output ="<h4 class='text-danger'>فشل </h4><br>";}
    }

    if(isset($_GET['delete'])){
        $rowID = $_GET['data'];

        $query = mysqli_query($db, "DELETE FROM `salery_note` WHERE id='$rowID'");
        if($query){$output ="<h4 class='text-success'>تـم حذف الخصم بنجاح</h4><br>";}
        else{$output ="<h4 class='text-danger'>فشل </h4><br>";}
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    if(isset($_POST['saveincreament'])){
        $amount = $_POST['amount'];
        $note = $_POST['note'];
        $type = "1";

        $query = mysqli_query($db, "INSERT INTO salery_note (workerid,amount,note,type,date,time) VALUES ('$workerId','$amount','$note','$type','$dateNow','$timeNow')");
        if($query){$output ="<h4 class='text-success'>تم اضافه المبلغ بنجاح سيتم الاضافه عند القبض</h4><br>";}
        else{$output ="<h4 class='text-danger'>فشل </h4><br>";}

    }

    if(isset($_GET['salery'])){
        $workerid = $_GET['i'];
        $salery = $_GET['s'];
        $discount = $_GET['d'];
        $increase = $_GET['n'];
        $amount = $_GET['a'];
        $type = $_GET['t'];

        $treasury_query = mysqli_query($db, "SELECT * FROM treasury WHERE id='1'");
        $treasury_row = mysqli_fetch_array($treasury_query);
        $treasury_amount = $treasury_row['amount'];
        $new_treasury_amount = $treasury_amount - $amount;
        mysqli_query($db, "UPDATE  treasury SET amount='$new_treasury_amount' WHERE id='1'");
        mysqli_query($db, "INSERT INTO  treasury_details (type,amount,date,time) VALUES ('$type','$amount','$dateNow','$timeNow')");
        mysqli_query($db, "INSERT INTO  salery_details (workerid,salery,discount,increase,amount,date,time) VALUES ('$workerid','$salery','$discount','$increase','$amount','$dateNow','$timeNow')");
        mysqli_query($db, "DELETE FROM `salery_note` WHERE workerid='$workerid'");

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    
?>

<!Doctype HTML>
<html>
    <head> <?php echo $head;?> </head>
    <body>
        <div class="wrapper">
            <div id="content">
                <center><br>
                    <img style="width:100px" src="/file/image/worker.png"><br><br>
                    <h3 class="text-primary"><?php echo $name;?></h3><br>
                    <?php echo $output;?>

                    <ul class="nav nav-tabs" id="myTab" role="tablist" style="direction: rtl;padding-right: 0;">
                        <li class="nav-item" role="presentation"><a class="nav-link active" id="tab-1" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">تـعديـل المعلومات</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="tab-2" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="true"> خصم من المرتب</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="tab-4" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="true"> زياده علي المرتب </a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="tab-5" data-toggle="tab" href="#tab5" role="tab" aria-controls="tab5" aria-selected="true">  سجل الإضــافـات / الخصومات</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="tab-6" data-toggle="tab" href="#tab6" role="tab" aria-controls="tab6" aria-selected="true"> سجل الحــضـور اليومي</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="tab-7" data-toggle="tab" href="#tab7" role="tab" aria-controls="tab7" aria-selected="true"> الـقــبـض</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" id="tab-8" data-toggle="tab" href="#tab8" role="tab" aria-controls="tab8" aria-selected="true">ســجل الـقــبـض </a></li>
                    </ul>
                        
                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab-1"> 
                            <form class="col-md-5" action="" method="post" autocomplete="off">
                                <div class="col-md-12 mb-2"><br>
                                    <div class="input-group">
                                        <input type="text" class="form-control text-right" placeholder="إسـم العـامـل" required="" name="name" value="<?php echo $name;?>">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="iHarm iuser"></i></span></div>                                    
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2"><br>
                                    <div class="input-group">
                                        <input type="text" class="form-control text-right" placeholder="عنـوان العـامـل" required="" name="adress" value="<?php echo $adress;?>">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="iHarm ipaper"></i></span></div>                                    
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2"><br>
                                    <div class="input-group">
                                        <input type="text" class="form-control text-right" placeholder="رقـم البـطـاقه" required="" name="id_num" value="<?php echo $id_num;?>">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="iHarm itag"></i></span></div>                                    
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2"><br>
                                    <div class="input-group">
                                        <input type="text" class="form-control text-right" placeholder="رقـم المـوبايل" required="" name="phone" value="<?php echo $phone;?>">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="iHarm iphone"></i></span></div>                                    
                                    </div>
                                </div>
                                <div class="col-md-12 mb-2"><br>
                                    <div class="input-group">
                                        <input type="text" class="form-control text-right" placeholder="الراتـب الثـابت" required="" name="salery" value="<?php echo $salery;?>">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="iHarm ivisa"></i></span></div>                                    
                                    </div>
                                </div><br>                        <br>
                                <button class="btn btn-primary" type="submit" name="edite"> &nbsp; تـعـديل  &nbsp;</button>
                            </form><br><br><br>
                        </div>
                        <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="tab-2"> 
                            <form class="col-md-5" action="" method="post" autocomplete="off"><br>
                                <input type="number" class="form-control text-right" placeholder="المـبـلغ" required="" name="amount"><br>
                                <textarea type="text" class="form-control text-right" placeholder="المـلاحــظـات / سبب الخصم" required="" name="note"></textarea><br><br>
                                <button class="btn btn-primary" type="submit" name="savediscount"> &nbsp; حــفــظ  &nbsp;</button>
                            </form><br><br><br>
                        </div>
                        <div class="tab-pane" id="tab4" role="tabpanel" aria-labelledby="tab-4"> 
                            <form class="col-md-5" action="" method="post" autocomplete="off"><br>
                                <input type="number" class="form-control text-right" placeholder="المـبـلغ" required="" name="amount"><br>
                                <textarea type="text" class="form-control text-right" placeholder="المـلاحــظـات / سبب الإضـافــه الـي المرتب" required="" name="note"></textarea><br><br>
                                <button class="btn btn-primary" type="submit" name="saveincreament"> &nbsp; حــفــظ  &nbsp;</button>
                            </form><br><br><br>
                        </div>
                        <div class="tab-pane" id="tab5" role="tabpanel" aria-labelledby="tab-5"><br>
                            <input type="text" class="form-control text-right col-md-5" placeholder="فلتر / ابحث هنا" id="myInput2"><br>
                            <table class="table table-bordered text-right" width="100%">
                                <thead>
                                    <tr role="row">
                                    <th class="sorting"></th>
                                    <th class="sorting">التـاريخ</th>
                                    <th class="sorting">المـلاحــظـات</th>
                                    <th class="sorting">البيان</th>
                                    <th class="sorting">المـبلـغ</th>
                                    <th class="sorting" width="50px">م</th>
                                    </tr>
                                </thead>
                                <tbody id="myTable2">
                                    <?php

                                    $i = 1;
                                    $query = mysqli_query($db, "SELECT * FROM salery_note WHERE workerid='$workerId'");
                                    while($row = mysqli_fetch_array($query))
                                    {
                                        $id = $row['id'];
                                        $amount = number_format($row['amount']);
                                        $type = $row['type'];
                                        $note = $row['note'];
                                        $date = $row['date'];
                                        $time = $row['time'];
                                        $newi = $i++;

                                        if($type == 0){$status_1 = "<span class='btn btn-danger'>  خصم من المرتب </span>";}
                                        if($type == 1){$status_1 = "<span class='btn btn-success'>  زياده علي المرتب </span>";}

                                        
                                        echo "
                                        <tr role='row' class='odd'>
                                            <td><a href='?delete&data=$id' class='btn btn-danger'>حــذف</a></td>
                                            <td>$date &nbsp;&nbsp; $time</td>
                                            <td>$note</td>
                                            <td>$status_1</td>
                                            <td>$amount</td>
                                            <td>$newi</td>
                                        </tr>
                                        ";
                                    }
                                    ?>  
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="tab6" role="tabpanel" aria-labelledby="tab-6"><br>
                            <input type="text" class="form-control text-right col-md-5" placeholder="فلتر / ابحث هنا" id="myInput3"><br>
                            <table class="table table-bordered text-right" width="100%">
                                <thead>
                                    <tr role="row">
                                    <th class="sorting">الحـاله</th>
                                    <th class="sorting" width='200px'>التـاريخ</th>
                                    </tr>
                                </thead>
                                <tbody id="myTable3">
                                    <?php
                                    $query = mysqli_query($db, "SELECT * FROM recordattendance WHERE workerid='$workerId' Group by date");
                                    while($row = mysqli_fetch_array($query))
                                    {
                                        $date = $row['date'];
                                        $status = $row['status'];
                                        
                                        if($status == 2){$status_ = "<span class='btn btn-success'>  إنصراف كامل </span>";}
                                        if($status == 1){$status_ = "<span class='btn btn-warning'>  إنصراف نصف يوم </span>";}

                                        echo "
                                        <tr role='row' class='odd'>
                                            <td>$status_</td>
                                            <td>$date</td>
                                        </tr>
                                        ";
                                    }
                                    ?>  
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="tab7" role="tabpanel" aria-labelledby="tab-7"><br><br>
                            <h4><?php echo number_format($salery);?> :  الراتب الثابت</h4><br>
                            <h4 class="text-danger">
                            <?php
                                $query = mysqli_query($db, "SELECT * FROM salery_note WHERE workerid='$workerId' and type='0' ");
                                $sum = 0;
                                while($row = mysqli_fetch_array($query)) { $amount = $row['amount']; $sum += $amount;}
                                echo number_format($sum);
                            ?>  
                            :  إجمـالي الخـصم</h4><br>
                            <h4 class="text-success">
                            <?php
                                $query1 = mysqli_query($db, "SELECT * FROM salery_note WHERE workerid='$workerId' and type='1' ");
                                $sum1 = 0;
                                while($row = mysqli_fetch_array($query1)) { $amount1 = $row['amount']; $sum1 += $amount1;}
                                echo number_format($sum1);
                            ?>  
                            :  إجمـالي الإضــافـات</h4><br>
                            <h4 class="text-white bg-dark col-md-5 p-2"><?php $finally_salery = $salery - $sum + $sum1; echo number_format($finally_salery);?> :  الراتب المســتحق / المتبقي</h4><br>
                            <a href="?salery&<?php echo "i=$workerId&s=$salery&d=$sum&n=$sum1&a=$finally_salery&t=قبض عمال - $name";?>" class="btn btn-primary"> اســتـلام القـبــض  </a>
                        <br><br><br>
                        </div>
                        <div class="tab-pane" id="tab8" role="tabpanel" aria-labelledby="tab-8"><br><br>
                            <table class="table table-bordered text-right" width="100%">
                                <thead>
                                    <tr role="row">
                                    <th class="sorting">التـاريخ</th>
                                    <th class="sorting">الراتب المستحق</th>
                                    <th class="sorting">الزياده</th>
                                    <th class="sorting">الخصومات</th>
                                    <th class="sorting">الراتب الثابت</th>
                                    <th class="sorting">الـشـهر</th>
                                    <th class="sorting" width='60px'>م</th>
                                    </tr>
                                </thead>
                                <tbody id="myTable">
                                    <?php
                                    $query = mysqli_query($db, "SELECT * FROM salery_details WHERE workerid='$workerId' ");
                                    $i = 1;
                                    while($row = mysqli_fetch_array($query))
                                    {
                                        $month = date('m', strtotime($row['date']));
                                        $salery = $row['salery'];
                                        $discount = $row['discount'];
                                        $increase = $row['increase'];
                                        $amount = $row['amount'];
                                        $date = $row['date'];
                                        $time = $row['time'];

                                        $loop = $i++;
                                        

                                        echo "
                                        <tr role='row' class='odd'>
                                            <td>$date &nbsp;&nbsp; $time</td>
                                            <td>$amount</td>
                                            <td>$increase</td>
                                            <td>$discount</td>
                                            <td>$salery</td>
                                            <td>$month</td>
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