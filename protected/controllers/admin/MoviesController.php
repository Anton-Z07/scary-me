<?

class MoviesController extends CAdminController
{
	public function actionIndex()
	{
		$movies = Movie::model()->findAll(['order'=>'id desc']);
		$this->render('index', ['movies'=>$movies]);
	}

	public function actionAdd()
	{
		$imdb_link = U::gp('imdb');
		$image_link = U::gp('image');
		if (!$image_link || !$imdb_link) return;
		$imdb = file_get_contents($imdb_link);

		$movie = new Movie;
		$title = $this->parse($imdb, '<meta property=\'og:title\' content="', '" />');
		list($movie->name, $movie->release_year) = explode('(', $title);
		$movie->name = trim($movie->name);
		$movie->release_year = trim(str_replace(')','',$movie->release_year));
		$movie->director = $this->parse($imdb, '<h4 class="inline">Director:</h4>', '</span></a>');
		list($_, $movie->director) = explode('itemprop="name">', $movie->director);

		if ($movie->isDouble()) $this->redirect('/admin/movies?msg=Double');

		$movie_name = strtolower( str_replace([' ','`',"'",'"'], ['-','','',''], $movie->name) ) . '-' . $movie->release_year . '.jpg';
		$image_name = '/images/movies/'.$movie_name;

		$movie->image = $image_name;
		$movie->imdb_link = $imdb_link;
		if (!$movie->save()) $this->redirect('/admin/movies?msg=Error');

		list($width, $height) = getimagesize($image_link);
		$percent = 800 / max($width, $height);
		if ($percent > 1) $percent = 1;
		$new_width = $width * $percent;
		$new_height = $height * $percent;

		$image_p = imagecreatetruecolor($new_width, $new_height);
		$image = imagecreatefromjpeg($image_link);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

		imagejpeg($image_p, $_SERVER['DOCUMENT_ROOT'].$image_name, 80);
		$this->redirect('/admin/movies?msg=Success');
	}

	private function parse($str, $from, $to)
	{
		$p = strpos($str, $from);
		$p2 = strpos($str, $to, $p + strlen($p));
		if (!$p || !$p2) return false;
		$p += strlen($from);
		return substr($str, $p, $p2 - $p);
	}
}