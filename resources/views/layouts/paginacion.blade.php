@php
    $currentPage = $elementos->currentPage(); //Página actual
    $maxPages = $currentPage + 3; //Máxima numeración de páginas
    $firstPage = 1; //primera página
    $lastPage = $elementos->lastPage(); //última página
    $nextPage = $currentPage+1; //Siguiente página
    $forwardPage = $currentPage-1; //Página anterior
    $elementos->setPath($path);
    
@endphp

<ul class="pagination">
    <!-- Botón para navegar a la primera página -->
    <li class="@if($currentPage==$firstPage){{'disabled'}}@endif">
        <a href="@if($currentPage>1){{$elementos->url($firstPage)}}@else{{'#'}}@endif"><i class="material-icons">first_page</i></a>
    </li>
    <!-- Botón para navegar a la página anterior -->
    <li class="@if($currentPage==$firstPage){{'disabled'}}@endif">
        <a href="@if($currentPage>1){{$elementos->url($forwardPage)}}@else{{'#'}}@endif"><i class="material-icons">chevron_left</i></a>
    </li>
    <!-- Mostrar la numeración de páginas, partiendo de la página actual hasta el máximo definido en $maxPages -->
    @for($x=$currentPage;$x<$maxPages;$x++)
        @if($x <= $lastPage)
        <li class="waves-effect @if($x==$currentPage){{'active'}}@endif">
                <a href="{{$elementos->url($x)}}">{{$x}}</a>
        </li>
        @endif
    @endfor
    <!-- Botón para navegar a la pagina siguiente -->
    <li class="@if($currentPage==$lastPage){{'disabled'}}@endif">
        <a href="@if($currentPage<$lastPage){{$elementos->url($nextPage)}}@else{{'#'}}@endif"><i class="material-icons">chevron_right</i></a>
    </li>
    <!-- Botón para navegar a la última página -->
    <li class="@if($currentPage==$lastPage){{'disabled'}}@endif">
        <a href="@if($currentPage<$lastPage){{$elementos->url($lastPage)}}@else{{'#'}}@endif"><i class="material-icons">last_page</i></a>
    </li>
</ul>