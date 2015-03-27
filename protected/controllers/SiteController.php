<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	public function actionSearch()
	{	
		if(isset($_GET['name'])&&strlen($_GET['name']) > 0)
		{
			$searchItem = $_GET['name'];
			$match = addcslashes($searchItem, '%_'); // escape LIKE's special characters
			$q = new CDbCriteria( array(
			    'condition' => "title LIKE :match",         // no quotes around :match
			    'params'    => array(':match' => "%$match%")  // Aha! Wildcards go here
			) );
			 
			$RecipeModel = Recipe::model()->findAll( $q ); 
			// $model = Recipe::model()->findAll("category=:category",array(":category"=>'%$searchItem%'));  
			$recipeJson =array();
			$n = 0;
			foreach ($RecipeModel as $num)
			{   $recipeId = $num->recipeId;			
				$RecipeIngredientModel = RecipeIngredient::model()->findAll("recipeId=:recipeId",array(":recipeId"=>$recipeId));

				$JSONCom = array('recipeId'=>$num->recipeId,'title'=>$num->title,
				'webUrl'=>$num->webUrl,'imageUrl'=>$num->imageUrl);
				array_push($recipeJson, $JSONCom);
				$n++;
				if($n>20)
					break;
			}
			echo json_encode($recipeJson);
		}
	}
	public function actionRand()
	{
	    $listIndex = 12;
        if(isset($_GET['indexNum']))
        {
          $listIndex = intval($_GET['indexNum']);
        }
		$sqlStatement = "select recipeId from Recipe order by RAND() limit ".$listIndex;
		$list= Yii::app()->db->createCommand($sqlStatement)->queryAll();
		$recipeJson =array();
		for($i=0; $i<sizeof($list); $i++)
		{
			// echo $list[$i]['recipeId'];
			$sqlNewStatement = "select ingredients from RecipeIngredient where recipeId ='".$list[$i]['recipeId']."'";
		    // echo $sqlNewStatement;
		    $ingredientList= Yii::app()->db->createCommand($sqlNewStatement)->queryAll();
		    // echo "$key = $val\n";
			$RecipeModel = Recipe::model()->find("recipeId=:recipeId",array(":recipeId"=>$list[$i]['recipeId']));
			$JSONCom = array('recipeId'=>$list[$i]['recipeId'],'title'=>$RecipeModel->title,
			'ingredients'=>$ingredientList,'webUrl'=>$RecipeModel->webUrl,'imageUrl'=>$RecipeModel->imageUrl);
			array_push($recipeJson, $JSONCom);

		}
		echo json_encode($recipeJson);


	}
	public function actionList()
	{
		$sqlStatement = "select * from Ingredients";
		$ingredientList= Yii::app()->db->createCommand($sqlStatement)->queryAll();
		// echo count($ingredientList);
		// for($i=1;$i<=count($ingredientList);$i++)
		// {
		// 	$name = $ingredientList[($i-1)]['name'];
			
		// 	$name = str_replace("\n","",$name);
		// 	$name = str_replace(" ","",$name);
		// 	echo $name;
		// 	$sqlNewStatement = 'update Ingredients set name ="'.$name.'" where id='.$i;
		// 	// echo $sqlNewStatement;
		// 	$yes = Yii::app()->db->createCommand($sqlNewStatement)->execute();
		// 	// $Yii::app()->db->commit();
		// 	// echo $i;
		// }
		$ingreList = array();
		for($i=0;$i<count($ingredientList);$i++)
		{
			$name = $ingredientList[$i]['name'];
			array_push($ingreList, $name);

		}
		echo json_encode($ingreList);

	}
	public function actionRecipe()
	{
		$recipeJson =array();
		if(isset($_GET['ingredients']))
		{
			$recipeList = array();
			$ingredients = $_GET['ingredients'];
			$iOptions = explode(',', $ingredients);
			// echo $iOptions[1];
			if(strlen($iOptions[0])>0)
			{
				for($i=0; $i<sizeof($iOptions); $i++)
				{
					$sqlStatement = "select distinct recipeId from RecipeIngredient where ingredients like '%".$iOptions[$i]."%'";;
					$list= Yii::app()->db->createCommand($sqlStatement)->queryAll();
					for($j=0; $j<sizeof($list); $j++)
					{
						$loop = true;
						if(count($recipeList)>0)
						{

							foreach ($recipeList as $key => $val)
							{
								if(($list[$j]['recipeId']) == $val['recipeId'])
								{
									$recipeList[$key]['IngreMatch']++;
									$loop = false;
									break;
								}
							}
						}
						if($loop)
						{
							$eachRecipeMatch = array();
							$subStatement = "select Ingredients from Recipe where recipeId ='".$list[$j]['recipeId']."'";
							$IngreNum = Yii::app()->db->createCommand($subStatement)->queryAll();
							$eachRecipeMatch['IngreNum'] = intval($IngreNum[0]['Ingredients']);
							$eachRecipeMatch['IngreMatch'] = 1;
							$eachRecipeMatch['recipeId'] = $list[$j]['recipeId'];
							array_push($recipeList, $eachRecipeMatch);
						}
					}
				}
                foreach ($recipeList as $key => $value) {
                	$IngreNum[$key] = $value['IngreNum'];
                	$IngreMatch[$key] = $value['IngreMatch'];
                }              
                array_multisort($IngreMatch, SORT_DESC, $IngreNum, SORT_ASC,$recipeList);
                 // array_multisort( $recipeList);
                // foreach ($recipeList as $key => $value) {
                // 	echo $value['IngreMatch']."  ".$value['IngreNum']." ";
                // }
				$n=0;
				foreach ($recipeList as $key => $val) {
					$sqlNewStatement = "select ingredients from RecipeIngredient where recipeId ='".$val['recipeId']."'";
    			    $RecipeModel = Recipe::model()->find("recipeId=:recipeId",array(":recipeId"=>$val['recipeId']));
					$JSONCom = array('recipeId'=>$val['recipeId'],'title'=>$RecipeModel->title,
					'webUrl'=>$RecipeModel->webUrl,'imageUrl'=>$RecipeModel->imageUrl);
					array_push($recipeJson, $JSONCom);
					$n++;
					if($n>20)
						break;
				}
				
			}	
		}
		echo json_encode($recipeJson);
	}

    public function actionCombine()
    {
		// $commentJson =[];
		// $sqlStatement = "select * from recipe";
		// $list= Yii::app()->db->createCommand($sqlStatement)->queryAll();
		// foreach ($list as $num)
		// {   
		// 	$JSONCom = json_encode(array('content'=>$num['title']));
		// 	array_push($commentJson, $JSONCom);
		// }
		// echo json_encode($commentJson);
    	if(isset($_GET['main'])&&isset($_GET['brine'])&&isset($_GET['aroma']))
    	{
    		$mainOption = $_GET['main'];
    		$BrineOption = $_GET['brine'];
    		$AromaOption = $_GET['aroma'];
    		$mOptions = split(',', $mainOption);
    		$bOptions = split(',', $BrineOption);
    		$aOptions = split(',', $AromaOption);
    		$sqlStatement = "select distinct recipeId from RecipeIngredient";
    		// echo $mainOption;
    		if(sizeof($mOptions)>=1&&strlen($mOptions[0])>0)
			{	
				// echo $mOptions[1]; 
		 		// :category')->bindValue('category',$category)
				// echo $sqlStatement;
				$sqlStatement = $sqlStatement." where ingredients like '%".$mOptions[0]."%'";
				// echo $sqlStatement;
				for($i=1; $i<sizeof($mOptions); $i++)
				{
					$sqlStatement = $sqlStatement." or ingredients like '%".$mOptions[$i]."%'";
				}
				// echo $sqlStatement;
			}
			// echo strlen($mOptions[0]);
			// echo $sqlStatement;
    		$list= Yii::app()->db->createCommand($sqlStatement)->queryAll();
		    $validResult = array();
		    for($j=0; $j<sizeof($list);$j++)
		    {
               if(!($this->checkValid($bOptions,$list[$j]['recipeId'])))
               {
               		break;
               }
               if(!($this->checkValid($aOptions,$list[$j]['recipeId'])))
               {
               		break;
               }
               $JSONresult = array('recipeId'=>$list[$j]['recipeId']);
				array_push($validResult, $JSONresult);

		    }
		    echo json_encode($validResult);

    	}
    }
    protected function checkValid($strArray,$recipeId)
    {
    	$sqlNewStatement = "select * from RecipeIngredient where recipeId='".$recipeId."'";
    	if(sizeof($strArray)>=1&&strlen($strArray[0])>0)
		{
			$sqlNewStatement = $sqlNewStatement." and ingredients like '%".$strArray[0]."%'";
			for($q=1; $q<sizeof($strArray); $q++)
			{
				$sqlNewStatement = $sqlNewStatement." or ingredients like '%".$strArray[$q]."%'";
			}
		}
		// echo $sqlNewStatement;
		$result = Yii::app()->db->createCommand($sqlNewStatement)->queryAll();
		if(sizeof($result)==0)
		{
			return false;
		}
		return true;
    }
    public function actionDetail()
    {
    	$recipeDetail = array();
    	if(isset($_GET['recipeId']))
    	{
    		$recipeId = $_GET['recipeId'];
    		$recipeStatement = "select * from Recipe where recipeId='".$recipeId."'";
    		$recipeResult = Yii::app()->db->createCommand($recipeStatement)->queryAll();
    		// echo json_encode($recipeResult);
			$ingredientStatement = "select ingredients from RecipeIngredient where recipeId ='".$recipeId."'";
		    $ingredientList= Yii::app()->db->createCommand($ingredientStatement)->queryAll();
			$recipeDetail = array('recipeId'=>$recipeId,'title'=>$recipeResult[0]['title'],
			'webUrl'=>$recipeResult[0]['webUrl'],'imageUrl'=>$recipeResult[0]['imageUrl'],
			'ingredients'=>$ingredientList);		
    	}
    	 echo json_encode($recipeDetail);
    }
    public function actionInfo()
    {
    	if(isset($_POST['search'])&&!empty($_POST['search']))
    	{
    		$searchItem = $_POST['search'];
			 $this->render('info',array(
					'searchItem'=>$searchItem,
			));  		
    	}
    	else
    	{
    		$this->redirect('index');
    	}
    }
    public function actionDisplay()
    {
    	$recipeDetail = array();
    	if(isset($_GET['recipeId']))
    	{
    		$recipeId = $_GET['recipeId'];
    		$recipeStatement = "select * from Recipe where recipeId='".$recipeId."'";
    		$recipeResult = Yii::app()->db->createCommand($recipeStatement)->queryAll();
    		// echo json_encode($recipeResult);
			$ingredientStatement = "select ingredients from RecipeIngredient where recipeId ='".$recipeId."';";
		    // echo $ingredientStatement;
		    $ingredientList= Yii::app()->db->createCommand($ingredientStatement)->queryAll();
		    // echo json_encode($ingredientList);
			$recipeDetail = array('recipeId'=>$recipeId,'title'=>$recipeResult[0]['title'],
			'webUrl'=>$recipeResult[0]['webUrl'],'imageUrl'=>$recipeResult[0]['imageUrl'],
			'ingredients'=>$ingredientList);	
				
    	}
    	// echo json_encode($recipeDetail);
          $this->render('display',array(
			'recipeDetail'=>$recipeDetail
		));
    	 // $this->render('detail',array('recipeDetail'=>$recipeDetail));
    }

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('main');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	// public function actionError()
	// {
	// 	if($error=Yii::app()->errorHandler->error)
	// 	{
	// 		if(Yii::app()->request->isAjaxRequest)
	// 			echo $error['message'];
	// 		else
	// 			$this->render('error', $error);
	// 	}
	// }


}