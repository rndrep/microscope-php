<li class="list-group-item">Породообразующие минералы:
@foreach($formingMinerals as $item)
    @if($item['link'])
        <a class="card-list__link" href="{{$item['link']}}">{{$item['name']}}</a>
    @else
        <a class="card-list__link card-list__link_disabled">{{$item['name']}}</a>
    @endif @if(!$loop->last){{','}}@endif
@endforeach
</li>

<li class="list-group-item">Вторичные минералы:
@foreach($secondMinerals as $item)
    @if($item['link'])
        <a class="card-list__link" href="{{$item['link']}}">{{$item['name']}}</a>
    @else
        <a class="card-list__link card-list__link_disabled">{{$item['name']}}</a>
    @endif @if(!$loop->last){{','}}@endif
@endforeach
</li>

<li class="list-group-item">Акцессорные минералы:
@foreach($accessoryMinerals as $item)
    @if($item['link'])
        <a class="card-list__link" href="{{$item['link']}}">{{$item['name']}}</a>
    @else
        <a class="card-list__link card-list__link_disabled">{{$item['name']}}</a>
    @endif @if(!$loop->last){{','}}@endif
@endforeach
</li>
