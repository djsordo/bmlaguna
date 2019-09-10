@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="materialert error">
            <div class="material-icons">error_outline</div>
            {{ $error }}
        </div>          
    @endforeach
@endif
