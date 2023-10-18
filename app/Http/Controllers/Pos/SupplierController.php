<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    /** all supplier list */
    public function supplierAll(){
        $suppliers = Supplier::latest()->get();
        return view('backend.supplier.supplier_all',compact('suppliers'));
    }

    /** supplier add */
    public function supplierAdd(){
        return view('backend.supplier.supplier_add');
    }
   
    /**supplier store */
    public function supplierStore(Request $request){
        Supplier::insert([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'created_by' => Auth::id(),
            'created_at' => Carbon::now()
        ]);

       $notification = array(
        'message' => 'Supplier Inserted Successfully',
        'alert-type' => 'success'
       );
       return redirect()->route('supplier.all')->with($notification);
    }


    /**supplier Edit */
    public function SupplierEdit($id){

        $supplier = Supplier::findOrFail($id);
        return view('backend.supplier.supplier_edit',compact('supplier'));

    } 

    /** supplier update */
    public function SupplierUpdate(Request $request){

        $sullier_id = $request->id;

        Supplier::findOrFail($sullier_id)->update([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => 'Supplier Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.all')->with($notification);

    } // End Method 

    /** supplier delete */
    public function SupplierDelete($id){

      Supplier::findOrFail($id)->delete();
      
       $notification = array(
            'message' => 'Supplier Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method 

}
