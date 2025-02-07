<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Authentification</title>
  <link rel="stylesheet" href="/css/linReg.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>

  <div class="auth-container">
    <!-- Côté gauche : Formulaire d'inscription -->
    <div class="auth-register">
      <h2>Register</h2>
      <form action="#" method="POST">
        <label for="username-register">Username</label>
        <input type="text" id="username-register" name="username" required placeholder="Username">

        <label for="email-register">Email</label>
        <input type="email" id="email-register" name="email" required placeholder="Email">

        <label for="password-register">Password</label>
        <input type="password" id="password-register" name="password" required placeholder="Password">

        <label for="confirm-password-register">Confirm Password</label>
        <input type="password" id="confirm-password-register" name="confirm-password" required placeholder="Confirm Password">

        <button type="submit" class="build">Register</button>
      </form>
    </div>

    <!-- Côté droit : Formulaire de connexion -->
    <div class="auth-login">
      <h2>Log-In</h2>
     
        <label for="username-login">Username</label>
        <input type="text" id="username-login" name="username" required placeholder="Username">

        <label for="password-login">Password</label>
        <input type="password" id="password-login" name="password" required placeholder="Password">
        <form action="/dashboard" method="GET">
        <button type="submit" class="build">Log-in</button>
        </form>
        <form action="/linReg" method="GET">
        <button class="build">forgot password ?</button>
      </form>
    </div>
  </div>
</body>
</html>