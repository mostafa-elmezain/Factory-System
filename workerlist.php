<?php 
    include'file/C68c7cdaaf1631ad30b9711f148205522ore.php';

    notlogin();
?>

<!Doctype HTML>
<html>
    <head> <?php echo $head;?> </head>
    <body>
        <div class="wrapper">
            <div id="content">
                <center><br>
                    <table class="table table-bordered text-right" width="100%">
                      <thead>
                        <tr role="row">
                          <th class="sorting">التـحكم</th>
                          <th class="sorting">الراتـب الثـابت</th>
                          <th class="sorting">رقـم البطاقه</th>
                          <th class="sorting">رقـم الـموبايل</th>
                          <th class="sorting">العـنـوان</th>
                          <th class="sorting">اسم العـامـل</th>
                          <th class="sorting">م</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $query = mysqli_query($db, "SELECT * FROM worker");
                          while($row = mysqli_fetch_array($query))
                          {
                            $id = $row['id'];
                            $name = $row['name'];
                            $adress = $row['adress'];
                            $phone = $row['phone'];
                            $id_num = $row['id_num'];
                            $salery = number_format($row['salery']);

                            echo "
                              <tr role='row' class='odd'>
                                <td><a href='control?i=$id' class='btn btn-primary'>إداره</a></td>
                                <td>$salery</td>
                                <td>$id_num</td>
                                <td>$phone</td>
                                <td>$adress</td>
                                <td>$name</td>
                                <td>$id</td>
                              </tr>
                            ";
                          }
                        ?>  
                      </tbody>
                    </table>
                    <br><?php echo $CopyRight;?>
                  </form>
                </center>
            </div>
            <?php echo $sideBar . $fixedDiv . $bottom_script;?>
        </div>
    </body>
</html>