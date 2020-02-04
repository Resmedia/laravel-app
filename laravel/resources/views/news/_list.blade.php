<div class="card-columns">
    @each('news/_show', $news, 'news', 'news/_empty')
</div>

<div class="d-flex justify-content-center">
    {{ $news->links() }}
</div>
