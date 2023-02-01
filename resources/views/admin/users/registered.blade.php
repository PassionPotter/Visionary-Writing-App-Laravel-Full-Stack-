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
             data: {selectedOption:selectedOption, userids: userids, _token: token}
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
           <p class="pull-left"> Newly registered users </P>
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
        	<div class="table-responsive">
                <div>
                                <select id="selectedAction" onchange="changeInAction()">
                                    <option>Apply Action</option>
                                    <option>Trash</option>
                                    <option value="Activate">Activate</option>
                                </select>
                                
                                <button class="btn" id="applyBtn" style="display: none;" onclick="selecteRowChecked()">
                                    Apply
                                </button>
                            </div>
            <table class="table table-hover">
                <thead>
                    <th>

                    </th>
                    <th>
                        Name
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        No# of books
                    </th>
                      <th>
                        Verified
                    </th>
                    <th>
                        Operation
                    </th>
                    <th>

                    </th>
                </thead>
                <tbody>
                @if($users->count() >0)
                 @foreach($users as $user)

                
                    <tr>
                        <td>
                                        <input type="checkbox" name="rowChecked" value="{{$user->id}}" multiple >
                                    </td>
                         <td>
                            {{$user->name}}
                        </td>
                         <td>
                            {{$user->email}}
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
                           <!--  @if($user->verified == 0)
                            <a class="btn" href="{{route('author/books/author_id',['author' =>$user->name, 'id' => $user->id])}}">
                                Review
                            </a>
                            @endif -->
                        </td>
                           <td>
                            @if($user->verified)
                            <span class="label label-success">Yes</span>
                            @else
                            <span class="label label-danger">No</span>
                             @endif
                           </td>
                         <td>
                           <a href="{{route('user.activate',['id' =>$user->id])}}" class="btn btn-xs btn-success">Activate</a>
                        </td>
                        <td>
                             <a href="{{route('author/author_id',['id' => $user->id])}}" target="blank" class="btn btn-xs btn-primary">View Profile</a>
                             <a href="{{route('user.edit',['id' =>$user->id])}}" class="btn btn-xs btn-info">Edit</a>
                             @if($user->verified == 0)
                             <a href="{{route('user.delete',['id' =>$user->id])}}" class="btn btn-xs btn-danger">Delete</a>
                             @endif
                         </td>
                    </tr>
                @endforeach
                @else
                <tr>
                    <th colspan="5" class="text-center">No newly registered users</th>
                </tr>
                @endif
                </tbody>
            </table>
            </div>
                {{ $users->links() }}
        </div>
    </div>
    @endsection