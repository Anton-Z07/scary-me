<?

class MovieController extends Controller
{
	public function actionIndex()
	{
		$this->description = 'Random horror movie';
		$this->pageTitle = $this->description;
		$this->keywords = 'horror movies,random horror movie';
		$this->render('index');
	}

	public function actionGet()
	{
		$movie = Movie::random(U::gp('from',1900), U::gp('to',2100));
		$data = ['name'=>$movie->name,'director'=>$movie->director,'release_year'=>$movie->release_year,'image'=>$movie->image,'imdb_link'=>$movie->imdb_link];
		echo json_encode($data);
	}
}