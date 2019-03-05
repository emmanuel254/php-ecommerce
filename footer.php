 
<footer class="text-center" id="footer">&copy; Copyright 2016-2018 Chesire's Boutique</footer>

<script>

function detailsmodal(id)
{
  var data = {"id" : id};
  jQuery.ajax({
    url : '/boutique/detailsmodal.php',
    method : "post",
    data : data,
    success : function(data){
      jQuery('body').append(data);
      jQuery('#details-modal').modal('toggle');
    },
    error :function(){
      alert("something went wrong!");
    }
  }); 
}

function update_cart(mode,edit_id,edit_size){
   var data = {"mode" : mode, "edit_id" : edit_id, "edit_size" : edit_size};
   jQuery.ajax({
    url :'/boutique/admin/parsers/update_cart.php',
    method : "post",
    data : data,//the var data created above
    success : function(){location.reload();},
    error : function(){alert("Something went wrong.");},

   })
}

function add_to_cart(){
  jQuery('#modal_errors').html("");
  var size = jQuery('#size').val();
  var quantity = jQuery('#quantity').val();
  var available = jQuery('#available').val();
  var error = '';
  var data = jQuery('#add_product_form').serialize();

  if (size == '' || quantity == '' || quantity == 0) {
    error += '<p class="text-danger text-center">You must choose a size and quantity<hr>.</p>';
    jQuery('#modal_errors').html(error);
    return;
  }
  else if(quantity > available){
    error += '<p class="text-danger text-center">Their are only '+available+' available<hr>.</p>'
    jQuery('#modal_errors').html(error);
    return;
  }else{
    jQuery.ajax({
      url : '/boutique/admin/parsers/add_cart.php',
      method : 'post',
      data : data,
      success : function(){
        location.reload();
      },
      error : function(){alert("Something went wrong");}
    });
  }
  
}

function add_cart(){
       jQuery('#errors').html("");
       var available = jQuery('#available').val();
       var quantity = jQuery('#quantity').val();
       var title = jQuery('#title').val();
       var error = '';
       var data = jQuery('#accessories_form').serialize();

       if (quantity == '' || quantity == 0) {
        error += '<p class = "text-center text-danger">You must enter quantity</p>';
        jQuery('#errors').html(error);
        return;
       }
       else if(quantity > available){
      error += '<p class = "text-center text-danger">Their are only '+available+' '+title+' available</p>';
        jQuery('#errors').html(error);
        return;
       }
       else{
          jQuery.ajax({
            url : '/boutique/admin/parsers/access_cart.php',
            method : 'post',
            data : data,
            
            success : function(){
             window.location.replace ("http://localhost/boutique/accessories/");
            },
            error : function(){
              alert("Something went wrong");
            }

          });
       }
  }
  function delete_cart(id){
    var data = {"id" : id};
    jQuery.ajax({
       url : '../admin/parsers/delete_cart.php',
       method : 'post',
       data : data,
       success : function(){
        location.reload();
       },
       error : function(){
        alert("Something went wrong with delete");
       }
    });
  }
</script>
<script src="/boutique/javascript/popper.min.js"></script>
<script src="/boutique/javascript/util.js"></script>
<script src="/boutique/javascript/modal.js"></script>
<script src="/boutique/javascript/collapse.js"></script>
<script src="/boutique/javascript/tooltip.js"></script>
<script src="/boutique/javascript/popover.js"></script>
</body>
</html>