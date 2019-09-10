<div class="section">
    <div class="row valign-wrapper">
    <form class="col s11 valign-wrapper">
        {{-- <div class="col s3">
            <div class="switch">
                <label>
                    Normal
                    <input type="checkbox" name="vista" {{ $vista == 'on' ? 'checked' : '' }} onChange="this.form.submit()" />
                    <span class="lever"></span>
                    Compacta
                </label>
            </div>
        </div> --}}

        <div class="col s8">
            <nav class="red accent-3">
                <div class="nav-wrapper">
                    <div class="input-field">
                        <input id="searchNombre" type="search" placeholder="Búsqueda por nombre, dorsal (d#d) o número de socio (s#s)" name="nombreBusqueda" value="{{$textoBusqueda}}">
                        <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                        <i class="material-icons">close</i>
                    </div>
                </div>
            </nav>
        </div>
    </form>
    <div class="col s1 center"><a href="/export-miembros"><img src="/images/excel.png" width="38px"></a></div>
    <div class="col s1 center">
        <a href="{{ route('miembros.create') }}" class="btn-floating red waves-effect"><i class="material-icons">add</i></a> 
    </div>
    </div>    

</div>