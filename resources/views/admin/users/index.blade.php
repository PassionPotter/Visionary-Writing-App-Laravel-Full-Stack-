@extends('admin.layouts.master')
@section('content')
<script type="text/javascript">
   function changeInAction(){
        $("#applyBtn").toggle();
    }
    function selecteRowChecked(){
        var selectedOption = $("#selectedAction option:selected").val();
        var result = confirm("Want to proceed with "+selectedOption+" Action?");
        var userids = [];
        if (result) {
           $('input[name="rowChecked"]:checked').each(function(i) {
              userids[i] = this.value;
              
          });
           var token = '<?php echo csrf_token(); ?>';
           $.ajax({
             method: "POST",
             url: "<?php echo url('/'); ?>/admin/trash.users",
             data: { selectedOption:selectedOption, userids: userids, _token: token}
           })
             .done(function( msg ) {
               location.reload();
             });
       }
   }
</script>
  <div id="page-wrapper">
      @include('admin.errors.errors')
    <div class="graphs">
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            Users
            <div class="pull-right col-md-3">
                </form>
                <form class="input-group" action="" method="get">
                    <input type="text" value="<?= $searchTerm; ?>" name="search_text" class="form-control" />
                    <span class="input-group-btn">
                        <input type="submit" name="search" class="btn btn-primary" />
                        <input type="submit" value="Reset" name="search" class="btn btn-secondary" />
                    </span>
                </form>
            </div>
        </div>

        <div class="panel-body">
            <div class="table-responsive" data-pattern="priority-columns">
            <table class="table table-hover">
                <div>
                                <select id="selectedAction" onchange="changeInAction()">
                                    <option>Apply Action</option>
                                    <option value="Trash">Trash</option>
                                    <option value="Deactivate">Deactivate</option>
                                </select>
                                
                                <button class="btn" id="applyBtn" style="display: none;" onclick="selecteRowChecked()">
                                    Apply
                                </button>
                            </div>
                <thead>
                    <th></th>
                    <th>
                        Images
                    </th>
                    <th>
                        Name
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Balance
                    </th>
                    <th>
                        No# of books
                    </th>
                    <th>
                        permissions
                    </th>
                    <th>
                        Operation
                    </th>
                    <th>
                        Edit
                    </th>
                    <th>
                        delete
                    </th>
                </thead>
                <tbody>
               
                @if($users->count() >0)
                
                 @foreach($users as $user)
                 <?php if($user->reader == 1){
                  continue;
                 }?>
                    <tr>
                        <td>
                                        <input type="checkbox" name="rowChecked" value="{{$user->id}}" multiple >
                                    </td>  
                        <td><?php if(isset($user->profile->avatar)){?>
                          <a href="{{route('author/author_id',['id' => $user->id])}}" target="blank">
                            <img src="{{asset('public/books/avatars/'.$user->profile->avatar)}}" alt="{{$user->name}}" class="img-circle" width="60px" height="60px" style="border-radius:50px">
                            </a>
                        <?php }else{?>
                            <img src="{{asset('books/avatars/avatar.png')}}" alt="{{$user->name}}" class="img-circle" width="60px" height="60px" style="border-radius:50px">
                            <?php

                        }?>
                        </td>
                         <td>
                            {{$user->name}}
                        </td>
                         <td>
                            {{$user->email}}
                        </td>
                        <td>
                            R{{number_format($user->amount, 2)}}
                        </td>
                         <td>

                             <?php 
                            $count = DB::table('book')
                            ->select(DB::raw('count(*) as count'))
                            ->where('user_id', '=', $user->id)
                            ->where('status', '=', 1)
                            ->first()
                            ->count;
                            ?>

                            <?php echo $count; ?>
                            <!-- {{$user->books->count()}} -->

                            @if($user->verified == 0)
                            <a class="btn" href="{{route('author/books/author_id',['author' =>$user->name, 'id' => $user->id])}}">
                                Review
                            </a>
                            @endif
                        </td>
                         <td>
                            @if($user->admin && $user->email != 'visionarywritings@gmail.com')
                                 <a href="{{route('user.not-admin',['id' =>$user->id])}}" class="btn btn-xs btn-danger">Remove admin privilage</a>
                            @elseif($user->email == 'visionarywritings@gmail.com')
                                Super Admin
                            @else
                                <a href="{{route('user.admin',['id' =>$user->id])}}" class="btn btn-xs btn-success">Make admin</a>
                            @endif
                        </td>
                        <td>
                           @if(!$user->admin || ($user->admin == 1 && $user->email != 'visionarywritings@gmail.com'))
                           <a href="{{route('user.deactivate',['id' =>$user->id])}}" class="btn btn-xs btn-success">Deactivate</a>
                           <a href="{{route('user.login',['id' =>$user->id])}}" class="btn btn-xs btn-info">Login</a>
                           @endif
                        </td>
                        <td>
                         @if(Auth::user()->id !== $user->id || $user->email == 'visionarywritings@gmail.com')
                           <a href="{{route('user.edit',['id' =>$user->id])}}" class="btn btn-xs btn-info">Edit</a>
                           
                        @endif
                        </td>
                         <td>
                         @if($user->active == 0)
                           <a href="{{route('user.delete',['id' =>$user->id])}}" class="btn btn-xs btn-danger">delete</a>
                         @endif
                        </td>
                    </tr>
                @endforeach
                @else
                <tr>
                    <th colspan="5" class="text-center">No users</th>
                </tr>
                @endif
                </tbody>
            </table>
        </div>
                {{ $users->links() }}
        </div>
    </div>
    @endsection