<?php

class CAdminController extends Controller
{
    public $breadcrumbs = array(array('name' => 'Главная', 'url' => '/admin'));
    public $layout = 'admin';
    
	public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
            	'users'=>array('?')
            ),
            array('deny',
                'users'=>array('@'),
                'expression'=>'$user->isGuest || $user->type !== "admin"',
            ),
        );
    }
}