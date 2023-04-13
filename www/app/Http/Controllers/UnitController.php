<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;

use App\Models\Unit;

class UnitController extends Controller
{

   public function __construct()
   {
       $this->middleware('auth');
   }
 
    public function listUnit()
    {
       $units=Unit::all();
       return view('unit-list',['units'=>$units]);
    }

    public function storeUnit(Request $request)
    {
         $unit = new Unit;
         $unit->unit = $request->newUnitName;

         if ( ! $unit->save())
         {
          App::abort(500, 'Error');
         }
       else{
          return Redirect::to('units/list')->with('success', "Birim Kaydedildi!");
         }

    }

    public function editUnit(Request $request,$id)
    {
       $unit = Unit::find($id);
       $unit->unit = $request->unitName;
       if(!$unit->save())
       {
        App::abort(500, 'Error');
       }else{
        return Redirect::to('units/list')->with('success', 'Birim Güncellendi!');
       }
    }

    public function deleteUnit($id)
    {
       $unit=Unit::find($id);

       if ( ! $unit->delete())
       {
          App::abort(500, 'Error');
       }
       else{
          return Redirect::to('units/list')->with('success', 'Birim Silindi!');
       }
      
    }
 
    
}
 