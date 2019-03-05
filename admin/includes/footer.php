<div><br><br>
<footer class="text-center" id="footer">&copy; Copyright 2016-2018 Chesire's Boutique</footer>
<script>
   function updateSizes(){
   	var sizeString = '';
    for (var i = 1; i <= 12; i++) {
      if (jQuery('#size'+i).val() != '') {
      sizeString += jQuery('#size'+i).val()+':'+jQuery('#qty'+i).val()+':'+jQuery('#threshold'+i).val()+',';
      }
    }
    jQuery('#sizes').val(sizeString);
   }
 function update_info(){
    var data = {
      'id'   : jQuery('#id').val(),
      'name' : jQuery('#name').val(),
      'email': jQuery('#email').val(),
      'permissions' : jQuery('#permissions').val()
    };
   jQuery.ajax({
    url : '/boutique/admin/parsers/update_info.php',
    method : 'POST',
    data : data,
    success : function(){
        window.location = "http://localhost/boutique/admin/users.php";
      },
    error : function(){alert("Something went wrong")}
   });
  }


	function get_child_options(selected){
    if (typeof selected === 'undefined') {
      var selected = '';
    }
    var parentID = jQuery('#parents').val();
    jQuery.ajax({
    url : '/boutique/admin/parsers/child_category.php',
    type: 'POST',
    data: {parentID : parentID, selected : selected},
    success: function(data){
     jQuery('#child').html(data);
    },
    error: function(){alert("Something went wrong with the child options")},
    });
	} 
	jQuery('select[name="parents"]').change(function(){
    get_child_options();
  });

  function get_brand_type(selected){
    if (typeof selected === 'undefined') {
      var selected = '';
    }
    var categoryId = jQuery('#category').val();
    jQuery.ajax({
      url  : '/boutique/admin/parsers/brand_type.php',
      type : 'post',
      data :  {categoryId : categoryId, selected : selected},
      success : function(data){
        jQuery('#brand').html(data);
      },
      error : function(){alert("Something went wrong with the brand type")},
    });
  }
  jQuery('select[name = "category"]').change(function(){
    get_brand_type();
  });
</script>
<script src="/boutique/javascript/jquery-3.3.1.min.js"></script>
<script src="/boutique/javascript/popper.min.js"></script>
<script src="/boutique/javascript/util.js"></script>
<script src="/boutique/javascript/modal.js"></script>
<script src="/boutique/javascript/collapse.js"></script>
<script src="/boutique/javascript/tooltip.js"></script>
<script src="/boutique/javascript/popover.js"></script>
</body>
</html>