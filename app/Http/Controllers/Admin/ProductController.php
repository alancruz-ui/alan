<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Category;
use App\Http\Models\Product;
use Validator, Str,Config,Image;

class ProductController extends Controller
{
    public function __Construct(){
        $this->middleware('auth');
        $this->middleware('isadmin');
    }
    public function getHome(){
        $products=Product::orderBy('id','desc')->paginate(25);
        $data=['products'=>$products];
        return view ('admin.products.home', $data);
    }
    public function getProductAdd(){
        $catego= Category::where('module','0')->pluck('name','id');
        $data=['catego'=>$catego];
        return view ('admin.products.add',$data);
    }
    public function postProductAdd(Request $request){
        
        $rules=[
            'name'=>'required',
            'img'=>'required',
            'price'=>'required',
            'content'=>'required'
            
        ];
        
        $messages=[
            'name.required'=>'El nombre del producto es requerido',
            'img.required'=>'Selecciona una imagen destacada',
            'img.image'=>'El archivo no es una imagen',
            'price.required'=>'Ingrese el precio del producto',
            'content.required'=>'Ingrese una descripcion del producto'
        ];
        $validator= Validator::make($request->all(),$rules,$messages);
        if($validator->fails()):
           return back()->withErrors($validator)->with('message','se ha producido un error')->with('typealert','danger')->withInput();
        else:
        $path='/'.date('Y-m-d');
        $fileExt=trim($request->file('img')->getClientOriginalExtension());
        $upload_path=Config::get('filesystems.disks.uploads.root');
        $name=Str::slug(str_replace($fileExt,'',$request->file('img')->getClientOriginalName()));
        $filename=rand(1,999).'-'.$name.'.'.$fileExt;
        $final_file=$upload_path.'/'.$path.'/'.$filename;
       
        $product=new Product;
        $product->status='0';
        $product->name= e($request->input('name'));
        $product->slug=Str::slug($request->input('name'));
        $product->category_id=$request->input('category');
        $product->file_path=date('Y-m-d');
        $product->image=$filename;
        $product->price=$request->input('price');
        $product->in_discount=$request->input('indiscount');
        $product->discount=$request->input('discount');
        $product->content=e($request->input('content'));
        if($product->save()):
        if($request->hasFile('img')):
            $fl=$request->img->storeAs($path,$filename,'uploads');
            $img=Image::make($final_file);
            $img->resize(256, 256, function($constraint){
                $constraint->upsize();
            });
            $img->save($upload_path.'/'.$path.'/t_'.$filename);
        endif;
        return redirect('/admin/products')->with('message','Guardado con exito')->with('typealert','success');
        endif;
        endif;
    }
}
