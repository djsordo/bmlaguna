<form method="POST" action="{{ route('login') }}">
    @csrf
    <h4>{{ __('Login') }}</h4>
    <div class="row card-panel">
        <div class="input-field col s12">
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="validate" required autofocus>
            <label for="email">{{ __('Correo Electrónico') }}</label>
            @if ($errors->has('email'))
                <span class="helper-text" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="input-field col s12">
            <input id="password" type="password" name="password" class="validate" required>
            <label for="password" >{{ __('Contraseña') }}</label>
            @if ($errors->has('password'))
                <span class="helper-text" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="input-field col s12">
            <p>
                <label>
                    <input type="checkbox" class="filled-in" name="remember" id="remember">
                    <span>{{ __('Recuérdame') }}</span>
                </label>
            </p>
        </div>
        <div class="col s6">
            <button type="submit" class="btn red">
                {{ __('Login') }}
            </button>
        </div>
        <div class="col s6">
            <a href="{{ route('password.request') }}">
                {{ __('¿Olvidaste la contraseña?') }}
            </a>
        </div>
    </div>
</form>

