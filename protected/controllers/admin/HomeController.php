<?

class HomeController extends CAdminController
{
	public function actionIndex()
	{
		$this->redirect('/admin/movies');
	}

	
}