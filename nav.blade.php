<div class="navbar-default sidebar" role="navigation">
    @if(Auth::check())
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="#">
                    <span class="li-icon">
                        <i class="fa fa-user fa-fw nav_icon"></i>
                    </span>
                    <span class="li-title">
                        {{Auth::user()->name}}
                    </span>
                </a>
            </li>
             <li>
                <a href="{{route('admin-home')}}">
                    <span class="li-icon">
                        <i class="fa fa-dashboard fa-fw nav_icon"></i>
                    </span>
                    <span class="li-title">
                        Dashboard
                    </span>
                </a>
            </li>  
            @if(Auth::user()->reader == 1)
            <!-- <li>
                <a href="{{route('admin-home')}}">
                    <span class="li-icon">
                        <i class="fa fa-dashboard fa-fw nav_icon"></i>
                    </span>
                    <span class="li-title">
                        Dashboard
                    </span>
                </a>
            </li> -->   
            <li>
                <a href="{{route('comments')}}">
                    <span class="li-icon">
                        <i class="fa fa-comments-o fa-fw nav_icon" aria-hidden="true"></i>
                    </span>
                    <span class="li-title">
                        Comments
                    </span>
                </a>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="{{route('user.profile')}}">
                    <span class="li-icon">
                        <i class="fa fa-pencil-square fa-fw nav_icon" aria-hidden="true"></i>
                    </span>
                    <span class="li-title">
                        Edit Profile
                    </span>
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="li-icon">
                        <i class="fa fa-sign-out fa-fw nav_icon"></i>
                    </span>
                    <span class="li-title">
                        {{ __('Logout') }}
                    </span>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </a>
            </li>
            @else
            <li>
                <a href="{{route('author/books/author_id',['author' =>Auth::user()->name, 'id' => Auth::user()->id])}}"
                    target="_blank">
                    <span class="li-icon">
                        <i class="fa fa-home nav_icon"></i>
                    </span>
                    <span class="li-title">
                        Visit Profile
                    </span>
                </a>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="{{route('book/create')}}">
                    <span class="li-icon">
                        <i class="fa fa-book  fa-fw nav_icon"></i>
                    </span>
                    <span class="li-title">
                        New Book
                    </span>
                </a>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="{{route('chapter/create')}}">
                    <span class="li-icon">
                        <i class="fa fa-plus fa-fw nav_icon" aria-hidden="true"></i>
                    </span>
                    <span class="li-title">
                        New Chapter
                    </span>
                </a>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="{{route('draft/books')}}">
                    <span class="li-icon">
                        <i class="fa fa-pencil fa-fw nav_icon"></i>
                    </span>
                    <span class="li-title">
                        View Draft
                    </span>
                </a>
            </li>
            <li>
                <a href="{{route('books')}}">
                    <span class="li-icon">
                        <i class="fa fa-book fa-fw nav_icon"></i>
                    </span>
                    <span class="li-title">
                        Books
                    </span>
                </a>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="{{route('comments')}}">
                    <span class="li-icon">
                        <i class="fa fa-comments-o fa-fw nav_icon" aria-hidden="true"></i>
                    </span>
                    <span class="li-title">
                        Comments
                    </span>
                </a>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="{{route('trashed.books')}}">
                    <span class="li-icon">
                        <i class="fa fa-trash-o fa-fw nav_icon" aria-hidden="true"></i>
                    </span>
                    <span class="li-title">
                        Trashed Books
                    </span>
                </a>
                <!-- /.nav-second-level -->
            </li>
            @if(Auth::user()->admin)
            <li>
                <a href="{{route('readers')}}">
                    <span class="li-icon">
                        <i class="fa fa-users fa-fw nav_icon" aria-hidden="true"></i>
                    </span>
                    <span class="li-title">
                        Readers
                    </span>

                </a>
            </li>
            <li>
                <a href="{{route('users')}}">
                    <span class="li-icon">
                        <i class="fa fa-users fa-fw nav_icon" aria-hidden="true"></i>
                    </span>
                    <span class="li-title">
                        Users
                    </span>

                </a>
            </li>
            <li>
                <a href="{{route('user.create')}}">
                    <span class="li-icon">
                        <i class="fa fa-plus fa-fw nav_icon" aria-hidden="true"></i>
                    </span>
                    <span class="li-title">
                        Add Users
                    </span>
                </a>
            </li>
            <li>
                <a href="{{route('user.registered')}}">
                    <span class="li-icon">
                        <i class="fa fa-user fa-fw nav_icon" aria-hidden="true"></i>
                    </span>
                    <span class="li-title">
                        New Users
                    </span>
                </a>

            </li>
            @endif
            <li>
                <a href="{{route('user.profile')}}">
                    <span class="li-icon">
                        <i class="fa fa-pencil-square fa-fw nav_icon" aria-hidden="true"></i>
                    </span>
                    <span class="li-title">
                        Edit Profile
                    </span>
                </a>
            </li>
            <li>
                <a href="{{route('/monthlyearning')}}">
                    <span class="li-icon">
                        <i class="fa fa-money fa-fw nav_icon" aria-hidden="true"></i>
                    </span>
                    <span class="li-title">
                        Monthly Earnings
                    </span>
                </a>
            </li>
            @if(Auth::user()->admin)
            <li>
                <a href="{{route('ads')}}">
                    <span class="li-icon">
                        <i class="fa fa-globe fa-fw nav_icon" aria-hidden="true"></i>
                    </span>
                    <span class="li-title">
                        Ads
                    </span>
                </a>
            </li>
            <li>
                <a href="{{route('ad-new')}}">
                    <span class="li-icon">
                        <i class="fa fa-plus fa-fw nav_icon" aria-hidden="true"></i>
                    </span>
                    <span class="li-title">
                        New ad
                    </span>
                </a>
            </li>
            <li>
                <a href="{{route('ad-restrict')}}">
                    <span class="li-icon">
                        <i class="fa fa-ban fa-fw nav_icon" aria-hidden="true"></i>
                    </span>
                    <span class="li-title">
                        Restrict ads
                    </span>
                </a>
            </li>

            <li>
                <a href="{{route('payment/form')}}">
                    <span class="li-icon">
                        <i class="fa fa-money fa-fw nav_icon" aria-hidden="true"></i>
                    </span>
                    <span class="li-title">
                        Pay Money
                    </span>
                </a>
            </li>
            <li>
                <a href="{{route('smtpemail')}}">
                    <span class="li-icon">
                        <i class="fa fa-envelope fa-fw nav_icon" aria-hidden="true"></i>
                    </span>
                    <span class="li-title">
                        SMTP Email
                    </span>
                </a>
            </li>
             <li>
                <a href="{{route('sendmail1')}}">
                    <span class="li-icon">
                        <i class="fa fa-envelope fa-fw nav_icon" aria-hidden="true"></i>
                    </span>
                    <span class="li-title">
                        Send Email
                    </span>
                </a>
            </li>
            @else

            <li>
                <a href="{{route('/bank/details')}}">
                    <span class="li-icon">
                        <i class="fa fa-info fa-fw nav_icon" aria-hidden="true"></i>
                    </span>
                    <span class="li-title">
                        Bank Details
                    </span>
                </a>
            </li>


            @endif
            <li>
                <a href="{{route('/payment/details')}}">
                    <span class="li-icon">
                        <i class="fa fa-credit-card fa-fw nav_icon" aria-hidden="true"></i>
                    </span>
                    <span class="li-title">
                        Payment Details
                    </span>
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="li-icon">
                        <i class="fa fa-sign-out fa-fw nav_icon"></i>
                    </span>
                    <span class="li-title">
                        {{ __('Logout') }}
                    </span>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </a>
            </li>
            
            @endif
            
        </ul>
    </div>
    @endif
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
</nav>
