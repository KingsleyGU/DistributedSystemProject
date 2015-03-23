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
	public function actionTap()
	{	
		if(isset($_GET['search'])&&strlen($_GET['search']) > 0)
		{
			$searchItem = $_GET['search'];
			$match = addcslashes($searchItem, '%_'); // escape LIKE's special characters
			$q = new CDbCriteria( array(
			    'condition' => "title LIKE :match",         // no quotes around :match
			    'params'    => array(':match' => "%$match%")  // Aha! Wildcards go here
			) );
			 
			$RecipeModel = Recipe::model()->findAll( $q ); 
			// $model = Recipe::model()->findAll("category=:category",array(":category"=>'%$searchItem%'));  
			$recipeJson =[];
			foreach ($RecipeModel as $num)
			{   $recipeId = $num->recipeId;			
				$RecipeIngredientModel = RecipeIngredient::model()->findAll("recipeId=:recipeId",array(":recipeId"=>$recipeId));
				$ingredients =[];
				foreach ($RecipeIngredientModel as $key => $value) {
					$JSONIngredient = json_encode(array('ingredient'=>$value->ingredients));
 					array_push($ingredients, $JSONIngredient);
				}

				$JSONCom = json_encode(array('recipeId'=>$num->recipeId,'title'=>$num->title,
					'ingredients'=>$ingredients,'webUrl'=>$num->webUrl,'imageUrl'=>$num->imageUrl));
				array_push($recipeJson, $JSONCom);
			}
			echo json_encode($recipeJson);
		}
	}
	public function actionRand()
	{
	    $listIndex = 10;
        if(isset($_GET['indexNum']))
        {
          $listIndex = intval($_GET['indexNum']);
        }
		$sqlStatement = "select recipeId from Recipe order by RAND() limit ".$listIndex;
		$list= Yii::app()->db->createCommand($sqlStatement)->queryAll();
		$recipeJson =[];
		for($i=0; $i<sizeof($list); $i++)
		{
			// echo $list[$i]['recipeId'];
			$sqlNewStatement = "select ingredients from RecipeIngredient where recipeId ='".$list[$i]['recipeId']."'";
		    // echo $sqlNewStatement;
		    $ingredientList= Yii::app()->db->createCommand($sqlNewStatement)->queryAll();
		    // echo "$key = $val\n";
			$RecipeModel = Recipe::model()->find("recipeId=:recipeId",array(":recipeId"=>$list[$i]['recipeId']));
			$JSONCom = json_encode(array('recipeId'=>$list[$i]['recipeId'],'title'=>$RecipeModel->title,
			'ingredients'=>$ingredientList,'webUrl'=>$RecipeModel->webUrl,'imageUrl'=>$RecipeModel->imageUrl));
			array_push($recipeJson, $JSONCom);
		}
		echo json_encode($recipeJson);


	}
	public function actionRecipe()
	{
		$recipeJson =[];
		if(isset($_GET['ingredients']))
		{
			$recipeList = array();
			$ingredients = $_GET['ingredients'];
			$iOptions = split(',', $ingredients);
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
					$JSONCom = json_encode(array('recipeId'=>$val['recipeId'],'title'=>$RecipeModel->title,
					'webUrl'=>$RecipeModel->webUrl,'imageUrl'=>$RecipeModel->imageUrl));
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
		    $validResult = [];
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
               $JSONresult = json_encode(array('recipeId'=>$list[$j]['recipeId']));
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
    	$recipeDetail = [];
    	if(isset($_GET['recipeId']))
    	{
    		$recipeId = $_GET['recipeId'];
    		$recipeStatement = "select * from Recipe where recipeId='".$recipeId."'";
    		$recipeResult = Yii::app()->db->createCommand($recipeStatement)->queryAll();
    		// echo json_encode($recipeResult);
			$ingredientStatement = "select ingredients from RecipeIngredient where recipeId ='".$recipeId."'";
		    $ingredientList= Yii::app()->db->createCommand($ingredientStatement)->queryAll();
			$recipeDetail = json_encode(array('recipeId'=>$recipeId,'title'=>$recipeResult[0]['title'],
			'webUrl'=>$recipeResult[0]['webUrl'],'imageUrl'=>$recipeResult[0]['imageUrl'],
			'ingredients'=>$ingredientList));		
    	}
    	 echo json_encode($recipeDetail);
    }

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}