<?

class PostController extends Controller
{
	public function actionIndex($url)
	{
		$post = Post::findOne(['url'=>$url]);
		if (!$post) throw new CHttpException(404,'Post not found');
		$recommended = $post->getRecommended();
		$this->pageTitle = $post->title;
		$this->description = $post->description;
		$this->keywords = $post->keywords;
		$this->render('index', ['post'=>$post, 'recommended'=>$recommended]);
	}
}