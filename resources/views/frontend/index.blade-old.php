@extends('frontend.layouts.master')
@section('content')
<!-- content -->


<div class="container" style="padding-top:40px">
<div class="row">
	<div class="col-md-12">
	<section class="blog-post">
		<a class="twitter-timeline" href="https://twitter.com/VWritings" data-height="100" data-chrome="nofooter noborders noheader transparent noscrollbar" data-tweet-limit="1">updates loading... please wait</a><script src="//platform.twitter.com/widgets.js" async="" charset="utf-8"></script>  <hr />
	</section>
	</div>
</div>
</div>
<style>

/*.book_image img {
    max-width: 100%;
    height: auto;
    margin: 0px auto;
    display: block;
    width: 54%;
}
.book_image {
    float: left;
    max-width: 260px;
    margin: 0px;
    padding: 0px;
    height: 130px;
    width: 130px;
    background: #F5F5F5 none repeat scroll 0% 0%;
    border-radius: 2px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
}*/
</style>
 <div class="container mobileview">
	
    <?php try {  //echo "<pre>"; print_r($items);exit;  ?>
          <div class="row mobileviewclass">
			  @foreach($users as $user)
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 mobiledevice">
              <section class="blog-post">
                <div class="panel panel-default">
                  <img src="{{asset('books/avatars/'.$user->profile->avatar)}}" class="img-responsive center-block" />
                  <div class="panel-body">
                    <div class="blog-post-meta">
                      <span class="badge badge-info">{{$user->name}}</span>
                      <p class="blog-post-date pull-right"><span class="glyphicon glyphicon-book"></span> {{$user->books->count()}}</p>
                    </div>
                    <div class="blog-post-content">
                      <a class="btn btn-block btn-info" href="{{route('author/books/author_id',['author' =>$user->name, 'id' => $user->id])}}">View books</a>
                    </div>
                  </div>
                </div>
                </section>
			</div>
		  @endforeach
      <?php }catch(\Exception $e) {
                                  echo "<pre>";
                                  echo $e;
                                  echo "</pre>";
                              } ?>
		  </div>
	
              {{$users->links()}}

    </div><!-- /.container -->

<!-- content -->	
@endsection