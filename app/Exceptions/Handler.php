<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
//
//      TODO: this breaks error handling
//    /**
//     * Render an exception into an HTTP response.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \Throwable  $e
//     * @return \Symfony\Component\HttpFoundation\Response
//     *
//     * @throws \Throwable
//     */
//    public function render($request, Throwable $e) {
//        if ($this->isHttpException($e)) {
//            return response()->view('dist.404');
//        } else {
//            parent::render($request, $e);
//        }
//    }

}
