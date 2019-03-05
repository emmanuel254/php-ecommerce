<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';

 $id = $_POST['id'];
 $id = (int)$id;
 
 $image = $db->query("SELECT * FROM accesories WHERE id = '$id'");
 $result = mysqli_fetch_assoc($image)
?>

<!--details modalls-->
<?php ob_start(); ?>

<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
<div class="modal-dialog modal-sm">
	<div class="modal-content">
		<div class="modal-header">
			<button class="close" type="button" onclick="closeModal()" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<h4 class="modal-title text-center"><?=$result['title'];?></h4>
        <div class="modal-body">
	       <div class="container-fluid">
		     <div class="row">	
                <img src="<?=$result['image'];?>" alt="<?=$result['title'];?>" width="250px;" height="300px">
		    </div>
	</div>
</div>
</div>
</div>
</div>
<script>

	function closeModal(){
     jQuery('#details-modal').modal('hide');
     setTimeout(function(){
      
      jQuery('#details-modal').remove();
      jQuery('.modal-backdrop').remove();
     },500);
	}
</script>

<?php echo ob_get_clean(); ?>