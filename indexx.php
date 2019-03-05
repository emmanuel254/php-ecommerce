<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/boutique/init.php';
  include 'accessories/heading/header.php';
  include 'accessories/navigation.php';
 
?>

      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="first-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="First slide">
            <div class="container">
              <div class="carousel-caption text-left">
                <h1>Example headline.</h1>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="second-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Second slide">
            <div class="container">
              <div class="carousel-caption">
                <h1>Another example headline.</h1>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="third-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Third slide">
            <div class="container">
              <div class="carousel-caption text-right">
                <h1>One more for good measure.</h1>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
              </div>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

      <div class="index-page">
      	<div class="item-one">
      	  <p class="text-center">sdfvgvsfdvfsvfvffdvvfd</p>	
      	</div>
      	<div class="item-two">
      		<p class="text-center">adfwaefrefeergregvrwgv</p>
      	</div>
      	<div class="item-one">
      	  <p class="text-center">sdfvgvsfdvfsvfvffdvvfd</p>	
      	</div>
      	<div class="item-two">
      		<p class="text-center">adfwaefrefeergregvrwgv</p>
      	</div>
      </div>
      <div class="row">
      	<div class="col-sm-3">
      	  <img class="index-images" src="images/products/020d13de3e0c2414e2993ce1859146a4.png">	
      	</div>
      	<div class="col-sm-3">
      		<img class="index-images" src="images/products/020d13de3e0c2414e2993ce1859146a4.png">
      	</div>
      	<div class="col-sm-3">
      	  <img class="index-images" src="images/products/020d13de3e0c2414e2993ce1859146a4.png">	
      	</div>
      	<div class="col-sm-3">
      		<img class="index-images" src="images/products/020d13de3e0c2414e2993ce1859146a4.png">
      	</div>
  </div>

 <?php include 'footer.php'; ?>