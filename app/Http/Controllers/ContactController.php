<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    
    //Metodo 1:
    public $request;

    public function __construct(Request $request)
    {
        //Metodo 1: de inyectar una instancia request
        $this->request = $request;
    }

    public function show()
    {
        return view('contacto');
    }

    //public function store(Request $request)
    public function store(ContactRequest $request)
    {
        
        //VALIDACIONES
        //return $this->validaciones1($request);

        //FORM REQUEST        
        return $this->validaciones2($request);
        //se puede crear nuestras propias reglas


        //SOLICITUDES HTTP

        //Metodo 1
        //return $this->request->all();

        //Metodo 2: inyectandola al metodo
        //devuelve todos los parametros enviados
        //return $request->all();
        
        //es igual a
        //return $request->input();

        //devuelve el valor de un campo
        //return $request->input('nombre');
        
        //de igual manera, pero sin chequear si existe
        //return $request->nombre;

        //solo algunos valores
        //return $request->only(['nombre', 'email']);

        //solo algunos valores que no sean estos
        //return $request->except(['nombre', 'email']);

        //verificar si la solicitud tiene el atributo xxx, array o valor
        return (string)$request->has(['nombre', 'email']);

        //devuelve la parte de la url sin el dominio
        //return $request->path();

        //devuelve toda la url http://larticles.test/contacto, sin parametros get
        //return $request->url();

        //verifica que la url que nos encontramos es igual a la pasada por parametro
        //return (string)$request->is('contacto');

        //verifica el metodo de envio del formulario
        //return $request->method();

        //verifica el metodo de envio del formulario
        return $request->isMethod('POST');
    }

    public function validaciones1(Request $request)
    {
        //return $request->all();

        //todas las reglas de validaciones disponibles
        return $request->validate([
            'nombre' => 'required|integer',
            'email' => 'required|email',
            'mensaje' => 'required|min:5'
        ]);
        //si falla la validacion retorna la vista anterior, en este caso 'contacto'
        
        //para mantener valores anteriores setearlos desde la vista con {{ old('nombre') }}
        
        //para enviar errores desde la vista la variable $errores contiene los errores de validaciion {{ $errors->first('nombre') }}
        
        //los mensajes estan en ingles, para pasar a español, en resources/lang/es/...
        //desde https://github.com/caouecs/Laravel-lang/tree/master/src/es
        //o https://github.com/Laraveles/spanish/blob/master/resources/lang/es/
        //descargar y pegarlos en resources/lang/
        
        //para cambiar el idioma español, config/app.php "locale": "es"
    }

    public function validaciones2(ContactRequest $request)
    {
        //creando una clase con todas las validaciones, se puede crear con artisan
        //php artisan make:request ContactRequest
        //crea archivo en app/Http/Requests/ContactRequest.php
        
        //inyectarla para utilizar el formrequest, debemos importarla para usarla,
        return $request->all();


        //se puede crear nuestras propias reglas
        //php artisan make:rule toUpperCase
        //
        //la crea en app/Rules/toUpperCase.php
        //
        //passes, determina si el atributo es valido o no
    }
}
