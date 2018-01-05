<?

class MainController extends Controller
{
	public function actionIndex()
	{
		$this->description = 'Horror stories, movies, videos and images';
		$this->pageTitle = Yii::app()->name . ' - ' . $this->description;
		$this->keywords = 'horror movies,scary movies,horror films,horror videos,horror stories,horror,scary stories,creepy';

		$total = Settings::Get('post_count');
		$page_size = 9;
		$page = U::gi('page');
		$q = new CDbCriteria;
		$q->addColumnCondition(['posted'=>1]);
		$q->order = 'date desc';
		$q->limit = $page_size;
		$q->offset = $page * $page_size;
		$posts = Post::findMany($q);
		$last_post = $q->offset + $page_size;
		$previous = $page > 0 ? $page - 1 : false;
		$next = $total > $last_post ? $page + 1 : false ;
		$prev_link = $previous === 0 ? '/' : "?page={$previous}";
		$this->render('index', ['posts'=>$posts, 'next'=>$next,'previous'=>$previous, 'prev_link'=>$prev_link]);
	}

	public function actionLogin()
	{
		if (!Yii::app()->user->isGuest)
			$this->redirect('/main/redirect');
		if (Yii::app()->request->isPostRequest)
		{
			$user = new UserIdentity(U::gp('login'), U::gp('password'));
			if ($user->authenticate())
			{
				Yii::app()->user->login($user, 3600*24*7);
				$this->redirect('/main/redirect');
			}
		}
		$this->render('login');
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionRedirect()
	{
		if (Yii::app()->user->isGuest)
			$this->redirect('/');
		if (Yii::app()->user->type == 'admin')
			$this->redirect('/admin');
		$this->redirect('/site/logout');
	}

	public function actionError()
	{
		$error=Yii::app()->errorHandler->error;
		if (!$error) return;
		if ($error['code'] == 404) { 
			$this->pageTitle = "Not found";
			$this->render('404');
		}
		else var_dump($error);
	}
}