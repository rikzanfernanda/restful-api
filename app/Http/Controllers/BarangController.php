<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    private $response = [];
    private $validation_rules = [
        'name' => 'required|max:255',
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
            $this->response['result'] = Barang::all();
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
                $barang = new Barang();
                $barang->name = $request->name;

                if ($barang->save()){
                    $this->response['message'] = 'barang data saved successfully!';
                } else {
                    $this->response['status'] = 500;
                    $this->response['message'] = 'barang data failed to save!';
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
                $this->response['result'] = Barang::find($id);
            } catch (\Throwable $throwable){
                $this->response['status'] = 500;
                $this->response['message'] = $throwable->getMessage();
            }
        }

        return response()->json($this->response);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->getValidationFactory()->make($request->post(), $this->validation_rules);

        if ($validator->fails()){
            $this->response['status'] = 422;
            $this->response['message'] = $validator->errors();
        } else {
            try {
                $barang = Barang::find($id);
                $barang->name = $request->name;

                if ($barang->save()){
                    $this->response['message'] = 'barang data has been successfully updated!';
                } else {
                    $this->response['status'] = 500;
                    $this->response['message'] = 'barang data failed to update!';
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
                $barang = Barang::find($id);
                if ($barang->delete()){
                    $this->response['message'] = 'barang data removed successfully!';
                } else {
                    $this->response['status'] = 500;
                    $this->response['message'] = 'barang data failed to remove!';
                }
            } catch (\Throwable $throwable){
                $this->response['status'] = 500;
                $this->response['message'] = $throwable->getMessage();
            }
        }

        return response()->json($this->response);
    }
}
