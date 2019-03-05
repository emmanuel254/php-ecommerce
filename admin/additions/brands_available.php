
    <h2 class="text-center">Brands Available</h2>
    <table class="table table-bordered table-striped table-condensed">
      <thead>
      <th style="font-size: 34px;">#</th>
      <th style="font-size: 34px;">Brands</th>
      <th></th>
      </thead>
      <tbody>
        <?php
                   $brand = $db->query("SELECT * FROM accesoriestype WHERE parent = 0 ORDER BY brand_name");
                   $i = 1;
        ?>
        <tr>
        <?php while($brandR = mysqli_fetch_assoc($brand)):?>
        <tr <?=(($i%2 == 0)?' style="background-color:lime;"':' style="background-color:aqua;"');?>>
          <td style="font-size: 20px;"><?=$i;?></td>
          <td style="font-size: 20px;"><?=$brandR['brand_name'];?></td>
          <td width="100px">
      <a href="accessories.php?delete_brand&id=<?=$brandR['id'];?>" class="btn btn-xs pull-right"><span class="glyphicon glyphicon-remove"></span></a>
        <a href="accessories.php?edit_brand&id=<?=$brandR['id'];?>" class="btn btn-xs pull-right"><span class="glyphicon glyphicon-pencil"></span></a>
          </td>
        </tr>
        <?php $i++;?>
          <?php endwhile;?>
      </tbody>
    </table>
    <a class="btn btn-xs btn-primary" href="accessories.php?brand=1">add brand</a>
<!-- Creates a form for adding brand -->
  <?php
       //edit brand
      if (isset($_GET['edit_brand'])) {
        $id = (int)$_GET['id'];
        //echo($id);
        $query = $db->query("SELECT * FROM accesoriestype WHERE id = '{$id}'");
        $brands = mysqli_fetch_assoc($query);
        $brand_value = $brands['brand_name'];
        
      }

      if (isset($_GET['delete_brand'])) {
        $delete_id = (int)$_GET['id'];
        $delete_id = sanitize($delete_id);
      //echo($delete_id);
        $Q = $db->query("SELECT * FROM accesoriestype WHERE id = '$delete_id'");
        $category = mysqli_fetch_assoc($Q);
        if ($category['parent'] == 0) {
       $db->query("DELETE FROM accesoriestype WHERE parent = '$delete_id'");
     }
        $db->query("DELETE FROM accesoriestype WHERE id = '$delete_id'");

        ?><script>window.location = 'http://localhost/boutique/admin/accessories.php';</script>
          <?php
      }

       if (isset($_POST['add_brand'])) {
      $brand = sanitize($_POST['brand']);
     // echo($brand);
         if ($brand == '') {
          $errors[] = 'First enter a brand name';
         }
         $sql = "SELECT * FROM accesoriestype WHERE brand_name = '{$brand}'";
         $result = $db->query($sql);
         $count = mysqli_num_rows($result);
         if ($count > 0) {
          $errors[] = $brand.' brand already exist';
         }
         if (!empty($errors)) {
          echo display_errors($errors);
         }else{
          //add brand to database
            $sql = ("INSERT INTO accesoriestype (brand_name,parent) VALUES ('$brand',0)") or die(mysqli_error($db));
            //edit brand in database
           if (isset($_GET['edit_brand'])) {
               $sql = ("UPDATE accesoriestype SET brand_name = '$brand',parent = 0 WHERE id = '$id'");
           }
            $db->query($sql);
          
          ?><script>
            window.location = 'http://localhost/boutique/admin/accessories.php';
          </script>
          <?php
         }
       }
  ?>
  <?php if(isset($_GET['brand']) || isset($_GET['edit_brand'])):?>
    <form class="form-inline pull-right" method="POST" action="accessories.php?<?=((isset($_GET['edit_brand']))?'edit_brand&id='.$id:'brand=1')?>">
    <?php
          if (isset($_GET['brand'])) {
            $brand_value = '';
          }
          if (isset($_GET['edit_brand'])) {
            $brand_value = $brands['brand_name'];
          }

    ?>
      <input type="text" name="brand" class="form-control" value="<?=$brand_value;?>">
      <a href="accessories.php" class="btn btn-warning">Cancel</a>
      <input type="submit" name="add_brand" value="<?=((isset($_GET['edit_brand']))?'Edit ':'Add ')?>" class="btn btn-success">
    </form>
   <?php endif;?>
<!-- End of form -->