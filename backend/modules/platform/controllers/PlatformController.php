<?php

namespace backend\modules\platform\controllers;

use yii\web\Controller;
use backend\controllers\BaseController;

/**
 * Default controller for the `api` module
 */
class PlatformController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index');
    }
    public function actionNode()
    {

        return $this->render('index');
    }
}
