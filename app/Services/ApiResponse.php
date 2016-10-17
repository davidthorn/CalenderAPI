<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;
use Dingo\Api\Http\Response;
use Dingo\Api\Transformer\Binding;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiResponse extends Response
{
    protected $data = null;

    protected $meta = [];

    public function __construct($data = null, $status = 200, $headers = [], Binding $binding = null)
    {
        parent::__construct($data, $status, $headers, $binding);

        $this->data = $data;
    }

    public function with($data)
    {
        $this->setContent($data);
        $this->data = $data;

        return $this;
    }

    public function transformWith($transformer)
    {
        if ($this->data instanceof Paginator || $this->data instanceof Collection) {
            if ($this->data->isEmpty()) {
                $class = get_class($this->data);
            } else {
                $class = get_class($this->data->first());
            }
        } else {
            $class = get_class($this->data);
        }

        $binding = $this::getTransformer()->register($class, $transformer);

        $binding->setMeta($this->meta);

        return new self($this->data, $this->getStatusCode(), $this->headers->all(), $binding);
    }

    public function setMeta(array $meta)
    {
        $this->meta = $meta;

        return $this;
    }

    public function created($location = null)
    {
        $this->setStatusCode(self::HTTP_CREATED);

        if (! is_null($location)) {
            $this->header('Location', $location);
        }

        return $this;
    }

    public function accepted($location = null)
    {
        $this->setStatusCode(self::HTTP_ACCEPTED);

        if (! is_null($location)) {
            $this->header('Location', $location);
        }

        return $this;
    }

    public function noContent()
    {
        $this->setStatusCode(self::HTTP_NO_CONTENT);

        return $this;
    }

    /**
     * @param $message
     * @param $statusCode
     */
    public function error($message, $statusCode)
    {
        throw new HttpException($statusCode, $message);
    }

    /**
     * @param string $message
     */
    public function errorInternal($message = 'Internal Error')
    {
        $this->error($message, 500);
    }

    /**
     * @param string $message
     */
    public function errorNotFound($message = 'Not Found')
    {
        $this->error($message, self::HTTP_NOT_FOUND);
    }

    /**
     * @param string $message
     */
    public function errorBadRequest($message = 'Bad Request')
    {
        $this->error($message, self::HTTP_BAD_REQUEST);
    }

    /**
     * @param string $message
     */
    public function errorForbidden($message = 'Forbidden')
    {
        $this->error($message, self::HTTP_FORBIDDEN);
    }

    /**
     * @param string $message
     */
    public function errorUnauthorized($message = 'Unauthorized')
    {
        $this->error($message, self::HTTP_UNAUTHORIZED);
    }

    public function errorMethodNotAllowed($message = 'Method Not Allowed')
    {
        $this->error($message, self::HTTP_METHOD_NOT_ALLOWED);
    }
}
