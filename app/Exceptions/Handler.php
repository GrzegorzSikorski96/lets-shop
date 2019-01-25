<?php

namespace App\Exceptions;

use Exception;
use App\Helpers\APIResponse;
use Illuminate\Contracts\Container\Container;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    protected $response;

    public function __construct(Container $container, APIResponse $response)
    {
        $this->response = $response;
        parent::__construct($container);
    }

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof UnauthorizedHttpException) {
            return $this->response
                ->setMessage($exception->getMessage())
                ->setFailureStatus(401)
                ->getResponse();
        }

        return parent::render($request, $exception);
    }
}
