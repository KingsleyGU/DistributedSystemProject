<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.js"></script>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<style> 
			.ui-helper-hidden-accessible:last-child {
			   display: none;
			}
			.ui-widget-content
			{
				list-style: none;
				color: #5bc0de;
				font-size: 20px;
				line-height: 30px;
			}
	</style>
</head>

<body>

<div class="container" id="page">

	<nav class="navbar navbar-default">
	  <div class="header-content" style="width:60%; display:inline-block; font-size:30px; font-weight:bold; text-align:center; color:#ffcc00;">
	      <a style="text-decoration:none; color:#ffcc00;" href="/yii/demos/distributeSystem/site/">ReipeKing</a>
	    </div>
    	<form class="navbar-form navbar-right" action="/yii/demos/distributeSystem/site/info" method="POST" style="margin-right:30px;">
	        <div class="form-group">
	          <input type="text" name="search" class="form-control" placeholder="Search">
	        </div>
	        <button type="submit" class="btn btn-success">Submit</button>
	      </form>
	</nav>

	<div class="row">
		<div class="all-info"></div>
		<div class="innerDiv" style="display:none;">
		  <div class="col-md-4">
		  	<a class="recipe-link" href="#" style="text-decoration:none; width:100%; display:inline-block; margin: 10px 0px 50px;">
		  		<image class="recipe-image" src="http://i.forbesimg.com/media/lists/people/taylor-swift_416x416.jpg" style="border-radius:5px; height:350px;width:100%;">
		   		<div class="recipe-title" style="border-bottom-left-radius:5px; border-bottom-right-radius:5px;font-size:18px; line-height:50px; text-align:center; position:relative; margin:-50px 0px; height:50px; background:#000; color:#fff; width:100%; opacity: 0.5;">yesyeye</div>
		   	</a>
		  </div>
		</div>

		<div class="col-md-12" style="padding-top:50px; text-align:center;">
			<div class="choices-show" style="padding-bottom:10px;">
			</div>
			<div style="display:none;">
				<div class="template-div" style="display:inline-block;">
					<button type="button" onclick="hide(this)" class="template-btn btn btn-sm" aria-label="Left Align"><span class="content-ingre">hahah</span>
					  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					</button>
				</div>
			</div>	
      		<input id="tags" type="text" style="width:40%; display:inline-block;" class="form-control" placeholder="Search">
	        <button class="btn btn-warning add-content">add</button>
			<form method="POST" action="/yii/demos/distributeSystem/site/info" style="display:inline-block;">
          		<input id="searchTags" type="hidden" name="search"  placeholder="Search">
	        	<button type="submit" class="btn btn-success">Submit</button>
			</form>
		</div>
	</div>



</div><!-- page -->

</body>
<script type="text/javascript">
var ingreInput = new Array();
$(document).ready(function(){
	var baseUrl = "<?php echo Yii::app()->request->baseUrl; ?>";
	var ingreChoices = null;
	$.get( baseUrl + "/site/rand" )
  .done(function( data ) {
    // alert(JSON.parse(data)[0].recipeId);
       var json = jQuery.parseJSON(data);
       for(var m=0; m<json.length;m++)
       {
       	  $('.innerDiv').find(".recipe-link").attr("href", "/yii/demos/distributeSystem/site/display?recipeId="+json[m].recipeId);
    	  $('.innerDiv').find(".recipe-title").text(json[m].title);
    	  $('.innerDiv').find(".recipe-image").attr("src",json[m].imageUrl);
    	  var finalHtmlString = $('.innerDiv').html();
          $('.all-info').append(finalHtmlString);
       }
  });
	  	$.get( baseUrl + "/site/list" )
	  .done(function( data ) {
	    // alert(JSON.parse(data)[0].recipeId);
	       var json = jQuery.parseJSON(data);
	       ingreChoices = json;
	  });
	 $( "#tags" ).autocomplete({
	  source: function( request, response ) {
	          var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
	          response( $.grep( ingreChoices, function( item ){
	              return matcher.test( item );
	          }) );
	      }
	});
	 $('.add-content').click(function(){
	 	var ingreValue = $('#tags').val();
	 	$('#tags').val("");
	 	if(ingreValue!= "")
	 	{
		 	ingreInput.push(ingreValue);
		 	// alert(ingreInput.keys(a).length);
		 	// alert(ingreInput[ingreValue]);
		 	$('.choices-show').empty();
		 	var searchValue = "";
		 	for(i=0;i<ingreInput.length;i++)
		 	{
		 		$('.template-div').find(".content-ingre").text(ingreInput[i]);
	    	    var finalHtmlString = $('.template-div').html();
		        $('.choices-show').append(finalHtmlString);
		     }
		     var searchValue = ingreInput.join(',');
		     // alert(searchValue);

			$('#searchTags').val(searchValue);			
		 }

	 });

})
	 function hide(selector)
	 {
	 	// alert("222");
		 $(selector).css('display','none');
		 var item = $(selector).find(".content-ingre").text();
		 ingreInput.splice(ingreInput.indexOf(item), 1);
	     var searchValue = ingreInput.join(',');
		 // alert(searchValue);

		$('#searchTags').val(searchValue);	
	 	//  delete ingreInput[item;
	 	//  		 	$.each( ingreInput, function( key, value ) {
		 //    	 alert(key);
			// });

	 }
</script>
</html>
