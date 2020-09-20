<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Hash,Auth;
use App\User;

class ConnectController extends Controller
{
    
    public function __construct(){
        
        $this->middleware('guest')->except(['getLogout']);
    }
    public function getLogin(){
        return view("connect.login");
    }
    public function postLogin(Request $request){
        $rules=[
            'email'=>'required|email',
            'password'=>'required|min:8'
            
        ];
        
        $messages=[
            'email.required'=>'Su correo electronico es requerido.',
            'email.email'=>'El formato del correo electronico es invalido.',
            'password.required'=>'Por favor escriba una contraseña.',
            'password.min'=>'La contraseña debe tener al menos 8 caracteres.'
            
        ];
        
        $validator=Validator::make($request->all(),$rules, $messages);
        if($validator->fails()):
           return back()->withErrors($validator)->with('message','se ha producido un error')->with('typealert','danger');
        else:
        
            if(Auth::attempt(['email'=>$request->input('email'),'password'=>$request->input('password')],true)):
                return redirect('/');
            else:
                return back()->with('message','Correo electronico o contraseña erroneos.')->with('typealert','danger');
                endif;
        endif;
        
    }
    public function getRegister(){
        return view("connect.register");
    }
    
    public function postRegister(Request $request){
        $rules=[
            
            'name'=>'required',
            'lastname'=>'required',
            'email'=> 'required|email|unique:users,email',
            'password'=>'required|min:8',
            'cpassword'=>'required|min:8|same:password'
        ];
        $messages=[
            'name.required'=>'Su nombre es requerido.',
            'lastname.required'=>'Su apellido es requerido.',
            'email.required'=>'Su correo electronico es requerido.',
            'email.email'=>'El formato del correo electronico es invalido.',
            'email.unique'=>'Ya existe un usuario con este correo electronico.',
            'password.required'=>'Por favor escriba una contraseña.',
            'password.min'=>'La contraseña debe tener al menos 8 caracteres.',
            'cpassword.required'=>'Es nesesario confirmar la contraseña.',
            'cpassword.min'=>'La contraseña debe tener al menos 8 caracteres.',
            'cpassword.same'=>'Las contraseñas no coninciden.'
        ];
        
        $validator=Validator::make($request->all(),$rules, $messages);
        if($validator->fails()):
           return back()->withErrors($validator)->with('message','se ha producido un error')->with('typealert','danger');
        else:
        $user = new User;
        $user->name= e($request->input('name'));
        $user->lastname= e($request->input('lastname'));
        $user->email= e($request->input('email'));
        $user->password=Hash::make($request->input('password'));
        
        if($user->save()):
        return redirect('/login')->with('message','Su usuario se creo con exito, ahora puede iniciar sesion')->with('typealert','success');
        endif;
        endif;
    }
    
    public function getLogout(){
        Auth::logout();
         return redirect('/');
        
    }
}
