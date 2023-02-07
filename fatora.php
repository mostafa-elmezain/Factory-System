<?php 
    include'file/C68c7cdaaf1631ad30b9711f148205522ore.php';

    notlogin();


    $queryText = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM fatora ORDER BY id DESC"));
    $id = $queryText['id'];
    $codeText = $id + 1 ;


    $type = $_GET['type'];
    if($type == 1){ $textType = "مبيعات"; $textMan = "العميل"; }
    if($type == 0){ $textType = "مشتريات"; $textMan = "المورد"; }


?>
<!Doctype HTML>
<html>
    <head> 
        <?php echo $head;?>
        <script>
            $(document).ready(function(){
                $("#select2").change(function(){
                    var selectedCountry = $(this).children("option:selected").text();
                    $("#customer").text(selectedCountry);
                });
            });
        </script>
    </head>
    <body>
        <div class="wrapper">
            <div id="content" class="mainPrint">
                <center><br>
                    <h1 class="justPrint">الايـــمــــــان بـــــاك</h1>
                    <h3 class="justPrint">فاتـوره <?php echo $textType;?></h3>
                    <h4 class="justPrint"><?php echo $codeText;?> &nbsp; كود الفاتورة</h4>
                    <hr>
                    <div class="printHide">
                        <h3>بيانات الفاتوره</h3>
                        <div class="text-right">
                            <select id="select2">
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
                        </div><br>
                        <form autocomplete="off" class="col-md-12 row float-right">
                            <button class="btn btn-primary mr-4 add-row" type="button"> &nbsp;  إضــافه &nbsp;</button>
                            <input required type="number" class="form-control text-right col-md-3 mr-4" id="counts" placeholder="الكميه">
                            <input required type="number" class="form-control text-right col-md-3 mr-4" id="price" placeholder="سعر الوحده">
                            <input required type="text" class="form-control text-right col-md-3 mr-4" id="name" placeholder="اســم الصنــف">
                        </form>
                        <br><br><br>
                    </div>

                    <div class="text-right">
                        <h4 class="pr-5 justPrint"><?php echo $dateNow;?> &nbsp;&nbsp; <?php echo $timeNow;?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; التاريخ</h4>
                        <hr class="justPrint">
                        <h4 class="pr-5 justPrint"><span id="customer"></span> &nbsp;&nbsp;   اسم  <?php echo $textMan;?>  </h4>
                        <hr class="justPrint">
                    </div>
                    
                    <table id="table1" class="table table-bordered text-right" width="100%">
                        <thead>
                            <tr >
                                <th class="printHide"></th>
                                <th>القيمه</th>
                                <th>الكميه</th>
                                <th>سعر الوحده</th>
                                <th>البيان</th>
                                <th>م</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <table class="table-bordered text-left" width="100%" style="margin-top: -17px;">
                        <tbody>
                            <tr><td  style="padding-left:100px"><h5 class=""><span id="total"></span>  &nbsp; الإجمـالي</h5></td></tr>
                            <tr><td  style="padding-left:100px"><h5 class="justPrint"> ض . القيمه المضافه</h5></td></tr>
                            <tr><td  style="padding-left:100px"><h5 class="justPrint">الاجمالي بعد ض . القيمه المضافه</h5></td></tr>
                        </tbody>
                    </table>

                    <br>
                    <table class="table table-bordered text-center justPrint-t" width="100%">
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
                    <button type="button" class="delete-row printHide btn btn-danger">حــذف الصف</button>
                    <button type="button" id="butsave" class="printHide btn btn-success">حــفـظ الفاتوره</button>
                    <button type="button" onclick="window.print()" class="printHide btn btn-primary">طبـاعه </button>

                    
                </center>
            </div>
            <?php echo $sideBar . $fixedDiv . $bottom_script;?>
        </div>

        <script>

            calc_total();    

            $(document).ready(function(){
                var id = 1;   
                $(".add-row").click(function(){ 
                    var newid = id++; 
                    var name = $("#name").val();
                    var price = $("#price").val();
                    var counts = $("#counts").val();
                    var total = price * counts;
                    var markup = 
                    "<tr id="+newid+">\n\
                        <td class='printHide'><input type='checkbox' name='record'></td>\n\
                        <td class='total"+newid+" total'>" + total + "</td>\n\
                        <td class='counts"+newid+"'>" + counts + "</td>\n\
                        <td class='price"+newid+"'>" + price + "</td>\n\
                        <td class='name"+newid+"'>" + name + "</td>\n\
                        <td>" + newid + "</td>\n\
                    </tr>";
                    $("#table1 tbody").append(markup);
                    $("#name").val("");
                    $("#price").val("");
                    $("#counts").val("");
                    calc_total();
                });

        
                // Find and remove selected table rows
                $(".delete-row").click(function(){
                    $("table tbody").find('input[name="record"]').each(function(){
                        if($(this).is(":checked")){
                            $(this).parents("tr").remove();
                        }
                    });
                    calc_total();
                });
        
            });  
            
            function calc_total(){
                var sum = 0;
                $(".total").each(function(){sum += parseFloat($(this).text());});
                $('#total').text(sum);
                
            }  

            // Save  FatoRa
            $("#butsave").click(function() {
                var lastRowId = $('#table1 tr:last').attr("id"); /*finds id of the last row inside table*/
                var name = new Array();
                var price = new Array();
                var count = new Array();
                var total = new Array();
                
                for ( var i = 1; i <= lastRowId; i++) {
                    name.push($("#"+i+" .name"+i).html()); /*pushing all the emails listed in the table*/
                    price.push($("#"+i+" .price"+i).html()); 
                    count.push($("#"+i+" .counts"+i).html()); 
                    total.push($("#"+i+" .total"+i).html()); 
                }
                var SendName = JSON.stringify(name);
                var SendPrice = JSON.stringify(price);
                var SendCount = JSON.stringify(count);
                var SendTotal = JSON.stringify(total);

                var CustomerId = $("#select2").val();
                var FatoraCode = '<?php echo $codeText;?>';
                var FatoraType = '<?php echo $_GET['type'];?>';

                var sum = 0;
                $(".total").each(function(){sum += parseFloat($(this).text());});
                
                $.ajax({
                    url: "fatoraSave-ajax.php",
                    type: "post",
                    data: {name : SendName, price : SendPrice, count : SendCount, total : SendTotal, id : CustomerId, code : FatoraCode, alltotal : sum, type : FatoraType},
                    success : function(data){
                        window.location.reload();
                    }
                });
        
            });
    </script>
    </body>
</html>