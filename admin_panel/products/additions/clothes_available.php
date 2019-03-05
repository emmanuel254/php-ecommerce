
    <h2 class="text-center">CATEGORY</h2>
    <table class="table table-bordered table-striped table-condensed">
      <thead>
      <th style="font-size: 34px;">#</th>
      <th style="font-size: 34px;">Categories</th>
      <th></th>
      </thead>
      <tbody>
        <?php
             $clothe = $db->query("
              SELECT * FROM accesoriestype WHERE parent = 0 AND branch = 44 ORDER BY brand_name");
             $i = 1;
        ?>
        <tr>
        <?php while($clotheR = mysqli_fetch_assoc($clothe)):?>
        <tr style="background-color: palevioletred;">
          <td style="font-size: 20px;"><?=$i;?></td>
          <td style="font-size: 20px;"><?=$clotheR['brand_name'];?></td>
          <td width="100px">
         <a href="clothes.php?delete_clothe&id=<?=$clotheR['id'];?>" class="btn btn-xs pull-right"><span class="glyphicon glyphicon-remove"></span></a>
         <a href="clothes.php?edit_clothe&id=<?=$clotheR['id'];?>" class="btn btn-xs pull-right"><span class="glyphicon glyphicon-pencil"></span></a>
          </td>
        </tr>
        <?php $i++;?>
          <?php endwhile;?>
      </tbody>
    </table>
    <a class="btn btn-xs btn-primary" href="clothes.php?clothe=1">add clothe</a>
<!-- Creates a form for adding brand -->
  <?php
       //edit brand
      if (isset($_GET['edit_clothe'])) {
        $id = (int)$_GET['id'];
        //echo($id);
        $query = $db->query("SELECT * FROM accesoriestype WHERE id = '{$id}'");
        $clothes = mysqli_fetch_assoc($query);
        $clothe_value = $clothes['brand_name'];
        
      }

      if (isset($_GET['delete_clothe'])) {
        $delete_id = (int)$_GET['id'];
        $delete_id = sanitize($delete_id);
      //echo($delete_id);
        $Q = $db->query("SELECT * FROM accesoriestype WHERE id = '$delete_id'");
        $category = mysqli_fetch_assoc($Q);
        if ($category['parent'] == 0) {
       $db->query("DELETE FROM accesoriestype WHERE parent = '$delete_id'");
     }
        $db->query("DELETE FROM accesoriestype WHERE id = '$delete_id'");

        ?><script>window.location = 'http://localhost/boutique/admin_panel/products/clothes.php';</script>
          <?php
      }

       if (isset($_POST['add_clothe'])) {
      $clothe = sanitize($_POST['clothe']);
    // echo($clothe);
         if ($clothe == '') {
          $errors[] = 'First enter a clothe brand name';
         }
         $sql = "SELECT * FROM accesoriestype WHERE brand_name = '{$clothe}'";
         $result = $db->query($sql);
         $count = mysqli_num_rows($result);
         if ($count > 0) {
          $errors[] = $clothe.' clothe brand already exist';
         }
         if (!empty($errors)) {
          echo display_errors($errors);
         }else{
          echo($clothe);
          //add clothe to database
            $sql = ("INSERT INTO accesoriestype (brand_name,parent,branch) VALUES ('$clothe',0,44)")
             or die(mysqli_error($db));
            //edit clothe in database
           if (isset($_GET['edit_clothe'])) {
               $sql = ("UPDATE accesoriestype SET brand_name = '$clothe',parent = 0 WHERE id = '$id'");
           }
            $db->query($sql);
          
          ?><script>
            window.location = 'http://localhost/boutique/admin_panel/products/clothes.php';
          </script>
          <?php
         }
       }
  ?>
  <?php if(isset($_GET['clothe']) || isset($_GET['edit_clothe'])):?>
    <form class="form-inline pull-right" method="POST" action="clothes.php?<?=((isset($_GET['edit_clothe']))?'edit_clothe&id='.$id:'clothe=1')?>">
    <?php
          if (isset($_GET['clothe'])) {
            $clothe_value = '';
          }
          if (isset($_GET['edit_clothe'])) {
            $clothe_value = $clothes['brand_name'];
          }

    ?>
      <input type="text" name="clothe" class="form-control" value="<?=$clothe_value;?>">
      <a href="clothes.php" style="margin: 2px;" class="btn btn-warning">Cancel</a>
      <input type="submit" name="add_clothe" value="<?=((isset($_GET['edit_clothe']))?'Edit ':'Add ')?>" class="btn btn-success">
    </form>
   <?php endif;?>
<!-- End of form -->