<?php

namespace BMLaguna\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use BMLaguna\Miembro;
use BMLaguna\Equipo;
use BMLaguna\Categoria;
use BMLaguna\Temporada;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
/*         $miembros = Miembro::whereNull('f_baja')->get();
        $nMiembros = $miembros->count();
 */ 
        // $nMiembros = Miembro::whereNull('f_baja')->count();
        /* $equipos = Equipo::withCount(['jugadores', 'oficiales'])->get(); */
        $categorias = Categoria::orderBy('orden')->get();
        $temporada = Temporada::actual();

        //$preinscritos = Miembro::inscritos();
        
        //$nPreinscritos = $preinscritos->distinct()->count();
        $nPreinscritos = Miembro::nInscritos();

/*         $nProbados = DB::table('equipacione_miembro_talla')
                     ->join('equipaciones', 'equipacione_id', '=', 'equipaciones.id')
                     ->select('equipacione_miembro_talla.equipacione_id')
                     ->groupBy('equipacione_id')->count();


        $estadoDOC = ['DNICaducado' => 0, 'DNIActivo' => 0, 'sinDNI' => 0];
 
        foreach ($miembros as $preinscrito){
            if ($preinscrito->preinscrito()){
                $DNIfs = $preinscrito->estadoNIF();
                if ($DNIfs == 'activo'){
                    $estadoDOC['DNIActivo'] += 1;
                }
                elseif ($DNIfs == 'caducado'){
                    $estadoDOC['DNICaducado'] += 1;
                }
                else{
                    $estadoDOC['sinDNI'] += 1;
                }
            }
        }
    */
        // dd($estadoDOC);

        //return view('home', compact('nMiembros', 'equipos','categorias', 'temporada', 'nPreinscritos', 'nProbados', 'estadoDOC'));
        return view('home', compact('categorias', 'nPreinscritos'));
    }
}
