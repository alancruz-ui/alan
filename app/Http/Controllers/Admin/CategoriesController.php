<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator,Str;
use App\Http\Models\Category;

class CategoriesController extends Controller
{
     public function __Construct(){
        $this->middleware('auth');
        $this->middleware('isadmin');
    }
    public function getHome($module){
        $catego=Category::where('module',$module)->orderBy('name','Asc')->get();
        $data=['catego'=>$catego]; 
        return view('admin.categories.home', $data);
    }
    
    public function postCategoriesAdd(Request $request){
        $rules=[
            'name'=> 'required',
            'icon'=> 'required',
        ];
        $messages=[
            
            'name.required'=>'se requiere un nombre de categoria',
            'icon.required'=>'se requiere un icono para la categoria.'
        ];
        $validator= Validator::make($request->all(),$rules,$messages);
        if($validator->fails()):
           return back()->withErrors($validator)->with('message','se ha producido un error')->with('typealert','danger');
        else:
        $c= new Category;
        $c->module=$request->input('module');
        $c->name=e($request->input('name'));
        $c->slug=Str::slug($request->input('name'));
        $c->icono=e($request->input('icon'));
        if($c->save()):
        return back()->with('message','Guardado con exito')->with('typealert','success');
        endif;
        endif;
    }
    public function getCategoriesEdit($id){
        $catego= Category::find($id);
        $data=['catego'=>$catego];
        return view('admin.categories.edit', $data);
    }
    public function postCategoriesEdit(Request $request, $id){
        $rules=[
            'name'=> 'required',
            'icon'=> 'required',
        ];
        $messages=[
            
            'name.required'=>'se requiere un nombre de categoria',
            'icon.required'=>'se requiere un icono para la categoria.'
        ];
        $validator= Validator::make($request->all(),$rules,$messages);
        if($validator->fails()):
           return back()->withErrors($validator)->with('message','se ha producido un error')->with('typealert','danger');
        else:
        $c= Category::find($id);
        $c->module=$request->input('module');
        $c->name=e($request->input('name'));
        $c->slug=Str::slug($request->input('name'));
        $c->icono=e($request->input('icon'));
        if($c->save()):
        return back()->with('message','Guardado con exito')->with('typealert','success');
        endif;
        endif;
    }
    
    public function getCategoriesDelete($id){
         $c= Category::find($id);
        if($c->delete()):
        return back()->with('message','Borrado con exito')->with('typealert','success');
        endif;
        
    }
}
