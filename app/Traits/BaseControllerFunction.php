<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

trait BaseControllerFunction
{
    /**
     * Redirect sukses dengan flash message.
     */
    public function redirectSuccess($route, $message = 'Proses berhasil.', $additionalParams = [])
    {
        Session::flash('success', $message);

        if (!empty($additionalParams)) {
            return Redirect::to($route)->with($additionalParams);
        }

        return Redirect::to($route);
    }

    /**
     * Redirect error dengan flash message.
     */
    public function redirectError($message = 'Terjadi kesalahan.', $additionalParams = [])
    {
        Session::flash('error', $message);

        return Redirect::back()->withInput()->with($additionalParams);
    }

    /**
     * Redirect error validasi input.
     */
    public function redirectValidationError($validator, $additionalParams = [])
    {
        return Redirect::back()
            ->withErrors($validator)
            ->withInput()
            ->with($additionalParams);
    }

    /**
     * Redirect error exception umum.
     */
    public function redirectException($e, $prefix = 'Error', $additionalParams = [])
    {
        $message = $prefix . ': ' . $e->getMessage();
        return $this->redirectError($message, $additionalParams);
    }

    /**
     * JSON response sukses.
     */
    public function jsonSuccess($data = [], $message = 'Proses berhasil.', $statusCode = 200, $additionalParams = [])
    {
        $response = [
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ];

        if (!empty($additionalParams)) {
            $response = array_merge($response, $additionalParams);
        }

        return response()->json($response, $statusCode);
    }

    /**
     * JSON response error validasi.
     */
    public function jsonValidationError($validator, $statusCode = 422, $additionalParams = [])
    {
        $response = [
            'status' => 'error',
            'message' => 'Validasi gagal.',
            'errors' => $validator->errors(),
        ];

        if (!empty($additionalParams)) {
            $response = array_merge($response, $additionalParams);
        }

        return response()->json($response, $statusCode);
    }

    /**
     * JSON response error/exception umum.
     */
    public function jsonError($e, $prefix = 'Error', $statusCode = 500, $additionalParams = [])
    {
        $response = [
            'status' => 'error',
            'message' => $prefix . ': ' . $e->getMessage(),
        ];

        if (!empty($additionalParams)) {
            $response = array_merge($response, $additionalParams);
        }

        return response()->json($response, $statusCode);
    }
}
