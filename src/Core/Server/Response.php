<?php

namespace Core\Server;

class Response{
    private int $statusCode = 200;
    private array $data = [];
    private bool $success = true;
    private string $message = '';

    public function setSuccess(mixed $data = null, string $message = ''): void{
        $this->success = true;
        $this->statusCode = 200;
        $this->data = $data ?? [];
        $this->message = $message;
    }

    public function setError(\Throwable $error, int $status = 500): void{
        $this->success = false;
        $this->statusCode = $status;
        $this->data = [
            'error' => $error->getMessage(),
            'file' => $error->getFile(),
            'line' => $error->getLine()
        ];
        $this->message = 'An error occurred';
    }

    public function setStatus(int $code, string $message = ''): void{
        $this->statusCode = $code;
        $this->message = $message;
    }

    public function getStatusCode(): int{
        return $this->statusCode;
    }

    public function toArray(): array{
        return [
            'success' => $this->success,
            'status' => $this->statusCode,
            'message' => $this->message,
            'data' => $this->data,
        ];
    }

    public function toJson(): string{
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE);
    }
}