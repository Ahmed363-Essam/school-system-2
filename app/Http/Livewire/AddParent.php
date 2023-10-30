<?php

namespace App\Http\Livewire;

use App\Models\Nationality;

use App\Models\Type_Blood;

use App\Models\religions;
use Illuminate\Support\Facades\Hash;
use App\Models\parents;

use App\Models\ParentAttachment;


use Livewire\WithFileUploads;
use Livewire\Component;

class AddParent extends Component
{
    use WithFileUploads;

    public $currentStep = 1,
            // Father_INPUTS
            $Email, $Password,
            $Name_Father, $Name_Father_en,
            $National_ID_Father, $Passport_ID_Father,
            $Phone_Father, $Job_Father, $Job_Father_en,
            $Nationality_Father_id, $Blood_Type_Father_id,
            $Address_Father, $Religion_Father_id,
            $updateMode,

            // Mother_INPUTS
            $Name_Mother, $Name_Mother_en,
            $National_ID_Mother, $Passport_ID_Mother,
            $Phone_Mother, $Job_Mother, $Job_Mother_en,
            $Nationality_Mother_id, $Blood_Type_Mother_id,
            $Address_Mother, $Religion_Mother_id;

            public $showTable = true;



            public $catchError;

            public $photos = [];


            protected $rules = [
                'Email' => 'required|email',
                'National_ID_Father' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
                'Passport_ID_Father' => 'min:10|max:10',
                'Phone_Father' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'National_ID_Mother' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
                'Passport_ID_Mother' => 'min:10|max:10',
                'Phone_Mother' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10'
            ];




            public function updated($propertyName)
            {
               $this->validateOnly($propertyName,$this->rules);
            }



            public function showformadd()
            {
                $this->showTable = false;
            }




    public function render()
    {
        return view('livewire.add-parent',
    [
        'Nationalities' => Nationality::all(),
        'Type_Bloods' => Type_Blood::all(),
        'Religions' => religions::all(),
        'my_parents'=>parents::all()

    ]);
    }


    public function firstStepSubmit()
    {

      /*  $this->validate([
            'Email' => 'required|unique:parents,Email,'.$this->id,
            'Password' => 'required',
            'Name_Father' => 'required',
            'Name_Father_en' => 'required',
            'Job_Father' => 'required',
            'Job_Father_en' => 'required',
            'National_ID_Father' => 'required|unique:parents,National_ID_Father,' . $this->id,
            'Passport_ID_Father' => 'required|unique:parents,Passport_ID_Father,' . $this->id,
            'Phone_Father' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'Nationality_Father_id' => 'required',
            'Blood_Type_Father_id' => 'required',
            'Religion_Father_id' => 'required',
            'Address_Father' => 'required',
        ]);

*/




        $this->currentStep = 2;
    }


    public function back()
    {
        $this->currentStep = 1;
    }


    public function secondStepSubmit()
    {


      /*  $this->validate([
            'Name_Mother' => 'required',
            'Name_Mother_en' => 'required',
            'National_ID_Mother' => 'required|unique:parents,National_ID_Mother,' . $this->id,
            'Passport_ID_Mother' => 'required|unique:parents,Passport_ID_Mother,' . $this->id,
            'Phone_Mother' => 'required',
            'Job_Mother' => 'required',
            'Job_Mother_en' => 'required',
            'Nationality_Mother_id' => 'required',
            'Blood_Type_Mother_id' => 'required',
            'Religion_Mother_id' => 'required',
            'Address_Mother' => 'required',
        ]);*/


        $this->currentStep = 3;
    }


    public function submitForm()
    {

        try {



        $parents = new parents();

        $parents->Email  = $this->Email;

        $parents->Password = Hash::make($this->Password);

        $parents->Name_Father = ['en'=>$this->Name_Father_en  , 'ar'=>$this->Name_Father ];

        $parents->National_ID_Father = $this->National_ID_Father;

        $parents->Passport_ID_Father = $this->Passport_ID_Father;

        $parents->Phone_Father = $this->Phone_Father;

        $parents->Job_Father =  ['en' => $this->Job_Father_en, 'ar' => $this->Job_Father];

        $parents->Nationality_Father_id = $this->Nationality_Father_id;

        $parents->Blood_Type_Father_id = $this->Blood_Type_Father_id;

        $parents->Religion_Father_id = $this->Religion_Father_id;

        $parents->Address_Father = $this->Address_Father;



        $parents->Name_Mother = ['en'=>$this->Name_Mother_en  , 'ar'=>$this->Name_Mother ];


        $parents->National_ID_Mother = $this->National_ID_Mother;

        $parents->Passport_ID_Mother = $this->Passport_ID_Mother;

        $parents->Phone_Mother = $this->Phone_Mother;

        $parents->Job_Mother = ['en' => $this->Job_Mother_en, 'ar' => $this->Job_Mother];

        $parents->Nationality_Mother_id = $this->Nationality_Mother_id;

        $parents->Blood_Type_Mother_id = $this->Blood_Type_Mother_id;

        $parents->Religion_Mother_id = $this->Religion_Mother_id;

        $parents->Address_Mother = $this->Address_Mother;

        $parents->save();






        if(!empty($this->photos))
        {


            foreach ($this->photos as $photo) {

                $photo->storeAs($this->National_ID_Father,$photo->getClientOriginalName(),$disk='parent_attachment');



                ParentAttachment::create([
                    'parent_id'=>parents::latest()->first()->id,
                    'name' => $photo->getClientOriginalName()

                ]);



            }
            toastr()->success( trans('message.success'));


        //$this->clearForm();


        $this->showTable = true;

        }








        } catch (\Exception $e) {
            //throw $th;

            $this->catchError = $e->getMessage();
        }

    }


    public function edit($id)
    {

    }



    public function delete($id)
    {
        parents::findOrFail($id)->delete();
    }

    //clearForm
    public function clearForm()
    {
        $this->Email = '';
        $this->Password = '';
        $this->Name_Father = '';
        $this->Job_Father = '';
        $this->Job_Father_en = '';
        $this->Name_Father_en = '';
        $this->National_ID_Father ='';
        $this->Passport_ID_Father = '';
        $this->Phone_Father = '';
        $this->Nationality_Father_id = '';
        $this->Blood_Type_Father_id = '';
        $this->Address_Father ='';
        $this->Religion_Father_id ='';

        $this->Name_Mother = '';
        $this->Job_Mother = '';
        $this->Job_Mother_en = '';
        $this->Name_Mother_en = '';
        $this->National_ID_Mother ='';
        $this->Passport_ID_Mother = '';
        $this->Phone_Mother = '';
        $this->Nationality_Mother_id = '';
        $this->Blood_Type_Mother_id = '';
        $this->Address_Mother ='';
        $this->Religion_Mother_id ='';

    }


}
