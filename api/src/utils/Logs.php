<?php

class Logs
{
  private string $logFile;
  private bool $dateTime;

  /**
   * Constructor
   * @param string $logFile Path to log file
   * @param bool $dateTime Include datetime in logs (default: true)
   */
  public function __construct(string $logFile = 'app.log', bool $dateTime = true)
  {
    // Create logs directory if it doesn't exist
    $logsDir = dirname(__DIR__, 2) . '/logs';
    if (!is_dir($logsDir)) {
      mkdir($logsDir, 0777, true);
    }

    $this->logFile = $logsDir . '/' . $logFile;
    $this->dateTime = $dateTime;
  }

  private function getCallerInfo()
  {
    $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 4);
    // On remonte à l'appelant de l'appelant de l'appelant
    $caller = isset($backtrace[3]) ? $backtrace[3] : (isset($backtrace[2]) ? $backtrace[2] : $backtrace[1]);
    return [
      'file' => basename($caller['file']),
      'line' => $caller['line']
    ];
  }

  /**
   * Write a message to the log file
   * @param string $message Message to log
   * @param string $level Log level (INFO, ERROR, WARNING, etc.)
   * @return bool Success status
   */
  public function write(string $message, string $level = 'INFO'): bool
  {
    try {
      $logMessage = $this->formatMessage($message, $level);
      return file_put_contents($this->logFile, $logMessage, FILE_APPEND) !== false;
    } catch (\Exception $e) {
      return false;
    }
  }

  /**
   * Format the log message
   * @param string $message Original message
   * @param string $level Log level
   * @return string Formatted message
   */
  private function formatMessage(string $message, string $level): string
  {
    $caller = $this->getCallerInfo();
    $level = strtoupper($level);
    $dateTime = $this->dateTime ? '[' . date('Y-m-d H:i:s') . '] ' : '';
    return sprintf(
      "%s[%s] [%s:%d] %s" . PHP_EOL,
      $dateTime,
      $level,
      $caller['file'],
      $caller['line'],
      $message
    );
  }

  /**
   * Convenience method for info logs
   * @param string $message Message to log
   * @return bool Success status
   */
  public function info(string $message): bool
  {
    return $this->write($message, 'INFO');
  }

  /**
   * Convenience method for error logs
   * @param string $message Message to log
   * @return bool Success status
   */
  public function error(string $message): bool
  {
    return $this->write($message, 'ERROR');
  }

  /**
   * Convenience method for warning logs
   * @param string $message Message to log
   * @return bool Success status
   */
  public function warning(string $message): bool
  {
    return $this->write($message, 'WARNING');
  }

  /**
   * Log a variable with its name, file and line number
   * @param mixed $variable Variable to log
   * @param string $name Name of the variable
   * @return bool Success status
   */
  public function logVariable($variable, $name): bool
  {
    $message = sprintf(
      "%s: %s",
      $name,
      print_r($variable, true)
    );

    return $this->write($message, 'INFO');
  }
}
