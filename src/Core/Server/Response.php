<?php

namespace Core\Server;

class Response{
    private int $statusCode = 200;
    private array $data = [];
    private bool $success = true;
    private string $message = '';

    public function setSuccess(mixed $data = null, string $message = '', int $statusCode = 200): void{
        $this->success = true;
        $this->statusCode = $statusCode;
        $this->data = $data ?? [];
        $this->message = $message;
    }

    public function setError(array $errors, int $status = 500): void{
        $this->success = false;
        $this->statusCode = $status;
        $this->data = [
            'errors' => $errors
        ];
        $this->message = 'Ocorreu um erro';
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