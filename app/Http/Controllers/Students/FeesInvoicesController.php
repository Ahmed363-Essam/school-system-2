<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Fee_invoice;
use App\Models\Students;
use App\Models\grade;
use App\Models\fees;
use App\Models\StudentAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FeesInvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Fee_invoices = Fee_invoice::all();
        $Grades = grade::all();
        return view('pages.Fees_Invoices.index',compact('Fee_invoices','Grades'));
 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $List_Fees = $request->List_Fees;

        DB::beginTransaction();

        try {

            foreach ($List_Fees as $List_Fee) {
                // حفظ البيانات في جدول فواتير الرسوم الدراسية
                $Fees = new Fee_invoice();
                $Fees->invoice_date = date('Y-m-d');
                $Fees->student_id = $List_Fee['student_id'];
                $Fees->Grade_id = $request->Grade_id;
                $Fees->Classroom_id = $request->Classroom_id;;
                $Fees->fee_id = $List_Fee['fee_id'];
                $Fees->amount = $List_Fee['amount'];
                $Fees->description = $List_Fee['description'];
                $Fees->save();

                // حفظ البيانات في جدول حسابات الطلاب
                $StudentAccount = new StudentAccount();
                $StudentAccount->date = date('Y-m-d');
                $StudentAccount->type = 'invoice';
                $StudentAccount->fee_invoice_id = $Fees->id;
                $StudentAccount->student_id = $List_Fee['student_id'];
                $StudentAccount->Debit = $List_Fee['amount'];
                $StudentAccount->credit = 0.00;
                $StudentAccount->description = $List_Fee['description'];
                $StudentAccount->save();
            }

            DB::commit();

            toastr()->success(trans('messages.success'));
            return redirect()->route('Fees_Invoices.index');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
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
        $student = Students::findorfail($id);
        $fees = fees::where('Classroom_id',$student->Classroom_id)->get();
        return view('pages.Fees_Invoices.add',compact('student','fees'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $fee_invoices  = Fee_invoice::findorfail($id);

        $fees = fees::where('Classroom_id',$fee_invoices->Classroom_id)->get();

        return view('pages.Fees_Invoices.edit',compact('fee_invoices','fees'));

       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        //DB::beginTransaction();

        DB::beginTransaction();

        try {


            $Fee_invoice = Fee_invoice::findorfail($request->id);
  
            $Fee_invoice->amount = $request->amount;
            $Fee_invoice->description = $request->description;
            $Fee_invoice->fee_id = $request->fee_id;
    
            $Fee_invoice->save();


           // تعديل البيانات في جدول حسابات الطلاب
            $StudentAccount = StudentAccount::where('fee_invoice_id',$request->id)->first();
            $StudentAccount->Debit = $request->amount;
            $StudentAccount->description = $request->description;
            $StudentAccount->save();
            DB::commit();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Fees_Invoices.index');



        } catch (\Exception  $e) {
            //throw $th;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //

        Fee_invoice::findorfail($request->id)->delete();

        toastr()->success(trans('messages.Delete'));
        return redirect()->route('Fees_Invoices.index');
    }
}
