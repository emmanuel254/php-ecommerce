
<?php 
  require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
  include 'accessories/heading/header.php'; 
  $sql = $db->query("SELECT * FROM accesoriestype WHERE parent = 0 AND branch = 43;");

?>
	<body>
		<div class="container" >
			<ul id="gn-menu" class="gn-menu-main" style="background-color: lime">
				<li class="gn-trigger">
					<a class="gn-icon gn-icon-menu"><span>Menu</span></a>
					<nav class="gn-menu-wrapper nave" >
						<div class="gn-scroller">
							<ul class="gn-menu">
								<li class="gn-search-item">
									<input placeholder="Search" type="search" class="gn-search">
									<a class="gn-icon gn-icon-search"><span>Search</span></a>
								</li>
								<li>
									<a class="gn-icon gn-icon-download">HOME</a>
								</li>
								<?php while($parent = mysqli_fetch_assoc($sql)):
                                  $parent_id = $parent['id'];
						         $sql2 = "SELECT * FROM accesoriestype WHERE parent = '$parent_id'";
						         $cquery = $db->query($sql2);
								 ?>
								<li>
									<a class="gn-icon gn-icon-download" href="accessories/accessories.php?id=<?=$parent['id'];?>"><?=$parent['brand_name'];?></a>
									<ul class="gn-submenu">
										<?php while($child = mysqli_fetch_assoc($cquery)): ?>
										<li><a class="gn-icon gn-icon-article" href="accessories/accessories.php?id=<?=$parent['id'];?>&cid=<?=$child['id']; ?>"><?=$child['brand_name'];?></a></li>
										<?php endwhile; ?>
									</ul>
								</li>
								<?php endwhile;?>
								<li><a class="gn-icon gn-icon-help">Help</a></li>
							</ul>
						</div><!-- /gn-scroller -->
					</nav>
				</li>
				<li><a href="#">MyShop.com</a></li>
				<li><a class="codrops-icon codrops-icon-prev" href="#"><span>Previous Demo</span></a></li>
				<li><a class="codrops-icon codrops-icon-drop" href="#"><span>Shopping Cart</span></a></li>
			</ul>
		</div><!-- /container -->
		
		<script>
			new gnMenu( document.getElementById( 'gn-menu' ) );
		</script>
	</body>
</html>