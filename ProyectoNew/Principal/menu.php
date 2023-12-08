<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .navbar {
            background-color: rgb(27, 57, 106, .9);
            color: #fff;
            text-align: right;
            padding: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        .navbar ul {
            list-style: none;
            padding: 0;
            display: flex;
            gap: 15px;
        }

        .dropdown-container {
            position: fixed;
            top: 0;
            right: 0;
            height: 100%;
            width: 0;
            background-color: rgb(27, 57, 106, .9);
            overflow-x: hidden;
            transition: 0.5s;
            z-index: 1;
            padding-top: 60px;
        }

        .dropdown-container a {
            padding: 15px 20px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            transition: 0.3s;
        }

        .dropdown-container a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        #btnmulti {
            background: none;
            border: none;
            cursor: pointer;
            outline: none;
        }

        #btnmulti svg {
            fill: white;
        }
    </style>
    <link rel="stylesheet" href="../estilos/estilos.css">
    <link rel="icon" href="/favicon.ico">
</head>

<body>
    <?php session_start(); ?>
    <header class="navbar">
        <nav>
            <div>
                <ul>
                    <li><a href="../Principal/index.php">Home</a></li>
                    <?php
                    if (!isset($_SESSION['tipo_usuario'])) {
                        echo '<li><a href="../Login/Login.php">Inicio de Sesión</a></li>';
                        echo '<li><a href="../Login/Registro.php">Registro</a></li>';
                    }
                    // echo "Tipo de Usuario: " . $_SESSION["tipo_usuario"];

                    ?>

                    
                    <?php if (isset($_SESSION['tipo_usuario']) && ($_SESSION['tipo_usuario'] === 'coach')) : ?>
                        <li><a href="../Login/Equipos.php">Registra tu equipo</a></li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'coach') : ?>
                        <li><a href="../Vista/ListaEquipos.php">Lista Equipos</a></li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'administrador') : ?>
                        <button id="btnmulti" tabindex="0" type="button">
                            <span class="MuiIconButton-label">
                                <svg fill="white" width="26px" height="26px" viewBox="0 0 1024 1024" rotate="0">
                                    <path d="M128 768h768v-85.332h-768v85.332zM128 554.668h768v-85.334h-768v85.334zM128 256v85.33h768v-85.33h-768z"></path>
                                </svg>
                            </span>
                            <span class="MuiTouchRipple-root"></span>
                        </button>
                        <div class="dropdown-container" id="myDropdown">
                            <a href="../Vista/ListaAdmin.php">Lista Administradores</a>
                            <a href="../Vista/ListaEquipos.php">Lista Equipos</a>
                            <a href="../Vista/ListaCoach.php">Lista Coach</a>
                            <a href="../Vista/ListaInstituciones.php">Lista Instituciones</a>
                            <a href="../Vista/ListaAuxiliares.php">Lista Auxiliares</a>
                            <a href="../Vista/ListaConcursos.php">Lista Concursos</a>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['tipo_usuario'])) : ?>
                        <li><a href="../Login/Procesos/proceso_cerrar.php">Cerrar Sesión</a></li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'auxiliar') : ?>
                        <li><a href="../Vista/ListaConcursos.php">Lista Concursos</a></li>
                        <li><a href="../Vista/ListaEquipos.php">Lista Equipos</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>
    <script>
        document.getElementById("btnmulti").addEventListener("click", function(e) {
            e.stopPropagation();
            toggleDropdown();
        });
        document.addEventListener("click", function(e) {
            var dropdownContainer = document.getElementById("myDropdown");
            if (dropdownContainer.style.width === "250px" && !dropdownContainer.contains(e.target) && e.target.id !== "btnmulti") {
                dropdownContainer.style.width = "0";
            }
        });
        function toggleDropdown() {
            var dropdownContainer = document.getElementById("myDropdown");
            if (dropdownContainer.style.width === "250px") {
                dropdownContainer.style.width = "0";
            } else {
                dropdownContainer.style.width = "250px";
            }
        }
    </script>
</body>

</html>