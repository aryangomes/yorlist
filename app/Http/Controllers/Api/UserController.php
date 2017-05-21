<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function update(Request $request){

        $user = User::where('id', app('Dingo\Api\Auth\Auth')->user()->id)->first();

        if (!isset($user)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        $user->update($request->all());

        return response()->json('ok', 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {

        $list = User::findOrFail(app('Dingo\Api\Auth\Auth')->user()->id);

        if (!isset($list)) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        $list->delete();

        return response()->json([
            'message' => 'Record removed!',
        ], 201);
    }
}
