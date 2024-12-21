<?php

declare(strict_types=1);

class SieveOfEratosthenes
{
  private int $sieve_size;
  private int $rawbits_size;
  private string $rawbits;

  public static array $primeCounts = [
    10 => 4,
    100 => 25,
    1000 => 168,
    10000 => 1229,
    100000 => 9592,
    1000000 => 78498,
    10000000 => 664579,
    100000000 => 5761455
  ];

  public function __construct()
  {
    $this->sieve_size = 100000;
    $this->rawbits_size = ($this->sieve_size + 1) >> 1;
    $this->rawbits = str_pad('', $this->rawbits_size, '0');
  }

  public function run(): void
  {
    $factor = 3;
    $q = sqrt($this->sieve_size);
    while ($factor < $q) {
      for ($i = $factor; $i <= $this->sieve_size; $i += 2) {
        $rbi = $i >> 1;
        if ($this->rawbits[$rbi] === '0') {
          $factor = $i;
          break;
        }
      }

      $ft2 = $factor;
      $start = ($factor * $factor) >> 1;
      for ($i = $start; $i < $this->rawbits_size; $i += $ft2) {
        $this->rawbits[$i] = '1';
      }

      $factor += 2;
    }
  }

  public function get_rawbit_count(): int
  {
    return substr_count($this->rawbits, '0');
  }

  public function print_results(): void
  {
    for ($i = 1; $i < $this->sieve_size; $i += 2) {
      if ($this->rawbits[$i >> 1] === '0') {
        echo $i . ", ";
      }
    }
  }
}

$start = microtime(true);
$passes = 0;
$sieve_size = 1000000;
$print_results = false;
$rawbit_count = 0;
$run_time = 5;

while (time_diff($start) < $run_time * 1000) {
  $sieve = new SieveOfEratosthenes();
  $sieve->run();
  $passes++;
}

$rawbit_count = $sieve->get_rawbit_count();
if ($print_results) {
  $sieve->print_results();
  echo "\n";
}

$td = time_diff($start);

printf(
  "Passes: %d, Time: %dms, Avg: %dms, Limit: %d, Count: %d, Valid: %s",
  $passes,
  (int)$td,
  $td / $passes,
  $sieve_size,
  $rawbit_count,
  (validate_result($sieve_size) === $rawbit_count) ? 'True' : 'False'
);

echo "\n\n";
printf("andrewthecoder;%d;%f;1;algorithm=base,faithful=yes,bits=8\n", $passes, ((float)$td) / 1000);

function time_diff(float $start): float
{
  return (microtime(true) - $start) * 1000;
}

function validate_result($sieve_size): ?int
{
  return SieveOfEratosthenes::$primeCounts[$sieve_size];
}
