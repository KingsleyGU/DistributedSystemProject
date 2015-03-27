<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css" />
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.js"></script>
	<title>recipeDetail</title>
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
	<div class="row" >
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<h2 style="text-align:center;">Search result for:
				<?php 
				  $iOptions = explode(',', $searchItem);
				  $choice = $iOptions[0];
				  for($i=1;$i<count($iOptions);$i++)
				  {
				  	$choice = $choice." and ".$iOptions[$i];
				  }
				  echo $choice;
				?>
			</h2>
			<hr style="border:2px solid #444; color:#000;">
			<div class="result-show">
				<div class="innerDiv" style="display:none;">
					<a href="" class="recipe-link" style="color:#000;" style="display:block;">
						<img class="recipe-image" style="margin-left:50px;width:150px; height:150px; display:inline-block;" src="http://i.forbesimg.com/media/lists/people/taylor-swift_416x416.jpg">
						<div style=" margin-left:50px;display:inline-block;" class="recipe-title">ashbdchadsjc</div>
					</a>
					<hr style="border:1px solid #aaa;">
				</div>
			</div>
		</div>
		<div class="col-md-2"></div>
	</div>




</div><!-- page -->

</body>
<script type="text/javascript">
$(document).ready(function(){
	var baseUrl = "<?php echo Yii::app()->request->baseUrl; ?>";
	var searchWord = "<?php echo $searchItem;?>";
	$.get( baseUrl + "/site/recipe" ,{ingredients:searchWord})
  .done(function( data ) {
    // alert(JSON.parse(data)[0].recipeId);
       var json = jQuery.parseJSON(data);
       for(var m=0; m<json.length;m++)
       {
       	  $('.innerDiv').find(".recipe-link").attr("href", "/yii/demos/distributeSystem/site/display?recipeId="+json[m].recipeId);
    	  // $('.innerDiv').find(".recipe-title").text(json[m].title);
    	  $('.innerDiv').find(".recipe-image").attr("src",json[m].imageUrl);
    	  $('.innerDiv').find(".recipe-title").text(json[m].title);
    	  var finalHtmlString = $('.innerDiv').html();
          $('.result-show').append(finalHtmlString);
       }
  });

})

</script>
</html>
