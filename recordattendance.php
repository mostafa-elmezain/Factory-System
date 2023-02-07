<?php 
    include'file/C68c7cdaaf1631ad30b9711f148205522ore.php';

    notlogin();

    $output = "";


    if(isset($_POST['saveIn']) && !empty($_POST['record'])){$output ="<h4 class='text-success'>نجاح , تم  تـسجيل الحضور</h4><br>";}
     

    if(isset($_POST['saveall'])&& !empty($_POST['record'])){
      $record = $_POST['record']; 
   
      for($i=0;$i<count($record);$i++){
        $record_ = $record[$i];
        $query = mysqli_query($db,"insert into recordattendance (workerid,date,status) values ('$record_','$dateNow',2)");
      }
      if($query){$output ="<h4 class='text-success'>نجاح , تم  تـسجيل إنصراف كامل</h4><br>";}
      else{$output ="<h4 class='text-danger'>فشل , لم يتم  تـسجيل إنصراف كامل</h4><br>";}
    }

    if(isset($_POST['savehalf'])&& !empty($_POST['record'])){
      $record = $_POST['record']; 
   
      for($i=0;$i<count($record);$i++){
        $record_ = $record[$i];
        $query = mysqli_query($db,"insert into recordattendance (workerid,date,status) values ('$record_','$dateNow',1)");
      }
      if($query){$output ="<h4 class='text-success'>نجاح , تم  تـسجيل إنصراف نصف يوم</h4><br>";}
      else{$output ="<h4 class='text-danger'>فشل , لم يتم  تـسجيل إنصراف نصف يوم</h4><br>";}
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
 
                  <form method='post' action="">
                    <label class="btn btn-secondary float-right mr-4 mb-3" for="Selectall">تـحديـد الـكـل</label>
                    <input type="checkbox" onClick="toggle(this)" id="Selectall" class="d-none">
                    <button type="submit" name="saveIn" class="btn btn-primary float-right mr-4 mb-3"> تـسجيـل الحـضور</button>
                    <button type="submit" name="saveall" class="btn btn-success float-right mr-4 mb-3">  إنصراف كامل</button>
                    <button type="submit" name="savehalf" class="btn btn-warning float-right mr-4 mb-3">  إنصراف نصف يوم</button>
                    <br><br><br><br>
                    <table class="table table-bordered text-right" width="30%">
                      <thead>
                        <tr role="row">
                          <th class="sorting">اسم العـامـل</th>
                          <th class="sorting" width="80px">م</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $query = mysqli_query($db, "SELECT * FROM worker");
                          while($row = mysqli_fetch_array($query))
                          {
                            $id = $row['id'];
                            $name = $row['name'];
                            echo "
                              <tr role='row' class='odd'>
                                <td>
                                  <input style='height: 29px;width: 20px;' type='checkbox' name='record[]' id='recordInput$id' value='$id'>
                                  <label for='recordInput$id'>$name </label>
                                </td>
                                <td>$id</td>
                              </tr>
                            ";
                          }
                        ?>  
                      </tbody>
                    </table>
                  </form>

                    <br><?php echo $CopyRight;?>
                </center>
            </div>
            <?php echo $sideBar . $fixedDiv . $bottom_script;?>
        </div>
    </body>
</html>