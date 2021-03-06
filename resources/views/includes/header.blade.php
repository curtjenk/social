<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('home') }}">
                     <img alt="Brand" src="{{ asset('src/img/social-media-image.jpg') }}" class="img-responsive" style="max-height:400%; border-radius:25px">
                     <h6 class="text">Home</h6>
                </a>
            </div>
            <div class="welcome text-center">
                <!--check if a user is logged-in-->
                @if(Auth::check())
                {{{ isset(Auth::user()->first_name) ? Auth::user()->first_name : Auth::user()->email }}}
                @endif
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ route('account') }}">Account</a></li>
                    <li><a href="{{ route('signout') }}">Logout</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
</header>
