<?php 
    include'file/C68c7cdaaf1631ad30b9711f148205522ore.php';

    $itemIdArr = json_decode($_POST["itemId"]);
    $CountArr = json_decode($_POST["count"]);
    $TotalArr = json_decode($_POST["total"]);

    $FatoraCodedArr = $_POST["code"];
    $AllTotaldArr = $_POST["alltotal"];

    $CustomerIdArr = $_POST['cusId'];

    $zero = 0;

    $rowfatore = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM fatora  WHERE code='$FatoraCodedArr'"));
    $oldtotal = $rowfatore['total_money'];
    $typeArr = $rowfatore["type"];

    $mortag3 = $oldtotal - $AllTotaldArr;

    // UPDATE fatora in table..
    $query1 = mysqli_query($db, "UPDATE fatora SET total_money='$AllTotaldArr' WHERE code='$FatoraCodedArr'");

    for ($i = 0; $i < count($itemIdArr); $i++) {
        if(($itemIdArr[$i] != "")){
            $query2 = mysqli_query($db, "UPDATE fatora_data SET item_count='$CountArr[$i]', item_cost='$TotalArr[$i]' WHERE id='$itemIdArr[$i]' and  fatore_code='$FatoraCodedArr'");
        }
    }





    // insert in customer History
    $note = "$FatoraCodedArr مرتجع علي فاتوره نقديه - كود الفاتوره ";
    $rowBlance = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM customer WHERE id = '$CustomerIdArr'"));
    $userBlance = $rowBlance['blance'];

    $newblance = $userBlance + $mortag3;
                                                            
    $query3 = mysqli_query($db, "INSERT INTO customer_history (customer_id, code, note, maden, da2en, blance, date, time) VALUES ('$CustomerIdArr','$FatoraCodedArr','$note','$zero','$mortag3','$newblance','$dateNow','$timeNow')");
    $queryx = mysqli_query($db, "UPDATE customer set blance = '$newblance' Where id = '$CustomerIdArr'");


    // treasury (el5azna) section.. 
   /* $treasury_row = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM treasury WHERE id='1'"));
    $treasury_amount = $treasury_row['amount'];

    if($typeArr == 1){
        $new_treasury_amount = $treasury_amount - $mortag3;
        $type = "$FatoraCodedArr : مرتجع علي فاتوره مبيعات بكود";
    }

    if($typeArr == 0){
        $new_treasury_amount = $treasury_amount + $mortag3;
        $type = "$FatoraCodedArr : مرتجع علي فاتوره مشتريات بكود";
    }
    
    mysqli_query($db, "UPDATE  treasury SET amount='$new_treasury_amount' WHERE id='1'");
    mysqli_query($db, "INSERT INTO  treasury_details (type,amount,date,time) VALUES ('$type','$mortag3','$dateNow','$timeNow')");
*/
   


?>