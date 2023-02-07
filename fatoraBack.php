<?php 
    include'file/C68c7cdaaf1631ad30b9711f148205522ore.php';

    notlogin();

    $type = $_GET['type'];

    if(isset($_POST['searchInput'])){
        $fatoraCode = $_POST['codeInput'];


        $query1 =  mysqli_query($db, "SELECT * FROM fatora WHERE code='$fatoraCode' and type='$type'");
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
                <img src='/file/image/i68c7cdaaf1631ad30b9711f148205522con.png' class='printImage'>
                <h1>الايـــمــــــان بـــــاك</h1>
                <h3>فاتـوره $textType</h3>
                <hr>
                <div class='d-inline-flex'>
                    <h4 class='pr-5'>$time : الوقت</h4>
                    <h4 class='pr-5'>$date : التاريخ</h4>
                    <h4 class='pr-5'>  اسم  $textMan : $CustomerName</h4>
                    <h4 class='pr-5'>$fatoraCode : كود</h4>
                </div>
                <table id='table1' class='table table-bordered text-right' width='100%'>
                    <thead>
                        <tr>
                            <th>الإجمـالي</th>
                            <th>العـدد</th>
                            <th>السـعر</th>
                            <th>إســم الصنـف</th>
                        </tr>
                    </thead>
                    <tbody>";


                    $loopId = 1;
                    while($DataRow = mysqli_fetch_array($query2))
                    {
                        $id = $DataRow['id'];
                        $item_name = $DataRow['item_name'];
                        $item_price = $DataRow['item_price'];
                        $item_count = $DataRow['item_count'];
                        $item_cost = $DataRow['item_cost'];
                        
                        $newid = $loopId++;
                        $OutPut.= "
                            <tr id='$newid'>
                                <td class='itemid$newid d-none'>$id</td>
                                <td class='total$id total$newid total'>$item_cost</td>
                                <td class='counts$newid'><input type='text' class='countInput$newid' id='counts$id' value='$item_count' onkeyup='calc_total($id)'></td>
                                <td class='price$id price$newid'>$item_price</td>
                                <td class='name$newid'>$item_name</td>
                            </tr>
                        ";
                    }

                    
            $OutPut.="        
                    </tbody>
                </table>
                <br>
                <div class='d-inline-flex '>
                    <h4 class=''><span id='total'>$TotalMoney</span>  : الإجمـالي</h4>
                </div>
                <br><br>
                <button type='button' id='butsave' class='btn btn-success'>حفــظ الفاتوره</button>
                <br><br>
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
                    <form class="row float-right printHide" action="" method="post" autocomplete="off"><br>
                        <button class="btn btn-primary mr-4" type="submit" name="searchInput"> &nbsp;  بحــث &nbsp;</button>
                        <input type="text" class="form-control text-right col-md-6" placeholder="كــود الفاتوره" required="" name="codeInput"><br>                                
                    </form><br><br><br>

                    <?php echo $OutPut .  $CopyRight;?>
                </center>
            </div>
            <?php echo $sideBar . $fixedDiv . $bottom_script;?>
        </div>

        <script>

            calc_total();


            function calc_total(id){
                var price = $(".price"+id).text();
                var count = $("#counts"+id).val();
                var newTotal = price * count;
                $('.total'+id).text(newTotal);
                var sum = 0;
                $(".total").each(function(){sum += parseFloat($(this).text());});
                $('#total').text(sum);
            }  


            // Save  FatoRa
            $("#butsave").click(function() {
                var lastRowId = $('#table1 tr:last').attr("id"); /*finds id of the last row inside table*/
                var itemId = new Array();
                var count = new Array();
                var total = new Array();
                
                for ( var i = 1; i <= lastRowId; i++) {
                    itemId.push($("#"+i+" .itemid"+i).html()); /*pushing all the emails listed in the table*/
                    count.push($("#"+i+" .countInput"+i).val()); 
                    total.push($("#"+i+" .total"+i).html()); 
                }
                var SenditemId = JSON.stringify(itemId);
                var SendCount = JSON.stringify(count);
                var SendTotal = JSON.stringify(total);

                var FatoraCode = '<?php echo $fatoraCode;?>';

                var sum = 0;
                $(".total").each(function(){sum += parseFloat($(this).text());});


                var cusId = '<?php echo $CustomerId;?>';

                
                $.ajax({
                    url: "fatoraUpdate-ajax.php",
                    type: "post",
                    data: {itemId : SenditemId, count : SendCount, total : SendTotal, code : FatoraCode, alltotal : sum, cusId : cusId},
                    success : function(data){
                        window.location.reload();
                    }
                });
        
            });
            
            
            
    </script>
    </body>
</html>