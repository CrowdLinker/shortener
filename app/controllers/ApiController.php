<?php

class ApiController extends \BaseController {

    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(500)->respondWithError($message);
    }

    /**
     * @param $data
     * @param array $headers
     * @return mixed
     */
    public function respond($data, $headers = [])
    {
        return Response::json($data,$this->getStatusCode(),$headers);
    }

    /**
     * @param $message
     * @return mixed
     */
    public function respondWithError($message)
    {
        return $this->respond
            ([
                'error' => [
                    'message' => $message,
                    'status_code' => $this->getStatusCode()
                ]
            ]);
    }

    /**
     * @param $message
     * @return mixed
     */
    public function respondWithSuccess($message)
    {
        return $this->respond
            ([
                'success' => [
                    'message' => $message,
                    'status_code' => $this->getStatusCode()
                ]
            ]);
    }
}