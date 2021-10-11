<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Registrant;

class RegistrantController extends Controller
{
    private $response = [];
    private $validation_rules = [
        'name' => 'required|max:255',
        'id_card_number' => 'required|unique:registrants|max:20',
        'phone' => 'max:20'
    ];

    private function basicResponse()
    {
        return [
            'timestamp' => Carbon::now()->toDateTimeString(),
            'status' => 200,
            'message' => '',
            'result' => []
        ];
    }

    public function __construct()
    {
        $this->response = $this->basicResponse();
    }

    public function index()
    {
        try {
            $this->response['result'] = Registrant::all();
        } catch (\Throwable $throwable) {
            $this->response['status'] = 500;
            $this->response['message'] = $throwable->getMessage();
        }

        return response()->json($this->response);
    }

    public function create(Request $request)
    {
        $validator = $this->getValidationFactory()->make($request->post(), $this->validation_rules);
        if ($validator->fails()) {
            $this->response['status'] = 422;
            $this->response['message'] = $validator->errors();
        } else{
            try {
                $registrant = new Registrant();
                $registrant->name = $request->name;
                $registrant->id_card_number = $request->id_card_number;
                $registrant->address = $request->address;
                $registrant->phone = $request->phone;

                if ($registrant->save()){
                    $this->response['message'] = 'registrant data saved successfully!';
                } else {
                    $this->response['status'] = 500;
                    $this->response['message'] = 'registrant data failed to save!';
                }
            }catch (\Throwable $throwable){
                $this->response['status'] = 500;
                $this->response['message'] = $throwable->getMessage();
            }
        }

        return response()->json($this->response);
    }

    public function show($id)
    {
        $validator = $this->getValidationFactory()->make(['id' => $id], ['id' => 'required|numeric']);
        if ($validator->fails()){
            $this->response['status'] = 422;
            $this->response['message'] = $validator->errors();
        } else {
            try {
                $this->response['result'] = Registrant::find($id);
            } catch (\Throwable $throwable){
                $this->response['status'] = 500;
                $this->response['message'] = $throwable->getMessage();
            }
        }

        return response()->json($this->response);
    }

    public function update(Request $request, $id)
    {
        $this->validation_rules['id_card_number'] = 'required|max:20';
        $validator = $this->getValidationFactory()->make($request->post(), $this->validation_rules);

        if ($validator->fails()){
            $this->response['status'] = 422;
            $this->response['message'] = $validator->errors();
        } else {
            try {
                $registrant = Registrant::find($id);
                $registrant->name = $request->name;
                $registrant->id_card_number = $request->id_card_number;
                $registrant->address = $request->address;
                $registrant->phone = $request->phone;

                if ($registrant->save()){
                    $this->response['message'] = 'registrant data has been successfully updated!';
                } else {
                    $this->response['status'] = 500;
                    $this->response['message'] = 'registrant data failed to update!';
                }
            } catch (\Throwable $throwable){
                $this->response['status'] = 500;
                $this->response['message'] = $throwable->getMessage();
            }
        }

        return response()->json($this->response);
    }

    public function destroy($id)
    {
        $validator = $this->getValidationFactory()->make(['id' => $id], ['id' => 'required|numeric']);
        if ($validator->fails()){
            $this->response['status'] = 422;
            $this->response['message'] = $validator->errors();
        } else {
            try {
                $registrant = Registrant::find($id);
                if ($registrant->delete()){
                    $this->response['message'] = 'registrant data removed successfully!';
                } else {
                    $this->response['status'] = 500;
                    $this->response['message'] = 'registrant data failed to remove!';
                }
            } catch (\Throwable $throwable){
                $this->response['status'] = 500;
                $this->response['message'] = $throwable->getMessage();
            }
        }

        return response()->json($this->response);
    }
}
