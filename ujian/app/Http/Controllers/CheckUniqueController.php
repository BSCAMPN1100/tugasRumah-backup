<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckUniqueController extends Controller
{
    public function check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'model' => 'required|in:barang,supplier,user',
            'field' => 'required|string',
            'value' => 'required|string',
            'exclude_id' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Parameter tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        $model = $request->model;
        $field = $request->field;
        $value = $request->value;
        $excludeId = $request->exclude_id;

        $query = null;

        switch ($model) {
            case 'barang':
                if ($field !== 'nama') {
                    return response()->json(['error' => 'Field tidak diizinkan'], 400);
                }
                $query = Barang::where($field, $value);
                break;

            case 'supplier':
                if ($field !== 'nama') {
                    return response()->json(['error' => 'Field tidak diizinkan'], 400);
                }
                // Hanya cek supplier aktif (belum di-soft delete)
                $query = Supplier::where($field, $value)->whereNull('deleted_at');
                break;

            case 'user':
                if ($field !== 'email') {
                    return response()->json(['error' => 'Field tidak diizinkan'], 400);
                }
                // Hanya cek user aktif (belum di-soft delete)
                $query = User::where($field, $value)->whereNull('deleted_at');
                break;
        }

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        $exists = $query->exists();

        return response()->json([
            'is_unique' => !$exists,
            'value' => $value,
        ]);
    }
}
