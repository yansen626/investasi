<?php
/**
 * Created by PhpStorm.
 * User: yanse
 * Date: 27-Sep-17
 * Time: 2:14 PM
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Libs\Utilities;
use App\Models\Blog;
use App\Models\BlogReadUser;
use App\Models\BlogUrgent;
use App\Models\UserAdmin;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function BlogList($type){
        if($type==1){
            $blogDBs = Blog::where('status_id', 1)
                ->where('category_id', '<>', 5)
                ->orderByDesc('created_at')
                ->paginate(5);
        }
        else{

            $blogDBs = Blog::where('status_id', 1)
                ->where('category_id', 5)
                ->orderByDesc('created_at')
                ->paginate(5);
        }
//        $blogDBs = $blogDBs->paginate(10);
//        $blogDBs = App\Blog::paginate(10);

        $highlightBlog = array();
        foreach ($blogDBs as $blog){
            $string = Utilities::TruncateString($blog->description);

            $highlightBlog = array_add($highlightBlog,$blog->id, $string);
        }

        if($type==1){
            $recentBlogs = Blog::where('status_id', 1)
                ->where('category_id', '<>', 5)
                ->orderByDesc('created_at')
                ->take(5)
                ->get();
        }
        else{
            $recentBlogs = Blog::where('status_id', 1)
                ->orderByDesc('created_at')
                ->take(5)
                ->get();
        }

        $data = [
            'blogDBs'=>$blogDBs,
            'highlightBlog'=>$highlightBlog,
            'recentBlogs'=>$recentBlogs
        ];
        return View('frontend.show-blogs')->with($data);
    }

    public function SingleBlog($id){

        $singleBlog = Blog::find($id);
        $isUrgent = 0;
        if(auth()->check()){
            $user = Auth::user();
            $userId = $user->id;

            $urgentBlogId = BlogUrgent::select('id')->where('blog_id', $id)->first();

            if(!empty($urgentBlogId)){
                $blogReadUser = BlogReadUser::where('user_id', $userId)
                    ->where('blog_urgent_id', $urgentBlogId->id)
                    ->first();

                if($blogReadUser->status_id != 2){
                    $blogReadUser->status_id = 2;
                    $blogReadUser->save();

                    $isUrgent = 1;
                }
            }
        }
        if($singleBlog->category_id == 5){
            $recentBlogs = Blog::where('status_id', 1)
                ->where('id', '<>', $id)
                ->orderByDesc('created_at')
                ->take(5)
                ->get();
        }
        else{
            $recentBlogs = Blog::where('status_id', 1)
                ->where('category_id', '<>', 5)
                ->where('id', '<>', $id)
                ->orderByDesc('created_at')
                ->take(5)
                ->get();
        }

        if(empty($singleBlog->product_id)){
            $relatedBlogs = Blog::where('status_id', 1)
                ->where('category_id', $singleBlog->category_id)
                ->where('id', '<>', $id)
                ->orderByDesc('created_at')
                ->take(5)
                ->get();
        }
        else{
            $relatedBlogs = Blog::where('status_id', 1)
                ->where('product_id', $singleBlog->product_id)
                ->where('id', '<>', $id)
                ->orderByDesc('created_at')
                ->take(5)
                ->get();
        }


        return View('frontend.show-blog', compact('singleBlog', 'recentBlogs','relatedBlogs','isUrgent'));
    }
}