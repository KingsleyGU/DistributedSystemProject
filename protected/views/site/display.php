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
	
		<div class="col-md-8" style="text-align:center;">
			<h1 style="text-align:center;"><?php echo $recipeDetail['title'];?></h1>
			<img src="<?php echo $recipeDetail['imageUrl'];?>" style="height:500px; width:500px;">
			<h3> Recipe List:</h3>
				<hr style="border:1px solid #444; color:#000;">
			<div class="description" style="word-spacing:2px;text-align:left; font-size:15px; margin:0px 60px;">
				<?php 
				for($i=0;$i<count($recipeDetail['ingredients']);$i++)
				{ ?>
					<p><?php echo $recipeDetail['ingredients'][$i]['ingredients'];?></p>
                    <hr>
				<?php }
				?>
			</div>
		</div>
		<div class="col-md-4" style="padding-top:30px;">
			<div class="innerDiv" style="display:none;">		  
			  	<a class="recipe-link" href="#" style="text-decoration:none; display:inline-block; margin: 10px 10px 10px;">
			  		<image class="recipe-image" src="http://i.forbesimg.com/media/lists/people/taylor-swift_416x416.jpg" style="border-radius:5px; height:100px;width:110px">			   		
		  		</a>
		   </div>

		</div>


</div><!-- page -->

</body>
<script type="text/javascript">
$(document).ready(function(){
	var baseUrl = "<?php echo Yii::app()->request->baseUrl; ?>";
	$.get( baseUrl + "/site/rand" )
  .done(function( data ) {
    // alert(JSON.parse(data)[0].recipeId);
       var json = jQuery.parseJSON(data);
       for(var m=0; m<json.length;m++)
       {
       	  $('.innerDiv').find(".recipe-link").attr("href", "/yii/demos/distributeSystem/site/display?recipeId="+json[m].recipeId);
    	  // $('.innerDiv').find(".recipe-title").text(json[m].title);
    	  $('.innerDiv').find(".recipe-image").attr("src",json[m].imageUrl);
    	  var finalHtmlString = $('.innerDiv').html();
          $('.col-md-4').append(finalHtmlString);
       }
  });

})

</script>
</html>
