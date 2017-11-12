<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>View Test</title>
</head>
<body>
  <h1>View test successful!</h1>
  <p>Hello <?php echo htmlspecialchars($name); ?>!</p>
  
  <ul>
    <?php foreach ($numbers as $number): ?>
      <li> <?php echo htmlspecialchars($number); ?> </li>
    <?php endforeach; ?>
  </ul>

</body>
</html>