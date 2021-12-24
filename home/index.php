<!doctype html>
<html lang="ja" >
  <head>
    <title>Top navbar example for Bootstrap · Bootstrap</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="navbar-top.css" rel="stylesheet">
  </head>
  <body >
    <a id="skippy" class="sr-only sr-only-focusable" href="#content">
  <div class="container">
    <span class="skiplink-text">Skip to main content</span>
  </div>
</a>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
  <a class="navbar-brand" href="#">Top navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>

    <li class="nav-item dropdown">
      <a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="lang" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        氏名
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="lang">
        <a class="dropdown-item active" href="#">ホーム</a>
        <a id="en" class="dropdown-item" href="#">アカウント</a>
        <a id="en" class="dropdown-item" href="#">ログアウト</a>
      </div>
    </li>
    
  </div>
</nav>

<main role="main" class="container">
 

</main>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script>
  window.jQuery || document.write('<script src="/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')
</script><script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script><script src="/docs/4.3/assets/js/vendor/anchor.min.js"></script>
<script src="/docs/4.3/assets/js/vendor/clipboard.min.js"></script>
<script src="/docs/4.3/assets/js/vendor/bs-custom-file-input.min.js"></script>
<script src="/docs/4.3/assets/js/src/application.js"></script>
<script src="/docs/4.3/assets/js/src/search.js"></script>
<script src="/docs/4.3/assets/js/src/ie-emulation-modes-warning.js"></script>
  </body>
</html>