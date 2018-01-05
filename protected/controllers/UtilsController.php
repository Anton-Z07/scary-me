<?

class UtilsController extends Controller
{
	public function actionGenerateSitemap()
	{
		function add($link, $date, $main, &$res)
        {
        	$res[] = '<url>';
    		$res[] = "<loc>http://canyouscare.me".$link."</loc>";
    		$res[] = '<lastmod>'.$date.'</lastmod>';
    		if ($main) $res[] = '<changefreq>daily</changefreq>';
    		$res[] = '<priority>'.($main ? 1 : 0.5).'</priority>';
    		$res[] = '</url>';
        }

        $res = [];
        add('',date('Y-m-d'),true,$res);
        $posts = Post::findMany(['posted'=>1]);
        Settings::SetEncoded('post_count', count($posts));
        foreach ($posts as $post)
        	add('/p/'.$post->url,date('Y-m-d', strtotime($post->date)),false,$res);
        add('/random-horror-movie','2016-05-22',false,$res);
		$res = array_merge(['<?xml version="1.0" encoding="UTF-8"?>', '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'], $res, ['</urlset>']);

		$f = fopen($_SERVER['DOCUMENT_ROOT']."/sitemap.xml", 'w');
		fwrite($f,  implode("\n", $res));
		fclose($f);
	}
}