<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class AppController extends Controller{
	public $params = null;


	public function beforeAction($action){
		$this->params = Yii::$app->params;
		parent::beforeAction($action);
		return true;
	}
}