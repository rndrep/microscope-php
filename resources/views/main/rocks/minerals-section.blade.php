<li class="list-group-item">{{$name}}:
@foreach($items as $item)
    @if($item['link'])
        <a class="card-list__link" href="{{$item['link']}}">{{$item['name']}}</a>
    @else
        <a class="card-list__link card-list__link_disabled">{{$item['name']}}</a>
    @endif @if(!$loop->last){{','}}@endif
@endforeach
</li>
