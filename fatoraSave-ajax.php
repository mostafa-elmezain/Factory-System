<?php 
    include'file/C68c7cdaaf1631ad30b9711f148205522ore.php';

    $NameArr = json_decode($_POST["name"]);
    $PriceArr = json_decode($_POST["price"]);
    $CountArr = json_decode($_POST["count"]);
    $TotalArr = json_decode($_POST["total"]);

    $CustomerIdArr = $_POST["id"];
    $FatoraCodedArr = $_POST["code"];
    $typeArr = $_POST["type"];

    $zero = 0;

    $AllTotaldArr = $_POST["alltotal"];

    // insert fatora in table..
    $query1 = mysqli_query($db, "INSERT INTO fatora (code, 3ameel_id, total_money, date, time, type) VALUES ('$FatoraCodedArr','$CustomerIdArr','$AllTotaldArr','$dateNow','$timeNow','$typeArr')");       

    for ($i = 0; $i < count($NameArr); $i++) {
        if(($NameArr[$i] != "")){
            $query2 = mysqli_query($db, "INSERT INTO fatora_data (fatore_code, 3ameel_id, item_name, item_price, item_count, item_cost) VALUES ('$FatoraCodedArr','$CustomerIdArr','$NameArr[$i]','$PriceArr[$i]','$CountArr[$i]','$TotalArr[$i]')");       
        }
    }

    // insert in customer History
    $note = "$FatoraCodedArr  فاتوره نقديه - كود الفاتوره";
    $rowBlance = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM customer WHERE id = '$CustomerIdArr'"));
    $userBlance = $rowBlance['blance'];

    $newblance = $userBlance - $AllTotaldArr;
                                                            
    $query3 = mysqli_query($db, "INSERT INTO customer_history (customer_id, code, note, maden, da2en, blance, date, time) VALUES ('$CustomerIdArr','$FatoraCodedArr','$note','$AllTotaldArr','$zero','$newblance','$dateNow','$timeNow')");
    $queryx = mysqli_query($db, "UPDATE customer set blance = '$newblance' Where id = '$CustomerIdArr'");


    // treasury (el5azna) section.. 
    /*$treasury_row = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM treasury WHERE id='1'"));
    $treasury_amount = $treasury_row['amount'];

    if($typeArr == 1){
        $new_treasury_amount = $treasury_amount + $AllTotaldArr;
        $type = "$FatoraCodedArr : فاتوره مبيعات بكود";
    }

    if($typeArr == 0){
        $new_treasury_amount = $treasury_amount - $AllTotaldArr;
        $type = "$FatoraCodedArr : فاتوره مشتريات بكود";
    }
    
    mysqli_query($db, "UPDATE  treasury SET amount='$new_treasury_amount' WHERE id='1'");
    mysqli_query($db, "INSERT INTO  treasury_details (type,amount,date,time) VALUES ('$type','$AllTotaldArr','$dateNow','$timeNow')");
*/
   


?>