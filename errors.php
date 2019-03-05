<!DOCTYPE html>
<html>
<head>
	<title>Side bar menu</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
   <div id="sidebar">
   	 <ul>
   	 	<li><a href="#">Link 1</a></li>
   	 	<li><a href="#">Link 2</a>
          <ul class="sublink">
          	<li><a href="#">Sub link</a></li>
          	<li><a href="#">Sub link</a></li>
          </ul>
   	 	</li>
   	 	<li><a href="#">Link 3</a></li>
   	 	<li><a href="#">Link 4</a></li>
   	 	<li><a href="#">Link </a></li>
   	 </ul>
   	 <div id="sidebar-btn">
   	   <span></span>
   	   <span></span>
   	   <span></span>
   </div>
   </div>
   <script src="/boutique/javascript/jquery-3.3.1.min.js"></script>
   <script>
   	 $(document).ready(function(){
   	 	$('#sidebar-btn').click(function(){
           $('#sidebar').toggleClass('visible');
   	 	});
   	 });
   </script>
</body>
</html>