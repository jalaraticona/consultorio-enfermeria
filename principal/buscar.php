<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <title>Document</title>

      <script src="alertify/alertify.js"></script>
      <link rel="stylesheet" href="alertify/css/alertify.css">
      <link rel="stylesheet" href="alertify/css/themes/default.min.css">
      <link rel="stylesheet" href="alertify/css/themes/bootstrap.min.css">
      <link rel="stylesheet" href="alertify/css/themes/semantic.min.css">
</head>
<body>
<?php echo date("Y", strtotime($fecha)); ?>
<script type="text/javascript">
alertify.success('Success message');
</script>
<input type="button" name="" value="as" onclick="agregado()">
</body>
</html>
