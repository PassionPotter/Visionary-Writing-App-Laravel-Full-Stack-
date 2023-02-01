<?PHP 
use Illuminate\Support\Facades\Route;

function getCurrentPageName() {
    $pageNames = [
        'admin-home' => 'Dashboard',
        'import' => 'Import',
        'book/create' => 'Create Book',
        '/monthlyearning' => 'Monthly Earnings',
        'payment/form' => 'Payment',
        'books' => 'Books',
        'comments' => 'Comments',
        'admin.comments.edit' => 'Edit Comment',
        'admin.comments.reply' => 'Reply Comment',
        'admin.comments.reply.create' => 'Create Reply',
        'admin.comments.update' => 'Update Comment',
        'admin.comments.delete' => 'Delete Comment',
        'trashed.books' => 'Trashed Books',
        'restore.trashed.book' => 'Restore Trashed',
        'delete.trashed.book' => 'Delete Trashed Book',
        'edit.book' => 'Edit Book',
        'book/update' => 'Update Book',
        'chapter/create' => 'Create Chapter',
        '/payment/details' => 'Earnings',
        'user.profile' => 'Edit Profile',
        'BookChapters' => 'Book Chapters',
        'read.chapter' => 'Read Chapter',
        'edit.chapter' => 'Edit Chapter',
        '/bank/details' => 'Bank Details',
        'bank/edit' => 'Edit Bank Details',
    ];
    return isset($pageNames[Route::currentRouteName()]) ? $pageNames[Route::currentRouteName()] :  Route::currentRouteName();
}

?>
<div id="wrapper">
    <!-- Navigation -->
    <nav class="top1 navbar navbar-default navbar-static-top <?= Route::currentRouteName(); ?>" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle hidden-xs hide-mobile-important" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand hidden-xs" href="/">Visionary Writings</a>
            <a class="navbar-brand hidden-md hidden-lg" href="{{route('admin-home')}}"><?= getCurrentPageName() ?></a>
            <?PHP 
                if (Route::currentRouteName() != 'admin-home') {
            ?>
            <a class="back-dash-link hidden-md hidden-lg" href="{{route('admin-home')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Dashboard</a>
            <?PHP } ?>
        </div>
        <!-- /.navbar-header -->
        <ul class="nav navbar-nav navbar-right">
            <li class="hidden-md hidden-lg">
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
            <li class="profile-image hidden-xs">
                
                <!-- <ul class="dropdown-menu">
                    <li class="dropdown-menu-header text-center">
                        <strong>Account</strong>
                    </li>
                    <li><a href="#"><i class="fa fa-comments"></i> Comments <span
                                class="label label-warning">42</span></a></li>
                    <li class="dropdown-menu-header text-center">
                        <strong>Settings</strong>
                    </li>
                    <li class="m_2"><a href="#"><i class="fa fa-user"></i> Profile</a></li>
                    @if(Auth::user()->admin)
                    <li class="m_2"><a href="#"><i class="fa fa-wrench"></i> Settings</a></li>
                    @endif
                    <li class="divider"></li>
                    <li class="divider"></li>

                    <li class="m_2">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-lock"></i>
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul> -->
            </li>
        </ul>