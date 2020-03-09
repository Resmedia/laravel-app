@extends('layouts.app')
@section('content')
    <main class="py-4">
        <h1>
            Вы в административной панели
        </h1>
        <a class="btn btn-success" href="{{url('/admin/news')}}">Перейти к редактированию новостей</a>
        <br/>
        <br/>
        <a class="btn btn-success" href="{{url('/admin/users')}}">Перейти к редактированию пользователей</a>
        <br/>
        <br/>
        <?php
        /**
         * I have laravel 6.18 and orchestra/parser have many
         * problems with install, then i find another solution ACFBentveld\XML\XML
         */
        use ACFBentveld\XML\XML;
        $news = XML::import('https://zsrf.ru/news/rss')->raw();
        foreach($news as $new):
        /** @var $new XML */
        $items = (object)$new;;
        ?>

        <h1>{{$items->title}}</h1>
        <br/>
        <br/>
        <div class="card-columns">
            @foreach ($items->item as $item)
                <div class="card">
                    @if($item->image)
                        <img alt="image" class="card-img-top" src="<?= $item->image ?>">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">
                            <a target="_blank" href="{{ $item->link }}">{{ $item->title }}</a>
                        </h5>
                        <div class="card-text">
                            <small class="text-muted">
                                {{ !empty($item->author) ? $item->author : '' }}
                            </small>
                        </div>
                        <div class="col-12">
                            <div class="row justify-content-between align-items-lg-center">
                                <a class="btn btn-primary" target="_blank" href="{{ $item->link  }}">Подробнее</a>
                                <small class="text-muted">{{ $item->pubDate }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <?php endforeach; ?>
        @yield('content')
    </main>
@endsection
