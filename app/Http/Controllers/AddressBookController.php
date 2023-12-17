<?php

namespace App\Http\Controllers;

use App\Models\AddressBook;
use Illuminate\Http\Request;
use App\Http\Requests\AddressBookStoreRequest;
use Illuminate\Support\Facades\Validator;

class AddressBookController extends Controller
{
    public function list(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $query = AddressBook::query();

            if ($request->has('search')) {
                $searchValue = $request->input('search');
                $query->where(function ($q) use ($searchValue) {
                    $q->where('name', 'like', '%' . $searchValue . '%')
                        ->orWhere('phone', 'like', '%' . $searchValue . '%')
                        ->orWhere('email', 'like', '%' . $searchValue . '%')
                        ->orWhere('website', 'like', '%' . $searchValue . '%')
                        ->orWhere('gender', 'like', '%' . $searchValue . '%')
                        ->orWhere('age', 'like', '%' . $searchValue . '%')
                        ->orWhere('nationality', 'like', '%' . $searchValue . '%');
                });
            }

            $query->orderBy('id','DESC');

            $list = $request->perPage ?  $query->paginate($request->input('perPage', 10)) : $query->get();

            $response = responseFormat('success', $list);
        } catch (\Exception $exception) {
            $response = responseFormat('error', $exception->getMessage(), ['code' => $exception->getCode()]);
        }

        return response()->json($response,200);
    }

    public function store(AddressBookStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        try {

            AddressBook::updateOrCreate(
                ['id' => $request->id],
                [
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'website' => $request->website,
                    'gender' => $request->gender,
                    'age' => $request->age,
                    'nationality' => $request->nationality,
                    'created_by' => $request->created_by,
                ]
            );

            $msg = $request->id ? 'Update' : 'Create';

            $response = responseFormat('success', $msg.' Successfully');

        } catch (\Exception $exception) {
            $response = responseFormat('error', $exception->getMessage(), ['code' => $exception->getCode()]);
        }

        return response()->json($response);
    }

    public function delete(Request $request): \Illuminate\Http\JsonResponse
    {
        Validator::make($request->all(), [
            'id' => 'required',
        ])->validate();

        try {

            AddressBook::find($request->id)->delete();

            $response = responseFormat('success', 'Delete Successfully');

        } catch (\Exception $exception) {
            $response = responseFormat('error', $exception->getMessage(), ['code' => $exception->getCode()]);
        }

        return response()->json($response);
    }
}
