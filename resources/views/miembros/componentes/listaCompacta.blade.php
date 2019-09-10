<ul class="collection">
    @foreach ($miembros as $miembro)
        <li class="collection-item avatar">
            @if (is_null($miembro->rutaFoto()))
                <img src="/images/sinfoto.jpg" class="circle" >
            @else
                <img src="{{'/docs/'.$miembro->rutaFoto() }}" class="circle" >
            @endif

            <span class="title">{{ $miembro->nombre . ' ' . $miembro->apellido1 . ' ' . $miembro->apellido2 }}</span>
            <p>
                @for ($i=0; $i < count($miembro->funcionesMiembro()); $i++)
                    {!! $miembro->funcionesMiembro()[$i] !!} <br>
                @endfor
            </p>

            <div class="secondary-content">
                <a href="/miembros/{{$miembro->id}}"><i class="material-icons">assignment</i></a>
                <a href="/miembros/{{$miembro->id}}/edit"><i class="material-icons">edit</i></a>
                {{-- <form action="/miembros/{{$miembro->id}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="secondary-content"><i class="material-icons">delete</i></button>   
                </form> --}}
            </div>
        </li>
    @endforeach
</ul>
