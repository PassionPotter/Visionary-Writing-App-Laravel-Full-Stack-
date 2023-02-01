    @if($errors->any())
      <div class="alert alert-danger alert-block">
        @foreach($errors->all() as $err)
        <ul>
        <li>{{$err}}</li>
        </ul>
        @endforeach
      </div>
      @else
    @endif