<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Terms and Conditions</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h1 class="card-title">Terms and Conditions</h1>
        <p class="text-muted">Last updated: {{ now()->format('F d, Y') }}</p>
        <hr>

        <h3>1. Introduction</h3>
        <p>Welcome to our website. By accessing and using this site, you agree to comply with and be bound by the following terms and conditions.</p>

        <h3>2. Use of the Website</h3>
        <p>You agree to use this website only for lawful purposes and in a manner that does not infringe upon the rights of others.</p>

        <h3>3. Privacy Policy</h3>
        <p>We are committed to protecting your privacy. Please review our Privacy Policy for details on how we collect and use your data.</p>

        <h3>4. Changes to Terms</h3>
        <p>We reserve the right to modify these terms at any time. Any changes will be posted on this page.</p>

        <h3>5. Contact Us</h3>
        <p>If you have any questions about these Terms, please contact us at <a href="mailto:support@example.com">support@example.com</a>.</p>

        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Back to Home</a>
      </div>
    </div>
  </div>
</body>

</html>