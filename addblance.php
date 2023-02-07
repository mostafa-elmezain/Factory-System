<?php 
    include'file/C68c7cdaaf1631ad30b9711f148205522ore.php';

    notlogin();
    
    $id = $_GET['id'];

    $row = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM customer WHERE id='$id'"));

    $name = $row['name'];
    $blance = $row['blance'];
    $typerow = $row['type'];

    $output="";

    if(isset($_POST['save'])){
        $blanceinput = $_POST['blanceinput'];

        $newblance = $blance + $blanceinput;

        $query =  mysqli_query($db, "UPDATE customer SET blance = '$newblance' WHERE id = '$id'");
        $note = "سند قبض"; 
        $dach = " ـــ ";
        $zero = "0";
        $query3 = mysqli_query($db, "INSERT INTO customer_history (customer_id, code, note, maden, da2en, blance, date, time) VALUES ('$id','$dach','$note','$zero','$blanceinput','$newblance','$dateNow','$timeNow')");


        // treasury (el5azna) section.. 
        $treasury_row = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM treasury WHERE id='1'"));
        $treasury_amount = $treasury_row['amount'];

        if($typerow == 1){
            $new_treasury_amount = $treasury_amount + $blanceinput;
            $type = "سند قبض لحساب السيد $name";
        }

        if($typerow == 0){
            $new_treasury_amount = $treasury_amount - $blanceinput;
            $type = "سند قبض لحساب السيد $name";
        }
        
        mysqli_query($db, "UPDATE  treasury SET amount='$new_treasury_amount' WHERE id='1'");
        mysqli_query($db, "INSERT INTO  treasury_details (type,amount,date,time) VALUES ('$type','$blanceinput','$dateNow','$timeNow')");


        if($query3){$output ="<h4 class='text-success'>تم إضافه الرصيد بنجاح</h4><br>";}
        else{$output ="<h4 class='text-danger'>فشل </h4><br>"; echo mysqli_error($db);}
    }


?>

<!Doctype HTML>
<html>
    <head> <?php echo $head;?> </head>
    <body>
        <div class="wrapper">
            <div id="content">
                <center><br>
                    <h2>تسديد - إضافه رصيد</h2>
                    <h3>الي حساب السيد / <?php echo $name;?></h3><br><br>

                    <?php echo $output;?>

                    <form class="col-md-12" action="" method="post" autocomplete="off"><br>
                        <input type="number" class="form-control text-right col-md-3 mr-4" placeholder=" قيمه الرصيد " required="" name="blanceinput"><br><br>
                        <button class="btn btn-primary mr-4" type="submit" name="save"> &nbsp;  حفـظ الرصيد &nbsp;</button>
                    </form><br><br><br>
                    <?php echo $CopyRight;?>
                </center>
            </div>
            <?php echo $sideBar . $fixedDiv . $bottom_script;?>
        </div>
    </body>
</html>