<?php

namespace BMLaguna\Exports;

use BMLaguna\Miembro;
use BMLaguna\Categoria;
use BMLaguna\Temporada;
use BMLaguna\Email;
use BMLaguna\Telefono;
use BMLaguna\Genero;
use BMLaguna\Equipo;

use DB;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Arr;
use DateTime;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;

class MiembrosExport implements FromCollection, WithHeadings, WithColumnFormatting, WithMapping, ShouldAutoSize, Withdrawings, WithEvents, WithCustomStartCell
{
    use RegistersEventListeners;

    /**
    * @return \Illuminate\Support\Collection
    */
    private $temporada_id;
    private $categoria_id;
    private $equipo_id;
    private $genero_id;
    private $nombre;
    private $campos;
    private $posFecha;
    private $baja;
   
    public function __construct($criterios, $campos){
        /* dd($criterios);  */
        $this->temporada_id = $criterios['temporada_id'];
        $this->categoria_id = $criterios['categoria_id'];
        $this->genero_id = $criterios['genero_id'];
        $this->nombre = $criterios['nombre'];
        $this->campos = $campos;
        $this->baja = $criterios['baja'];
        $this->equipo_id = $criterios['equipo_id'];
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function headings(): array
    {
        $campos = [];
        $i = 0;

        /* Dorsal */
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkDorsal';})){
            $campos[$i] = 'Dorsal';
            $i++;
        }

        /* Datos Personales */
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkNombre';})){
            $campos[$i] = 'Nombre';
            $i++;
            $campos[$i] = 'Primer Apellido';
            $i++;
            $campos[$i] = 'Segundo Apellido';
            $i++;
        }
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkNIF';})){
            $campos[$i] = 'N.I.F.';
            $i++;
        }

        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkFNac';})){
            $campos[$i] = 'Fecha de Nacimiento';
            $i++;
        }

        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkGenero';})){
            $campos[$i] = 'Genero';
            $i++;
        }

        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkCentro';})){
            $campos[$i] = 'Centro Educativo';
            $i++;
        }
        /* Fin Datos Personales */

        /* Domicilio */
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkDomicilio';})){
            $campos[$i] = 'Domicilio';
            $i++;
        }
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkLocalidad';})){
            $campos[$i] = 'Localidad';
            $i++;
        }
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkProvincia';})){
            $campos[$i] = 'Provincia';
            $i++;
        }
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkCPostal';})){
            $campos[$i] = 'Código Postal';
            $i++;
        }
        /* Fin Domicilio */
        /* Contactos */
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkTelefonos';})){
            $campos[$i] = 'Teléfonos';
            $i++;
        }
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkEmails';})){
            $campos[$i] = 'Correo Electrónico';
            $i++;
        }
        /* Fin Contactos */
        /* Familiares */
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkFamiliares';})){

            $campos[$i] = 'Responsable 1';
            $i++;
    
            $campos[$i] = 'Responsable 2';
            $i++;
        }
        /* Fin Familiares */
        /* Categoría */
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkCategoria';})){
            $campos[$i] = 'Categoría';
            $i++;
        }
        /* Fin Categoría */
        /* Nombre del Equipo */
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkNomEquipo';})){
            $campos[$i] = 'Nombre del Equipo';
            $i++;
        }
        /* Fin Nombre del Equipo */
        /* Función en el Equipo */
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkFuncion';})){
            $campos[$i] = 'Función en el Equipo';
            $i++;
        }
        /* Fin Función en el Equipo */
        /* Estado de la Preinscripción */
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkPreinscripcion';})){
            $campos[$i] = 'Estado de la Preinscripción';
            $i++;
        }
        /* Fin Estado de la Preinscripción */
        /* Pagos */
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkPagado';})){
            $campos[$i] = 'Total Pagado';
            $i++;
        }
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkTotalPagar';})){
            $campos[$i] = 'Total a Pagar';
            $i++;
        }
        /* Fin Pagos */

        return [[$i, $this->temporada_id, $this->categoria_id, $this->genero_id, $this->nombre, $this->baja, $this->equipo_id],[],[],[],[],$campos];
    }

    public function map($miembro): array
    {
        $miembro = Miembro::find($miembro->id);

        $campos = [];
        $i = 0;

        /* Dorsal */
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkDorsal';})){
            $campos[$i] = $miembro->dorsal;
            $i++;
        }

        /* Datos Personales */
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkNombre';})){
            $campos[$i] = $miembro->nombre;
            $i++;
            $campos[$i] = $miembro->apellido1;
            $i++;
            $campos[$i] = $miembro->apellido2;
            $i++;
        }
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkNIF';})){
            $campos[$i] = $miembro->nif;
            $i++;
        }

        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkFNac';})){
            
            if (!is_null($miembro->f_nacimiento)){
                $campos[$i] = Date::dateTimeToExcel(DateTime::createFromFormat('Y-m-d', $miembro->f_nacimiento));
            }
            else{
                $campos[$i] = null;
            }
            $this->posFecha = $i;
            $i++;
        }

        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkGenero';})){
            if (!is_null($miembro->genero_id)){
                $campos[$i] = $miembro->genero->descripcion;
            }
            else{
                $campos[$i] = '';
            }
            $i++;
        }

        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkCentro';})){
            $campos[$i] = $miembro->centroEducativo;
            $i++;
        }
        /* Fin Datos Personales */

        /* Domicilio */
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkDomicilio';})){
            $campos[$i] = $miembro->domicilio;
            $i++;
        }
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkLocalidad';})){
            $campos[$i] = $miembro->localidad;
            $i++;
        }
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkProvincia';})){
            $campos[$i] = $miembro->provincia;
            $i++;
        }
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkCPostal';})){
            $campos[$i] = $miembro->c_postal;
            $i++;
        }
        /* Fin Domicilio */
        /* Contactos */
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkTelefonos';})){

            $telefonos = Telefono::where('miembro_id', $miembro->id)->get();
            $telef = '';
            foreach($telefonos as $telefono){
                if ($telef == ''){
                    $telef = $telefono->telefono;
                }
                else{
                    $telef = $telef.'-'.$telefono->telefono;
                }
            }
        
            $campos[$i] = $telef;
            $i++;
        }
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkEmails';})){

            $emails = Email::where('miembro_id', $miembro->id)->get();
            $correo = '';
            foreach($emails as $email){
                if ($correo == ''){
                    $correo = $email->email;    
                }
                else{
                    $correo = $correo.'-'.$email->email;
                }
            }
        
            $campos[$i] = $correo;
            $i++;
        }
        /* Fin Contactos */
        /* Familiares */
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkFamiliares';})){

            $responsable1 = '';
            $responsable2 = '';
    
            if (!is_null($miembro->responsable1_id)){
                $responsable1V = Miembro::find($miembro->responsable1_id);
                $responsable1 = $responsable1V->nombre.' '.$responsable1V->apellido1.' '.$responsable1V->apellido2;
            }
            if (!is_null($miembro->responsable2_id)){
                $responsable2V = Miembro::find($miembro->responsable2_id);
                $responsable2 = $responsable2V->nombre.' '.$responsable2V->apellido1.' '.$responsable2V->apellido2;
            }
            
            $campos[$i] = $responsable1;
            $i++;
            $campos[$i] = $responsable2;
            $i++;
        }
        /* Fin Familiares */
        /* Categoría */
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkCategoria';})){

            if (is_null($this->temporada_id)){
                $tempElegida = Temporada::Tactual();
            }
            else{
                $tempElegida = Temporada::find($this->temporada_id);
            }

            $campos[$i] = $miembro->categoria($tempElegida->temporada)->descripcion;
            $i++;
        }
        /* Fin Categoría */
        /* Nombre del Equipo */
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkNomEquipo';})){

            if (is_null($this->temporada_id)){
                $tempElegida = Temporada::Tactual();
            }
            else{
                $tempElegida = Temporada::find($this->temporada_id);
            }

            $campos[$i] = '';
            foreach ($miembro->equipoTemp($tempElegida) as $equipo){
                if ($campos[$i] != ''){
                    $campos[$i] = $campos[$i] . "\r\n" . $equipo['equipo'] .' '. $equipo['categoria'] .' '. $equipo['genero'];
                }
                else{
                    $campos[$i] = $campos[$i] . $equipo['equipo'] .' '. $equipo['categoria'] .' '. $equipo['genero'];
                }
            }
            $i++;
        }
        /* Fin Nombre del Equipo */
        /* Función en el Equipo */
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkFuncion';})){
                if (is_null($this->temporada_id)){
                    $tempElegida = Temporada::Tactual();
                }
                else{
                    $tempElegida = Temporada::find($this->temporada_id);
                }
    
                $campos[$i] = '';
                foreach ($miembro->equipoTemp($tempElegida) as $equipo){
                    if (is_null($this->equipo_id) || ($this->equipo_id == $equipo['id']) )
                        if ($campos[$i] != ''){
                            $campos[$i] = $campos[$i] . "\r\n" . $equipo['funcion'];
                        }
                        else{
                            $campos[$i] = $campos[$i] . $equipo['funcion'];
                        }
                }
                $i++;
            }
        /* Fin Función en el Equipo */
        /* Estado de la Preinscripción */
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkPreinscripcion';})){
            if (is_null($this->temporada_id)){
                $tempElegida = Temporada::Tactual();
            }
            else{
                $tempElegida = Temporada::find($this->temporada_id);
            }

            $preinscripcion = $miembro->preinscripcionTemp($tempElegida)->first();
            if (!is_null($preinscripcion)){
                $campos[$i] = $miembro->preinscripcionTemp($tempElegida)->first()->estado;
            }
            else{
                $campos[$i] = 'No preinscrito';
            }
            $i++;
        }
        /* Fin Estado de la Preinscripción */
        /* Pagos */
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkPagado';})){
            if (is_null($this->temporada_id)){
                $tempElegida = Temporada::Tactual();
            }
            else{
                $tempElegida = Temporada::find($this->temporada_id);
            }


            $campos[$i] = $miembro->pagosTemp($tempElegida)[0];
            $i++;
        }
        if (Arr::first($this->campos, function ($value, $key) {
            return $value == 'checkTotalPagar';})){
                $campos[$i] = $miembro->pagosTemp($tempElegida)[1];
            $i++;
        }
        /* Fin Pagos */
        
        return $campos;
    }

    public function columnFormats(): array
    {
        $alfabeto =['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

        if (!is_null($this->posFecha)){
            return [
                $alfabeto[$this->posFecha] => NumberFormat::FORMAT_DATE_DDMMYYYY,
            ];
        }
        else {
            return [];
        }
    }

    public function collection()
    {
        /* dd($this); */

        if (is_null($this->temporada_id)){
            $tempElegida = Temporada::Tactual();
        }
        else{
            $tempElegida = Temporada::find($this->temporada_id);
        }


        // Criterios
                
        if (!is_null($this->baja)){
            // Miembros dados de baja
            $miembros = Miembro::whereNotNull('f_baja');
        }
        else{
            $miembros = Miembro::whereNull('f_baja');
        }

        //Temporada
        if (!is_null($this->temporada_id)){
            $miembros = $miembros->join('equipo_funcione_miembro', 'miembros.id', '=', 'equipo_funcione_miembro.miembro_id')->
                            join('equipos', 'equipos.id', '=', 'equipo_funcione_miembro.equipo_id')->
                            where('equipos.temporada_id', $this->temporada_id);
            // Equipo                            
            if (!is_null($this->equipo_id)){                            
                $miembros = $miembros->where('equipos.id', $this->equipo_id);
            }

            $miembros = $miembros->select('miembros.id');
        }

        // Categoria
        if (!is_null($this->categoria_id)){
            $catElegida = Categoria::find($this->categoria_id);

            $miembros = $miembros->whereYear('f_nacimiento','>=', $catElegida->rangoAnnos($tempElegida)[0])->
                                whereYear('f_nacimiento','<=', $catElegida->rangoAnnos($tempElegida)[1]);
        }
        
        // Género
        if (!is_null($this->genero_id)){
            $miembros = $miembros->where('miembros.genero_id', $this->genero_id);
        }

        // Nombre
        if (!is_null($this->nombre)){
            $miembros = $miembros->where(DB::raw("concat(miembros.nombre, ' ', miembros.apellido1, ' ', IFNULL(miembros.apellido2, ' '))"), "like",  "%$this->nombre%");
        }

        $this->totalReg = $miembros->distinct()->count();
        $miembros = $miembros->distinct()->get();

        return $miembros;
       
    } 

    public function drawings()
        {
            $drawing = new Drawing();
            $drawing->setName('BMLaguna');
            $drawing->setDescription('Escudo');
            $drawing->setPath(public_path('/images/escudo.png'));
            $drawing->setHeight(75);
            $drawing->setCoordinates('A1');

            return $drawing;
        }

    public static function afterSheet(AfterSheet $event)
        {
            $alfabeto =['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

            /* Baja o activos */
            $baja = $event->sheet->getCell('F1')->getValue();
            $event->sheet->setCellValue('F1', '');

            $equipo_id = $event->sheet->getCell('G1')->getValue();
            $event->sheet->setCellValue('G1', '');

            if (!is_null($equipo_id)){
                $equipo = Equipo::find($equipo_id);
                $titulo = $equipo->nombre . ' ' . $equipo->categoria->descripcion . ' ' . $equipo->genero->descripcion;
                $event->sheet->setCellValue('B2', $titulo);
            }
            else{
                if (!is_null($baja)){
                    $event->sheet->setCellValue('B2', 'Listado de bajas del club');
                }
                else{
                    $event->sheet->setCellValue('B2', 'Listado de miembros del club');
                }
            }
            
            $event->sheet->mergeCells('B2:E3');
            $event->sheet->getStyle('B2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $event->sheet->getStyle('B2')->getFont()->setBold(true);
            $event->sheet->getStyle('B2')->getFont()->setSize(20);

            $campos = $event->sheet->getCell('A1')->getValue();
            $event->sheet->setCellValue('A1', '');
            for ($i = 0; $i < $campos; $i++){
                $event->sheet->getCellByColumnAndRow(1 + $i, 6)->getStyle()->getFont()->setBold(true);
                $event->sheet->getCellByColumnAndRow(1 +$i, 6)->getStyle()->getFont()->setSize(14);
            }

            /* Criterios */
            /* Temporada */
            $temporada_id = $event->sheet->getCell('B1')->getValue();
            $event->sheet->setCellValue('B1', '');
            $temporada = Temporada::find($temporada_id);
            if (!is_null($temporada)){
                $event->sheet->setCellValue('H1', 'Temporada: '.$temporada->descripcion);
            }
            else{
                $event->sheet->setCellValue('H1', 'Temporada: Todas');
            }
            /* Fin Temporada */
            /* Categoría */            
            $categoria_id = $event->sheet->getCell('C1')->getValue();
            $event->sheet->setCellValue('C1', '');
            $categoria = Categoria::find($categoria_id);
            if (!is_null($categoria)){
                $event->sheet->setCellValue('H2', 'Categoría: '.$categoria->descripcion);
            }
            else{
                $event->sheet->setCellValue('H2', 'Categoría: Todas');
            }
            /* Fin Categoría */
            /* Género */            
            $genero_id = $event->sheet->getCell('D1')->getValue();
            $event->sheet->setCellValue('D1', '');
            $genero = Genero::find($genero_id);
            if (!is_null($genero)){
                $event->sheet->setCellValue('H3', 'Género: '.$genero->descripcion);
            }
            else{
                $event->sheet->setCellValue('H3', 'Género: Todos');
            }
            /* Fin Género */
            /* Texto Nombre*/            
            $nombre = $event->sheet->getCell('E1')->getValue();
            $event->sheet->setCellValue('E1', '');
            if ($nombre != ''){
                $event->sheet->setCellValue('H4', 'Texto Nombre: '.$nombre);
            }
            else{
                $event->sheet->setCellValue('H4', 'Texto Nombre: Cualquiera');
            }
            /* Fin Texto Nombre */

            /* Autofiltro */
            $event->sheet->setAutoFilter('A6:'.$alfabeto[$campos-1].'6');
        }
}