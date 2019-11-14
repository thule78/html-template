
<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
<script>
function myFunction(str) {
   var element = document.getElementById(str);
   element.classList.toggle("labelactive");
}
</script>
<style>


/* Style the tab */
.tab {
  float: left;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
  width: 30%;
  height: 300px;
}

/* Style the buttons inside the tab */
.tab .button-design {
  display: block;
  background-color: inherit;
  color: black;
  padding: 22px 16px;
  width: 100%;
  border: none;
  outline: none;
  text-align: left;
  cursor: pointer;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab .button-design:hover {
  background-color: #ddd;
}

/* Create an active/current "tab button" class */
.tab .button-design .active {
  background-color: #ccc;
}

/* Style the tab content */

.display-hide
{
display:none;
}
.showlabel
{
display:block ! important;
}


.myaccount-tab-menu a:hover, .myaccount-tab-menu a.active {
	background-color: #ffa500;
	border-color: #ffa500;
	color: #fff;
}
.myaccount-tab-menu a {
	border: 1px solid #efefef;
	border-bottom: none;
	color: #fff;
	font-weight: 400;
	font-size: 15px;
	display: block;
	padding: 10px 15px;
	text-transform: capitalize;
}
.tab-content .tab-pane.active {
	height: auto;
	opacity: 1;
	overflow: visible;
	visibility: visible;
}
.myaccount-tab-menu {
	-webkit-box-orient: vertical;
	-webkit-box-direction: normal;
	-webkit-flex-direction: column;
	-ms-flex-direction: column;
	flex-direction: column;
}
.myaccount-tab-menu a {
	border: 1px solid #efefef;
	border-bottom: none;
	color: #fff;
	font-weight: 400;
	font-size: 15px;
	display: block;
	padding: 10px 15px;
	text-transform: capitalize;
}
.myaccount-tab-menu a:last-child {
	border-bottom: 1px solid #efefef;
}
.myaccount-tab-menu a:hover, .myaccount-tab-menu a.active {
	background-color: #ffa500;
	border-color: #ffa500;
	color: #fff;
}
.myaccount-tab-menu a i.fa {
	font-size: 14px;
	text-align: center;
	width: 25px;
}
 @media only screen and (max-width: 767.98px) {
#myaccountContent {
	margin-top: 30px;
}
}
.myaccount-content {
	border: 1px solid #eeeeee;
	padding: 30px;
}
 @media only screen and (max-width: 575.98px) {
.myaccount-content {
	padding: 20px 15px;
}
}
/*.myaccount-content form {
	margin-top: -20px;
}*/
.myaccount-content h5, .myaccount-content h3 {
	border-bottom: 1px dashed #ccc;
	padding-bottom: 10px;
	/*margin-bottom: 25px;*/
}
.myaccount-content .welcome a {
	color: #222222;
}
.myaccount-content .welcome a:hover {
	color: #ffa500;
}
.myaccount-content .welcome strong {
	font-weight: 500;
	color: #ffa500;
}
.myaccount-content fieldset {
	margin-top: 20px;
}
.myaccount-content fieldset legend {
	color: #222222;
	font-size: 20px;
	margin-top: 20px;
	font-weight: 400;
	border-bottom: 1px dashed #ccc;
}
.myaccount-table {
	white-space: nowrap;
	font-size: 14px;
}
.myaccount-table table th, .myaccount-table .table th {
	color: #222222;
	padding: 10px;
	font-weight: 400;
	background-color: #f8f8f8;
	border-color: #ccc;
	border-bottom: 0;
}
.myaccount-table table td, .myaccount-table .table td {
	padding: 10px;
	vertical-align: middle;
	border-color: #ccc;
}

.city-tabs .nav-tabs > li {
   padding: 0px;
    display: block;
	
    
}

.city-tabs .nav-tabs > li.active {
   
	background-color: #3525e6;
	border-color: #3525e6;
    color: #fff;
  
}

.city-tabs .nav-tabs>li.active a, .city-tabs.nav-tabs>li:focus a {
	color:#fff;
	border: 1px solid #efefef;
}
	

.my-content{
	border: 1px solid #eeeeee;
    padding: 30px;
}
.my-content h3{
	color:#fff;
}
label.city-box{
	
	padding: 25px 20px;
    background-size: cover;
    text-align: center;
    color: #fff;
    border-radius: 0px;
	display:block!important;
	margin-bottom: 20px;
	border: 2px solid #fff;
}
.labelactive{
	border: 2px solid #3525e6 !important;
}

.search-wrap .close {
   
    z-index: 999;
}



.city-tabs .nav-tabs>li a {
    border: 1px solid #efefef;
    color: #fff;
    font-weight: 400;
    font-size: 15px;
    display: block;
    padding: 10px 15px;
    text-transform: capitalize;
}
.city
{
	margin-top:20px;
}

</style>


<?php
$search_option = get_theme_mod('search_option');

if (empty($search_option) || $search_option == 'tour-search') :
	?>
	<form class="search-form" action="<?php echo home_url('/find/tours/'); ?>">
		<fieldset>
			<a href="#" class="search-opener hidden-md hidden-lg">
				<span class="icon-search"></span>
			</a>
			<div class="search-wrap">
				<a href="#" class="search-opener close">
					<span class="icon-cross"></span>
				</a>
				<div class="trip-form trip-form-v2 trip-search-main">
					<div class="trip-form-wrap">
					
					
					
				
					
		<div class="row">
        <div class="col-lg-3 col-md-4">
		<div class="city-tabs">
		<ul class="nav nav-tabs">
								<?php
    $categories = get_categories( array( 
  'parent' => 138,'taxonomy' => 'product_cat','orderby'=> 'id','order'=> 'asc'
) );
 $i=0;
foreach($categories as $category) :
$i++;
$term = get_term( $category, 'product_cat' );
?>
        <li class="tablinks <?php if($i==1) { ?>  active <?php } ?>"  > <a  href="javascript:;" onclick="openCity(event, 'tab<?php echo $i; ?>')"> <?php echo $term->name; ?></a></li>
<?php endforeach; ?>		
        </ul>	
	  </div>
            
                
                
          </div>
          <!-- My Account Tab Menu End --> 
          
          <!-- My Account Tab Content Start -->
          <div class="col-lg-9 col-md-8">
		  <div class="tab-content">
		  <div class="my-content">
		  <?php 
    $j=0; 
foreach($categories as $category2) :
$term2 = get_term( $category2, 'product_cat' );
$j++;
 ?>
        <div id="tab<?php echo $j; ?>"  <?php if($j>1) { ?> style="display:none" <?php } ?> class="tabcontent" >
          <div class="row">
		   <?php 

 $categoriessub = get_term_children($term2->term_id, 'product_cat' );  
foreach($categoriessub as $subcategory2) :
$subterm = get_term( $subcategory2, 'product_cat' );

 ?>
		  <div class="col-md-3">
<?php $thumbnail_id = get_woocommerce_term_meta($subterm->term_id, 'thumbnail_id', true ); 
$image = wp_get_attachment_url( $thumbnail_id );  ?>
		  		<label onclick="myFunction('lcity<?php echo $j; ?>')" id="lcity<?php echo $j; ?>" class="city-box" for="city<?php echo $j; ?>" style="background:url(<?php echo $image; ?>); background-size: cover;">
             <div class="city"><?php echo $subterm->name; ?></div>   </label> 
		  <input id="city<?php echo $j; ?>" class="display-hide" type="checkbox" value="<?php echo $subterm->slug; ?>" name="city[]" />
		  </div>
<?php endforeach; ?>
		  </div>


		
		</div>
<?php endforeach; ?>		
     
		</div>
		
		
      </div>
					
			
						
						




						
						
						
						
						<div class="holder">
					           <br><br>
							<button class="btn btn-trip btn-trip-v2" type="submit">
								<?php _e('Find Tours',  'entrada'); ?></button>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
	</form>
<?php else : ?>


	<form class="search-form" action="<?php echo home_url(); ?>">
		<fieldset>
			<a href="#" class="search-opener hidden-md hidden-lg">
				<span class="icon-search"></span>
			</a>
			<div class="search-wrap">
				<a href="#" class="search-opener close">
					<span class="icon-cross"></span>
				</a>
				<div class="form-group">
					<input type="text" autocomplete="off" class="form-control" name="s" placeholder="<?php esc_attr_e('Search',  'entrada'); ?>" id="search-input">
				</div>
			</div>
		</fieldset>
	</form>

<?php endif; ?>

