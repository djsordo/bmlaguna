<div class="row card-panel">
    <div class="section row">
        <span class="card-title col s12"><strong class="flow-text">Domicilio Postal</strong></span>
    </div>

    <div class="input-field col s12">
        <input type="text" id="domicilio" name="domicilio" class="validate" value="{{ (!is_null($miembro)) ? $miembro->domicilio : '' }}" required>
        <label for="domicilio">Domicilio:</label>
    </div>
    <div class="input-field col s5">
        <input type="text" id="localidad" name="localidad" class="validate" value="{{ (!is_null($miembro)) ? $miembro->localidad : 'Laguna de Duero' }}" required>
        <label for="localidad">Localidad:</label>
    </div>
    <div class="input-field col s5">
        <input type="text" id="provincia" name="provincia" class="validate" value="{{ (!is_null($miembro)) ? $miembro->provincia : 'Valladolid' }}" required>
        <label for="provincia">Provincia:</label>
    </div>
    <div class="input-field col s2">
        <input type="text" id="c_postal" name="c_postal" class="validate" value="{{ (!is_null($miembro)) ? $miembro->c_postal : '47140' }}">
        <label for="c_postal">Código Postal:</label>
    </div>
</div>