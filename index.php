<?php
function isNumber($v) { return is_numeric($v); }

$a = $_GET['a'] ?? '';
$b = $_GET['b'] ?? '';
$c = $_GET['c'] ?? '';
$hasInput = ($a !== '' && $b !== '' && $c !== '');

$error  = '';
$output = '';

if ($hasInput) {
  if (!isNumber($a) || !isNumber($b) || !isNumber($c)) {
    $error = "Please enter numeric values for a, b and c.";
  } elseif ((float)$a == 0.0) {
    $error = "a must not be 0 (division by zero).";
  } else {
    $python = '/usr/bin/python3';
    $script = __DIR__ . '/calculate.py';
    $cmd = escapeshellcmd($python) . ' ' . escapeshellarg($script) . ' ' .
           escapeshellarg($a) . ' ' . escapeshellarg($b) . ' ' . escapeshellarg($c);
    $output = shell_exec($cmd . ' 2>&1');
    if ($output === null) {
      $error = "Failed to execute Python script. Check php.ini (disable_functions) and file permissions.";
    }
  }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Python + PHP Calculator</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
  body{font-family:sans-serif;max-width:720px;margin:2rem auto;padding:0 1rem}
  form{display:grid;grid-template-columns:1fr 1fr;gap:.75rem;align-items:center}
  input{padding:.5rem}
  .btn{grid-column:1/-1;padding:.6rem 1rem}
  .result{margin-top:1rem;padding:1rem;border:1px solid #ddd;border-radius:8px;background:#f9f9f9}
  .error{color:#b00020;margin-top:1rem}
</style>
</head>
<body>
<h1>IST105 Assignment #2: Python &amp; PHP Calculator</h1>

<form method="get" action="">
  <label for="a">a</label>
  <input id="a" name="a" type="number" step="any" required value="<?= htmlspecialchars($a) ?>">
  <label for="b">b</label>
  <input id="b" name="b" type="number" step="any" required value="<?= htmlspecialchars($b) ?>">
  <label for="c">c</label>
  <input id="c" name="c" type="number" step="any" required value="<?= htmlspecialchars($c) ?>">
  <button class="btn" type="submit">Calculate</button>
</form>

<?php if ($error): ?>
  <div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if ($output): ?>
  <?= $output ?>
<?php endif; ?>

<hr>
<p>Server IP: <?= htmlspecialchars($_SERVER['SERVER_ADDR'] ?? 'unknown') ?></p>
</body>
</html>
