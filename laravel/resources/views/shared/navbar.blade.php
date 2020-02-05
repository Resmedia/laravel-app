<nav class="navbar navbar-dark bg-dark fixed-top navbar-expand-md">
    <div class="container">
        <a href="/" class="navbar-brand">
            Laravel Resmedia
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                @foreach(\App\Models\Menu::all() as $menu)
                    <li class="nav-item active">
                        <a class="nav-link" href="{{$menu->url}}">{{$menu->name}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>

