<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Help Desk | En construcción</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #0f172a, #1e293b);
        min-height: 100vh;
        color: white;
    }

    .navbar {
        background: rgba(0, 0, 0, 0.25);
        backdrop-filter: blur(6px);
    }

    .logo-box img {
        height: 40px;
        margin-right: 20px;
    }

    .main-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 60px;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }

    .title {
        font-weight: 600;
        font-size: 42px;
    }

    .subtitle {
        opacity: .8;
        font-size: 18px;
    }

    .icon {
        font-size: 70px;
        margin-bottom: 20px;
    }

    .footer {
        opacity: .6;
        font-size: 14px;
    }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg py-3">
        <div class="container">

            <div class="logo-box d-flex align-items-center">


            </div>

            <span class="text-white fw-semibold">
               Help Desk
            </span>

        </div>
    </nav>


    <!-- CONTENIDO -->
    <div class="container d-flex justify-content-center align-items-center" style="height:85vh;">

        <div class="main-card">



            <h1 class="title">
                Mega travel Help Desk
            </h1>

            <p class="subtitle mt-3">
                Estamos trabajando para construir una mejor plataforma de gestión.
            </p>

            <p class="mt-3">
                El sistema se encuentra actualmente en desarrollo.
            </p>

            <div class="mt-4">
                <span class="badge bg-warning text-dark p-2">
                    Sitio en construcción
                </span>
            </div>

            <hr class="my-4">

            <p class="footer">
                © {{ date('Y') }} Mega travel — Help Desk 
            </p>

        </div>

    </div>

</body>

</html>