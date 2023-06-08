<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($request->header('X-Inertia')) {
            if ($e instanceof ValidationException) {
                return redirect()->back()->withInput()->withErrors($e->errors());
            }
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->with('errorId', uniqid());
        }

        if ($e instanceof AuthorizationException) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }

        return parent::render($request, $e);
    }
}
