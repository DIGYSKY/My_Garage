<?php

class Answer
{
  private $message;
  private $status;
  private $data;

  public function prepare($message, $status, $data)
  {
    $this->message = $message;
    $this->status = $status;
    $this->data = $data;
  }

  public function getMessage()
  {
    return $this->message;
  }

  public function getStatus()
  {
    return $this->status;
  }

  public function getData()
  {
    return $this->data;
  }

  public function sending()
  {
    http_response_code($this->status);
    echo json_encode([
      'message' => $this->message,
      'status' => $this->status,
      'data' => $this->data
    ]);
  }
}
