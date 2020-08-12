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

    {{-- <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
