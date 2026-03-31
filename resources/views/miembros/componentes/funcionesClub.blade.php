<div class="row card-panel">
    <div class="section row">
        <span class="card-title col s12"><strong class="flow-text">Funciones en el club</strong></span>
    </div>

    <div class="row section">
        <div class="col s12">
            <span class="grey-text text-darken-1">Puedes marcar varias a la vez; no son excluyentes.</span>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m4">
            <p>
                <label>
                    <input type="checkbox" name="func_club_familiar" id="func_club_familiar" value="1" class="filled-in"
                        {{ !empty($checksFuncionesClub['familiar']) ? 'checked' : '' }} />
                    <span>Familiar</span>
                </label>
            </p>
        </div>
        <div class="col s12 m4">
            <p>
                <label>
                    <input type="checkbox" name="func_club_jugador" id="func_club_jugador" value="1" class="filled-in"
                        {{ !empty($checksFuncionesClub['jugador']) ? 'checked' : '' }} />
                    <span>Jugador</span>
                </label>
            </p>
        </div>
        <div class="col s12 m4">
            <p>
                <label>
                    <input type="checkbox" name="func_club_tecnico" id="func_club_tecnico" value="1" class="filled-in"
                        {{ !empty($checksFuncionesClub['tecnico']) ? 'checked' : '' }} />
                    <span>Técnico</span>
                </label>
            </p>
        </div>
    </div>
</div>
