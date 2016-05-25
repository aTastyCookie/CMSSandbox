<?php require_once 'admin/include/init.php'; ?>
<?php Tools::controller(); ?>
<!doctype html>
<html>
  <head>
    <title>Sandbox | Welcome</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="admin/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="admin/bootstrap/css/custom.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">           
    <?php global $content; ?>
    
    <?php if (!empty($content['prereqs'])): ?>
        <div class="alert alert-danger">
            <ul><h4>Requirements</h4>
        <?php foreach($content['prereqs'] as $prereq): ?>
            <li><?php echo $prereq;?></li>
        <?php endforeach; ?>
            </ul></div>
    <?php endif; ?>
    
    
    <?php if (!empty($content['message'])): ?>
    <div class="alert alert-danger"><?php echo $content['message'];?></div>
  <?php endif; ?>

  <div id="logo"><img src="admin/bootstrap/img/sandbox-logo.png" alt="Let's play in the sand!"/>
  <small class="version"><?php echo Tools::getversion(); ?></small>
  </div>       
  <?php Tools::view(); ?>
    
    
</div>
  <script src="admin/jquery/jquery-1.10.2.js"></script>
  <script src="admin/bootstrap/js/bootstrap.js"></script>	
</body>
</html>