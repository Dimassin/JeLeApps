<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Models\User;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();
        try {
            User::create([
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'gender' => $validatedData['gender']
            ]);

            return response()->json('Новый profile добавлен', 201);

        } catch (QueryException $ex) {
            return response()->json(['error' => 'Ошибка базы данных: ' . $ex->getMessage()], 500);
        } catch (\Exception $ex) {
            return response()->json(['error' => 'Ошибка: ' . $ex->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try
        {
            $user = User::findOrFail($id);

            return response()->json(['email' => $user->email, 'gender' => $user->gender]);

        } catch (QueryException $ex) {
            return response()->json(['error' => 'Ошибка базы данных: ' . $ex->getMessage()], 500);
        } catch (\Exception $ex) {
            return response()->json(['error' => 'Ошибка: ' . $ex->getMessage()], 500);
        }
    }
}
