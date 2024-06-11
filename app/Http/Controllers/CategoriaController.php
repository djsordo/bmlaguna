<?php

namespace BMLaguna\Http\Controllers;

use BMLaguna\Categoria;
use Illuminate\Http\Request;
use BMLaguna\Http\Requests\StoreCategoriaRequest;
use BMLaguna\Http\Requests\UpdateCategoriaRequest;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$categorias = Categoria::all();
        //$cuenta = Categoria::count();
        $categorias = Categoria::orderBy('edad', 'ASC')->paginate(10);

        return view('categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoriaRequest $request)
    {
        $categoria = new Categoria();

        $categoria->descripcion = $request->input('descripcion');
        $categoria->edad = $request->input('edad');
        $categoria->duracion = $request->input('duracion');
        $categoria->precio_inscripcion = $request->input('precio_inscripcion');
        $categoria->precio_inscripcion2c = $request->input('precio_inscripcion2c');
        $categoria->precio_inscripcion3c = $request->input('precio_inscripcion3c');
        $categoria->precio_2c1 = $request->input('precio_2c1');
        $categoria->precio_2c2 = $request->input('precio_2c2');
        $categoria->precio_3c1 = $request->input('precio_3c1');
        $categoria->precio_3c2 = $request->input('precio_3c2');
        $categoria->precio_3c3 = $request->input('precio_3c3');
        if (!is_null($request->input('f_plazo_insc'))){
            $categoria->f_plazo_insc = date('Y-m-d', strtotime($request->input('f_plazo_insc')) );
        }
        if (!is_null($request->input('f_plazo_2c1'))){
            $categoria->f_plazo_2c1 = date('Y-m-d', strtotime($request->input('f_plazo_2c1')) );
        }
        if (!is_null($request->input('f_plazo_2c2'))){
            $categoria->f_plazo_2c2 = date('Y-m-d', strtotime($request->input('f_plazo_2c2')) );
        }
        if (!is_null($request->input('f_plazo_3c1'))){
            $categoria->f_plazo_3c1 = date('Y-m-d', strtotime($request->input('f_plazo_3c1')) );
        }
        if (!is_null($request->input('f_plazo_3c2'))){
            $categoria->f_plazo_3c2 = date('Y-m-d', strtotime($request->input('f_plazo_3c2')) );
        }
        if (!is_null($request->input('f_plazo_3c3'))){
            $categoria->f_plazo_3c3 = date('Y-m-d', strtotime($request->input('f_plazo_3c3')) );
        }

        $categoria->save();

        return redirect()->route('categorias')->with('status', 'Categoría creada correctamente');
        //return redirect()->route('categorias');

        //return 'categoría Guardada';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        $categoria->fill($request->all());
        $categoria->save();

        return redirect()->route('categorias')->with('status', 'Categoría actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('categorias')->with('status', 'Categoría borrada correctamente');
    }
}
