<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Book;
use App\Comment;
use App\Chapter;
use App\RWords;
use App\User;
use Auth;
use Excel;
use Session;
class CommentController extends Controller
{
    /**/
    public function index(Request $req)
    {
        if(Auth::user()->admin == 1)
        {
            if(isset($req->status))
            {
                $comments = Comment::where('status',$req->status)->orderBy('updated_at','desc')->paginate(20);
            }
            else
            {
                $comments = Comment::orderBy('updated_at','desc')->paginate(20);
            }
        }
        else
        {
            $book_ids = Book::where('user_id',Auth::user()->id)->pluck('id')->toArray();
            $chapter_ids = Chapter::whereIn('book_id',$book_ids)->pluck('id')->toArray();

        

            if(isset($req->status))
            {
                $comments = Comment::where('status',$req->status)
                    ->whereIn('chapter_id',$chapter_ids)
                    ->orderBy('updated_at','desc')->paginate(20);
            }
            else
            {
            // old query
            // $comments = Comment::whereIn('chapter_id',$chapter_ids)
            //     ->orderBy('updated_at','desc')->paginate(20);
            // show comment indiviual user
            $comments = Comment::orderBy('updated_at','desc')
            ->where('user_id', Auth::user()->id)
            ->paginate(20);

               
            }
        }
        //return $comments;
        return view('admin.comments.index',compact('comments'));
    }
    public function store(Request $Request)
    {
        $rules = [
            'name'=> 'required',
            'email'=> 'required'
        ];
        $customMessages = [
            'name.required' => 'name cannot be blank',
            'email.required' => 'email cannot be blank'
        ];
        $this->validate($Request, $rules, $customMessages);
        $input['user_name']=$Request->name;
        $input['user_email']=$Request->email;
        $input['user_id'] = Auth::check() ? Auth::user()->id : 0;
        $input['chapter_id'] = $Request->chapter_id;
        $input['reply_to'] = 0;
        $input['comment']=$Request->comment;
        $rwords = RWords::where('status',1)->pluck('keyword')->toArray();
        //dd($rwords);
        //dd(implode($rwords,"|"));
        $matches = array();
        $matchFound = preg_match_all('/\b(' . preg_replace('/\//','',preg_replace('#^https?://#','',implode($rwords,'|'))) . ')\b/i', $Request->comment, $matches);
        if($matchFound)
        {
            $input['status'] = 0 ;
            $input['approve']= 0 ;
        }
        else{
            $input['status'] = 1 ;
            $input['approve']= 1 ;
        }
       /* $res_words = [];
        foreach($rwords as $rword)
        {
            $res_words[] = strtolower($rword);
        }
        $is_res = 0;
        $comment_words = explode(' ',$Request->comment);
        foreach($comment_words as $word)
        {
            if(in_array(strtolower($word),$res_words))
            {
                $is_res = 1;
                break;
            }
        }
//        $input['status'] = ($is_res == 0) ? 1 : 2 ;
//        $input['approve']='1';
        $input['status'] = ($is_res == 0) ? 1 : 0 ;
        $input['approve']= ($is_res == 0) ? 1 : 0 ; */
        Comment::create($input);
        Session::flash('success','Your comment is live now');
        return redirect()->back();
    }
    public function editComment($id,$chapter_id)
    {
        if(!Auth::check())
        {
            return redirect()->to('/');
        }
        else
        {
            $comment = Comment::where('id',$id)->where('chapter_id',$chapter_id)->first();
            $chapter = Chapter::where('id',$chapter_id)->first();
            return view('frontend/edit_comment',compact('comment','chapter'));
        }
    }
    public function updateComment($id,$chapter_id,Request $req)
    {
        if(!Auth::check())
        {
            return redirect()->to('/');
        }
        else
        {
            $comment = Comment::where('id',$id)->where('chapter_id',$chapter_id)->first();
            $comment->comment = $req->comment;
            $rwords = RWords::where('status',1)->pluck('keyword')->toArray();
            //dd($rwords);
            $res_words = [];
            foreach($rwords as $rword)
            {
                $res_words[] = strtolower($rword);
            }
            $is_res = 0;
            $comment_words = explode(' ',$req->comment);
            foreach($comment_words as $word)
            {
                if(in_array(strtolower($word),$res_words))
                {
                    $is_res = 1;
                    break;
                }
            }
            if($is_res == 1)
            {
                $comment->status = 2;
            }
            $comment->save();
            Session::flash('success','Comment updated successfully');
            return redirect()->back();
        }
    }
    public function adminEditComment($id)
    {
        $comment = Comment::where('id',$id)->first();
        if(!Auth::check())
        {
            return redirect()->to('/');
        }
        else
        {
            $chapter = Chapter::where('id',$comment->chapter_id)->first();
            return view('admin.comments.edit',compact('comment','chapter'));
        }
    }
    public function adminUpdateComment($id,Request $req)
    {
        if(!Auth::check())
        {
            return redirect()->to('/');
        }
        else
        {
            $comment = Comment::find($id);
            $comment->comment = $req->comment;
            $comment->approve = $req->approve;
            $rwords = RWords::where('status',1)->pluck('keyword')->toArray();
            //dd($rwords);
            $res_words = [];
            foreach($rwords as $rword)
            {
                $res_words[] = strtolower($rword);
            }
            $is_res = 0;
            $comment_words = explode(' ',$req->comment);
            foreach($comment_words as $word)
            {
                if(in_array(strtolower($word),$res_words))
                {
                    $is_res = 1;
                    break;
                }
            }
            $comment->status = $req->status;
            if($is_res == 1)
            {
                $comment->status = 2;
            }
            $comment->save();
            Session::flash('success','Comment updated successfully');
            return redirect()->to('admin/comments');
        }
    }
    public function adminDeleteComment($id,Request $req)
    {
        if(!Auth::check())
        {
            return redirect()->to('/');
        }
        else
        {
            $comment = Comment::find($id);
            $comment->delete();
            Session::flash('success','Comment deleted successfully');
            return redirect()->back();
        }
    }
    public function adminDeleteByIds(Request $req)
    {
        $data = $req->all();
        $id ="";
        if(!Auth::check())
        {
            return redirect()->to('/');
        }
        else
        {
            switch ($data['selectedOption']) {
                case 'Active':
                    foreach ($data['comment_ids'] as $key => $value) {
                        $comment = Comment::find($value);
                        $comment->update(['status'=>1]);
                    }
                    break;

                case 'Waiting-Approval':
                    foreach ($data['comment_ids'] as $key => $value) {
                        $comment = Comment::find($value);
                        $comment->update(['status'=>2]);
                    }
                    break;

                case 'In-Active':
                     foreach ($data['comment_ids'] as $key => $value) {
                        $comment = Comment::find($value);
                        $comment->update(['status'=>0]);
                    }
                     break;   

                case 'Waiting':
                     foreach ($data['comment_ids'] as $key => $value) {
                        $comment = Comment::find($value);
                        $comment->update(['approve'=>0]);
                    }
                     break; 

                case 'Approve':
                     foreach ($data['comment_ids'] as $key => $value) {
                        $comment = Comment::find($value);
                        $comment->update(['approve'=>1]);
                    }
                     break; 

                case 'Trash':
                     foreach ($data['comment_ids'] as $key => $value) {
                        $comment = Comment::find($value);
                        $comment->delete();
                    }
                     break; 

                default:
                    echo "ERROR";
                    break;
            }
            
            Session::flash('success','Comments deleted successfully');
            return redirect()->back();
        }
    }
    public function adminReplyComment($id)
    {
        $comment = Comment::where('id',$id)->first();
        if(!Auth::check())
        {
            return redirect()->to('/');
        }
        else
        {
            $chapter = Chapter::where('id',$comment->chapter_id)->first();
            return view('admin.comments.reply',compact('comment','chapter'));
        }
    }
    public function adminCreateReplyComment($id,Request $req)
    {
        $comment = Comment::where('id',$id)->first();
        if(!Auth::check())
        {
            return redirect()->to('/');
        }
        else
        {
            $input = array();
            $input['user_name' ]= Auth::user()->name;
            $input['user_email']= Auth::user()->email;
            $input['user_id'] = Auth::user()->id;
            $input['chapter_id'] = $comment->chapter_id;
            $input['comment'] = $req->reply;
            $input['reply_to'] = $comment->id;
            $rwords = RWords::where('status',1)->pluck('keyword')->toArray();
            //dd($rwords);
            $res_words = [];
            foreach($rwords as $rword)
            {
                $res_words[] = strtolower($rword);
            }
            $is_res = 0;
            $comment_words = explode(' ',$req->comment);
            foreach($comment_words as $word)
            {
                if(in_array(strtolower($word),$res_words))
                {
                    $is_res = 1;
                    break;
                }
            }
            $input['status'] = ($is_res == 0) ? 1 : 2 ;
            Comment::create($input);
            Session::flash('success','Reply posted successfully');
            return redirect()->back();
        }
    }
}