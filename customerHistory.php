<?php 
    include'file/C68c7cdaaf1631ad30b9711f148205522ore.php';

    notlogin();

    $type = $_GET['type'];

    if($type == 1){$textMan = "العميل"; }
    elseif($type == 0){$textMan = "المورد"; }


    $OutPut = "";
    
    if(isset($_POST['customer'])){
        $customerId = $_POST['customer'];

        $query =  mysqli_query($db, "SELECT * FROM customer WHERE id='$customerId'");
        $customerRow = mysqli_fetch_array($query);
        $name = $customerRow['name'];

        if(isset($_POST['viewTotal'])){
            $query1 =  mysqli_query($db, "SELECT * FROM customer_history WHERE customer_id='$customerId'");
        }
        if(isset($_POST['viewDate'])){
            $start = $_POST['start'];
            $end = $_POST['end'];
            $query1 =  mysqli_query($db, "SELECT * FROM customer_history WHERE customer_id='$customerId' and date>='$start' and date<='$end'");
        }

        if (mysqli_num_rows($query1) == 0) {
            $OutPut = "<h2>لا يوجد تعاملات لهذا $textMan</h2>";
        }
        else{
            $OutPut = "
            <img src='/file/image/i68c7cdaaf1631ad30b9711f148205522con.png' class='printImage'>
            <h1 class='justPrint'>الايـــمــــــان بـــــاك</h1>
            <h3 class='justPrint'>كـشف حساب السيـد / $name</h3>
            <h5 class='justPrint'>التاريخ &nbsp;  $dateNow</h5><br>
            <table id='table1' class='table table-bordered text-right' width='100%'>
                <thead>
                    <tr>
                        <th>التاريخ</th>
                        <th>الرصيـد</th>
                        <th>دائن</th>
                        <th>مدين</th>
                        <th>بيان الحركه</th>
                        <th>كود الفاتوره</th>
                    </tr>
                </thead>
                <tbody>";
                while($DataRow = mysqli_fetch_array($query1))
                {
                    $time = $DataRow['time'];
                    $date = $DataRow['date'];
                    $blance = number_format($DataRow['blance']);
                    $da2en = number_format($DataRow['da2en']);
                    $maden = number_format($DataRow['maden']);
                    $note = $DataRow['note'];
                    $code = $DataRow['code'];

                    $OutPut.= "
                    <tr>
                        <td>$date &nbsp;&nbsp; $time</td>
                        <td>$blance</td>
                        <td>$da2en</td>
                        <td>$maden</td>
                        <td>$note</td>
                        <td>$code</td>
                    </tr>
                    ";
                }
            $OutPut.="        
                </tbody>
            </table>
            ";
        }
    }
?>

<!Doctype HTML>
<html>
    <head> <?php echo $head;?> </head>
    <body>
        <div class="wrapper">
            <div id="content" class="mainPrint">
                <center><br>

                    <div class="text-right printHide">
                        <form action="" method="post" autocomplete="off">
                        <button type="button" onclick="window.print()" class="printHide btn btn-primary mr-4">طبـاعه الكشف</button>
                            <input type='submit' class='printHide btn btn-primary mr-4' value='عرض بالتاريخ' name='viewDate'>

                            <input class='form-control-user' data-date-format='yyyy/mm/dd' id='datepicker1' autocomplete="off" name='end'>
                            <span class="pr-4">: الي</span>
                            <input class='form-control-user' data-date-format='yyyy/mm/dd' id='datepicker' autocomplete="off" name='start'>
                            <span class="pr-4">: اختـار التـاريخ مـن</span>


                            <input type='submit' class='printHide btn btn-primary' value='عرض بالكامل' name='viewTotal'>
                            <select id="select2" name="customer" required>
                                <option selected disabled>اختار اسم <?php echo $textMan;?></option>
                                <?php
                                    $queryC = mysqli_query($db, "SELECT * FROM customer WHERE type='$type'");
                                    while($rowC = mysqli_fetch_array($queryC))
                                    {
                                        $id = $rowC['id'];
                                        $name = $rowC['name'];

                                        echo "<option value='$id'>$name</option>";
                                    }
                                ?>
                            </select>
                            <b>&nbsp; : &nbsp;اختار  <?php echo $textMan;?></b>
                        </form>
                    </div><br>

                    <?php echo $OutPut . $CopyRight;?>
                </center>
            </div>
            <?php echo $sideBar . $fixedDiv . $bottom_script;?>
        </div>

        <script type="text/javascript">
            $('#datepicker').datepicker({
                weekStart: 1,
                daysOfWeekHighlighted: "6,0",
                autoclose: true,
                todayHighlight: true,
            });
            $('#datepicker').datepicker("setDate", new Date());

            $('#datepicker1').datepicker({
                weekStart: 1,
                daysOfWeekHighlighted: "6,0",
                autoclose: true,
                todayHighlight: true,
            });
            $('#datepicker1').datepicker("setDate", new Date());
        </script>
    </body>
</html>