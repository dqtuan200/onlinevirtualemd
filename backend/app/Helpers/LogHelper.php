<?php

namespace App\Helpers;

class LogHelper
{
  public static function console($message)
  {
    $output = date('[Y-m-d H:i:s] ') . $message . PHP_EOL;
    file_put_contents('php://stdout', $output);
  }

  public static function consoleError($message)
  {
    $output = date('[Y-m-d H:i:s] ') . 'ERROR: ' . $message . PHP_EOL;
    file_put_contents('php://stderr', $output);
  }
}