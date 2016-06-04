<?php

namespace App\Exceptions;

use App\Traits\ReturnsHttpResponse;
use Aws\Sqs\Exception\SqsException;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    use ReturnsHttpResponse;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        if ($e instanceof SqsException) {
            // consider refactoring the NotifyAdmins listener to accept a more generic event
            // and then fire an event from here called `SqsExceptionEncountered`, or maybe
            // create a job that is a generic "Notify Admins" that both the `NotifyAdmins` and
            // this report can hand off to.
            // Regardless of how you accomplish it, you shouldn't pack all of this in here.
            Mail::raw(sprintf('There was an sqs exception at %s. Message: %s', Carbon::now(), $e->getMessage()), function ($m) {
                $m->to('schmitz.chris@gmail.com', "Chris Schmitz")
                    ->from('chris.schmitz.dev@gmail.com', "Slack Signup demo")
                    ->subject('SQS Exception');
            });
        }
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $message = $e->getMessage();
        if ($e instanceof FatalErrorException || $e instanceof SqsException) {
            $message = config("messages.exceptions.internalError");
        }

        if ($request->wantsJson()) {
            return $this->response($message, 500);
        }
        return parent::render($request, $e);
    }
}
