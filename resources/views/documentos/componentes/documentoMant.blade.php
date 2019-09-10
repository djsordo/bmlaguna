<div class="row card-panel z-depth-2">
        <div class="input-field col s5">
            <input type="text" id="descripcion" name="descripcion" class="validate" value="{{(!is_null($documento)) ? $documento->descripcion : ' ' }}" required>
            <label for="descripcion">Descripcion del documento:</label>
        </div>
        <div class="input-field col s4">
                <input type="text" id="tipo" name="tipo" class="validate" value="{{(!is_null($documento)) ? $documento->tipo : ' '}}" required>
                <label for="marca">Tipo:</label>
        </div>
    
        <div class="input-field col s4">
                <input type="text" id="subTipo" name="subTipo" class="validate" value="{{(!is_null($documento)) ? $documento->subTipo : ' '}}" required>
                <label for="marca">Subtipo:</label>
        </div>
    
        <div class="col s12">
            <button class="btn red  right" type="submit">Guardar</button>
        </div>
    </div>
    
