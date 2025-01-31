<?php 
session_start();
isset($_SESSION["email"]);

 ?>

<!DOCTYPE html>
<html>
<head>
   <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
   <style>
     #mapid { height: 180px; }

     

     .table td {
    text-align: left;
    padding: 10px;
}
.table th {
    width: 30%;
    text-align: left;
}

h3 {
    font-size: 20px;
  }

  h4  {
    font-size: 20px;
  }

  table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  text-align: left;
  padding: 1px;
}



   </style>
</head>
<body>




<?php 
include('config.php');
include('navbar.php');
include('review-engine.php');
include('booking-engine.php');
?>



<?php


	$property_id=$_GET['property_id'];
    $sql="SELECT * from add_property where property_id='$property_id'";
	$query=mysqli_query($db,$sql);

	if(mysqli_num_rows($query)>0)
{
    while($rows=mysqli_fetch_assoc($query)){         



    $sql2="SELECT * FROM property_photo where property_id='$property_id'";
    $query2=mysqli_query($db,$sql2);
    
    $rowcount=mysqli_num_rows($query2);
?>
        
      
        
 <div class="container-fluid">
  <div class="row">
    <div class="col-sm-6">
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
          <?php
          for($i = 1; $i <= $rowcount; $i++) {
              $row = mysqli_fetch_array($query2);
              $photo = $row['p_photo'];
          ?>
            <div class="item <?php echo ($i == 1) ? 'active' : ''; ?>">
              <img class="d-block img-fluid" src="<?php echo $photo ?>" alt="First slide" width="100%" style="max-height: 500px; min-height: 500px;">
            </div>
          <?php } ?>
        </div>
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>

    <div class="col-sm-6">
      <center><h2><?php echo $rows['property_type'] ?></h2></center>
      <div class="row">
        <div class="col-sm-6">
          <table class="table table-bordered">
            <tr>
              <td><strong>Country:</strong></td>
              <td><?php echo $rows['country']; ?></td>
            </tr>
            <tr>
              <td><strong>Division:</strong></td>
              <td><?php echo $rows['division']; ?></td>
            </tr>
            <tr>
              <td><strong>District:</strong></td>
              <td><?php echo $rows['district']; ?></td>
            </tr>
            <tr>
              <td><strong>City:</strong></td>
              <td><?php echo $rows['city']; ?></td>
            </tr>
            <tr>
              <td><strong>Rural/Urban:</strong></td>
              <td><?php echo $rows['rural_urban']; ?></td>
            </tr>
            <tr>
              <td><strong>Address:</strong></td>
              <td><?php echo $rows['address']; ?></td>
            </tr>
            <tr>
              <td><strong>Contact No.:</strong></td>
              <td><?php echo $rows['contact_no']; ?></td>
            </tr>
            <tr>
              <td><strong>Rent:</strong></td>
              <td>Rs.<?php echo $rows['rent']; ?></td>
            </tr>
          </table>
        </div>
        <div class="col-sm-6">
          <table class="table table-bordered">
            <tr>
              <td><strong>Total Rooms:</strong></td>
              <td><?php echo $rows['total_rooms']; ?></td>
            </tr>
            <tr>
              <td><strong>Bedrooms:</strong></td>
              <td><?php echo $rows['bedroom']; ?></td>
            </tr>
            <tr>
              <td><strong>Living Room:</strong></td>
              <td><?php echo $rows['living_room']; ?></td>
            </tr>
            <tr>
              <td><strong>Kitchen:</strong></td>
              <td><?php echo $rows['kitchen']; ?></td>
            </tr>
            <tr>
              <td><strong>Bathroom:</strong></td>
              <td><?php echo $rows['bathroom']; ?></td>
            </tr>
            <tr>
              <td><strong>Availability Status:</strong></td>
              <td><?php echo $rows['availability_status']; ?></td>
            </tr>
          </table>
        </div>
      </div>  
    </div>
  </div>
  <br>

  <?php 
  // Booking functionality
  if (isset($_SESSION["email"])) {
      $availability_status = $rows['availability_status'];

      echo '<form method="POST">';
      echo '<div class="row">';
      echo '<div class="col-sm-6">';

      if ($availability_status == 'Available') {
          echo '<input type="hidden" name="property_id" value="' . htmlspecialchars($rows['property_id']) . '">';
          echo '<input type="submit" class="btn btn-lg btn-primary" name="book_property" style="width: 100%" value="Book Property">'; // booking-engine works here
      } else {
          echo '<input type="submit" class="btn btn-lg btn-primary" style="width: 100%" value="Property Booked" disabled>';
      }

      echo '</div>';
      echo '</form>';

      // Chat functionality
      echo '<form method="POST" action="chatpage.php">';
      echo '<div class="col-sm-6">';
      echo '<input type="hidden" name="owner_id" value="' . htmlspecialchars($rows['owner_id']) . '">';
      echo '<input type="submit" class="btn btn-lg btn-success" name="send_message" style="width: 100%" value="Send Message">';
      echo '</div>';
      echo '</form>';
  } else {
      echo "<center><h3>You should log in to book property.</h3></center>";
  } }} 
  ?>
</div>

</div>

<!--review and rating-->
<div class="container-fluid">
  <h2>Review Property:</h2>
      <div class="well well-sm">
            <div class="text-right">
<?php 
      
if(isset($_SESSION["email"]) && !empty($_SESSION['email'])){ //check if someone is logged in
?>
                <a class="btn btn-success btn-info" href="#reviews-anchor" style="width: 100%" id="open-review-box">Leave a Review</a> <!--button for review-->
            </div>
        
            <div class="row" id="post-review-box" style="display:none;">
                <div class="col-md-12">
                    <form accept-charset="UTF-8" method="POST">
                      <input name="property_id" type="hidden" value="<?php echo $property_id; ?>">
                        <input id="ratings-hidden" name="rating" type="hidden"> 
                        <textarea class="form-control animated" cols="50" id="new-review" name="comment" placeholder="Enter your review here..." rows="5"></textarea>
        
                        <div class="text-right">
                            <div class="stars starrr" data-rating="0"></div>
                            <a class="btn btn-danger btn-sm" href="#" id="close-review-box" style="display:none; margin-right: 10px;">
                            <span class="glyphicon glyphicon-remove"></span>Cancel</a>
                            <button class="btn btn-success btn-lg" type="submit" name="review">Save</button>  <!-- work of review-engine-->
                        </div>
                    </form>
                </div>
                </div>
              <?php } 
              else{
                echo "<center>You should login to review property.</center>";
              }
              ?>

            
        </div> 

</div>

<!-- fetching reviews-->
<?php

    $sql1="SELECT * from review where property_id='$property_id'";
  $query=mysqli_query($db,$sql1);
echo '<div class="container-fluid">';
    echo '<h3>Reviews:</h3>';
    echo '</div>';
  if(mysqli_num_rows($query)>0)
    
{
    while($row=mysqli_fetch_assoc($query)){
      ?>
      <div class="container-fluid">        
        <ul><li><?php echo $row['comment']; ?> &nbsp;&nbsp;&nbsp;(<span class="glyphicon glyphicon-star-empty" style="size: 50px;"><?php echo $row['rating']; ?></span>)</li></ul>
      </div>


      <?php
    }
  }     
 ?>
<br><br>




</body>
</html>

<!-- for review button and box-->
<script>
  (function(e){var t,o={className:"autosizejs",append:"",callback:!1,resizeDelay:10},i='<textarea tabindex="-1" style="position:absolute; top:-999px; left:0; right:auto; bottom:auto; border:0; padding: 0; -moz-box-sizing:content-box; -webkit-box-sizing:content-box; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden; transition:none; -webkit-transition:none; -moz-transition:none;"/>',n=["fontFamily","fontSize","fontWeight","fontStyle","letterSpacing","textTransform","wordSpacing","textIndent"],s=e(i).data("autosize",!0)[0];s.style.lineHeight="99px","99px"===e(s).css("lineHeight")&&n.push("lineHeight"),s.style.lineHeight="",e.fn.autosize=function(i){return this.length?(i=e.extend({},o,i||{}),s.parentNode!==document.body&&e(document.body).append(s),this.each(function(){function o(){var t,o;"getComputedStyle"in window?(t=window.getComputedStyle(u,null),o=u.getBoundingClientRect().width,e.each(["paddingLeft","paddingRight","borderLeftWidth","borderRightWidth"],function(e,i){o-=parseInt(t[i],10)}),s.style.width=o+"px"):s.style.width=Math.max(p.width(),0)+"px"}function a(){var a={};if(t=u,s.className=i.className,d=parseInt(p.css("maxHeight"),10),e.each(n,function(e,t){a[t]=p.css(t)}),e(s).css(a),o(),window.chrome){var r=u.style.width;u.style.width="0px",u.offsetWidth,u.style.width=r}}function r(){var e,n;t!==u?a():o(),s.value=u.value+i.append,s.style.overflowY=u.style.overflowY,n=parseInt(u.style.height,10),s.scrollTop=0,s.scrollTop=9e4,e=s.scrollTop,d&&e>d?(u.style.overflowY="scroll",e=d):(u.style.overflowY="hidden",c>e&&(e=c)),e+=w,n!==e&&(u.style.height=e+"px",f&&i.callback.call(u,u))}function l(){clearTimeout(h),h=setTimeout(function(){var e=p.width();e!==g&&(g=e,r())},parseInt(i.resizeDelay,10))}var d,c,h,u=this,p=e(u),w=0,f=e.isFunction(i.callback),z={height:u.style.height,overflow:u.style.overflow,overflowY:u.style.overflowY,wordWrap:u.style.wordWrap,resize:u.style.resize},g=p.width();p.data("autosize")||(p.data("autosize",!0),("border-box"===p.css("box-sizing")||"border-box"===p.css("-moz-box-sizing")||"border-box"===p.css("-webkit-box-sizing"))&&(w=p.outerHeight()-p.height()),c=Math.max(parseInt(p.css("minHeight"),10)-w||0,p.height()),p.css({overflow:"hidden",overflowY:"hidden",wordWrap:"break-word",resize:"none"===p.css("resize")||"vertical"===p.css("resize")?"none":"horizontal"}),"onpropertychange"in u?"oninput"in u?p.on("input.autosize keyup.autosize",r):p.on("propertychange.autosize",function(){"value"===event.propertyName&&r()}):p.on("input.autosize",r),i.resizeDelay!==!1&&e(window).on("resize.autosize",l),p.on("autosize.resize",r),p.on("autosize.resizeIncludeStyle",function(){t=null,r()}),p.on("autosize.destroy",function(){t=null,clearTimeout(h),e(window).off("resize",l),p.off("autosize").off(".autosize").css(z).removeData("autosize")}),r())})):this}})(window.jQuery||window.$);

var __slice=[].slice;(function(e,t){var n;n=function(){function t(t,n){var r,i,s,o=this;this.options=e.extend({},this.defaults,n);this.$el=t;s=this.defaults;for(r in s){i=s[r];if(this.$el.data(r)!=null){this.options[r]=this.$el.data(r)}}this.createStars();this.syncRating();this.$el.on("mouseover.starrr","span",function(e){return o.syncRating(o.$el.find("span").index(e.currentTarget)+1)});this.$el.on("mouseout.starrr",function(){return o.syncRating()});this.$el.on("click.starrr","span",function(e){return o.setRating(o.$el.find("span").index(e.currentTarget)+1)});this.$el.on("starrr:change",this.options.change)}t.prototype.defaults={rating:void 0,numStars:5,change:function(e,t){}};t.prototype.createStars=function(){var e,t,n;n=[];for(e=1,t=this.options.numStars;1<=t?e<=t:e>=t;1<=t?e++:e--){n.push(this.$el.append("<span class='glyphicon .glyphicon-star-empty'></span>"))}return n};t.prototype.setRating=function(e){if(this.options.rating===e){e=void 0}this.options.rating=e;this.syncRating();return this.$el.trigger("starrr:change",e)};t.prototype.syncRating=function(e){var t,n,r,i;e||(e=this.options.rating);if(e){for(t=n=0,i=e-1;0<=i?n<=i:n>=i;t=0<=i?++n:--n){this.$el.find("span").eq(t).removeClass("glyphicon-star-empty").addClass("glyphicon-star")}}if(e&&e<5){for(t=r=e;e<=4?r<=4:r>=4;t=e<=4?++r:--r){this.$el.find("span").eq(t).removeClass("glyphicon-star").addClass("glyphicon-star-empty")}}if(!e){return this.$el.find("span").removeClass("glyphicon-star").addClass("glyphicon-star-empty")}};return t}();return e.fn.extend({starrr:function(){var t,r;r=arguments[0],t=2<=arguments.length?__slice.call(arguments,1):[];return this.each(function(){var i;i=e(this).data("star-rating");if(!i){e(this).data("star-rating",i=new n(e(this),r))}if(typeof r==="string"){return i[r].apply(i,t)}})}})})(window.jQuery,window);$(function(){return $(".starrr").starrr()})

$(function(){

  $('#new-review').autosize({append: "\n"});

  var reviewBox = $('#post-review-box');
  var newReview = $('#new-review');
  var openReviewBtn = $('#open-review-box');
  var closeReviewBtn = $('#close-review-box');
  var ratingsField = $('#ratings-hidden');

  openReviewBtn.click(function(e)
  {
    reviewBox.slideDown(400, function()
      {
        $('#new-review').trigger('autosize.resize');
        newReview.focus();
      });
    openReviewBtn.fadeOut(100);
    closeReviewBtn.show();
  });

  closeReviewBtn.click(function(e)
  {
    e.preventDefault();
    reviewBox.slideUp(300, function()
      {
        newReview.focus();
        openReviewBtn.fadeIn(200);
      });
    closeReviewBtn.hide();
    
  });

  $('.starrr').on('starrr:change', function(e, value){
    ratingsField.val(value);
  });
});
</script>