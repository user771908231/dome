<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Wanglelecc\Laracms\Models\Article;
use Wanglelecc\Laracms\Handlers\CategoryHandler;
use Wanglelecc\Laracms\Models\Category;

class NewsController extends Controller
{
    //
    public function Index(Article $article,Request $request,CategoryHandler $categoryHandler)
    {
        $this->authorize('index', $article);

        // 分类过滤
        if(($category_id = $request->category ?? 0) && ($category = Category::find($category_id))){
            $article = $category->articles();
        }

        $article = $article->with(['categorys']);

        // 关键字过滤
        if($keyword = $request->keyword ?? ''){
            $article->where('title', 'like', "%{$keyword}%");
        }

        // 开始时间过滤
        if($begin_time = $request->begin_time ?? ''){
            $article = $article->where('created_at','>',$begin_time);
        }

        // 结束时间过滤
        if($end_time = $request->end_time ?? ''){
            $article = $article->where('created_at','<',$end_time);
        }

        $articles = $article->ordered()->recent()->paginate(config('administrator.paginate.limit'));

        // 修正页码
        if( $articles->count() < 1 && $articles->lastPage() > 1 ){
            return redirect($articles->url($articles->lastPage()));
        }

        // 文章分类
        $category = $categoryHandler->select($categoryHandler->getCategorys('article'));
//        return backend_view('article.index', compact('articles', 'category', 'category_id'));
        return view('frontend.default.news', compact('articles', 'category', 'category_id'));
    }
}
