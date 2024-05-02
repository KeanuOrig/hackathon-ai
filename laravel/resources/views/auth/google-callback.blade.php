<html>
<head>
  <meta charset="utf-8">
  <title>Callback</title>
  <script>
    let data = {
      type: "success",
      data: {
          google: {
            profile_picture: "{{ $data['google']['profile_picture'] }}",
            email_verified: "{{ $data['google']['email_verified'] }}",
            email: "{{ $data['google']['email'] }}",
          }
      }
    }
    console.log(data);
    window.opener.postMessage(data, '{{env("FRONTEND_URL")}}');
    window.close();

  </script>
</head>
<body>
</body>
</html>
