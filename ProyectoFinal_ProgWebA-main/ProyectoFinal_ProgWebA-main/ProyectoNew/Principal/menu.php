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
</style>
<header class="navbar">
    <nav>
        <ul>
            <li><a href="../Principal/index.php">Home</a></li>
            <li><a href="../Login/Login.php">Inicio de Sesión</a></li>
            <li><a href="../Login/Registro.php">Registro</a></li>
        </ul>
    </nav>
    <button class="MuiButtonBase-root MuiIconButton-root" id="btnmulti" tabindex="0" type="button"><span class="MuiIconButton-label"><svg class="sc-bdVaJa fUuvxv" fill="white" width="26px" height="26px" viewBox="0 0 1024 1024" rotate="0">
                <path d="M128 768h768v-85.332h-768v85.332zM128 554.668h768v-85.334h-768v85.334zM128 256v85.33h768v-85.33h-768z">
                </path>
            </svg></span><span class="MuiTouchRipple-root"></span></button>
    <button id="theme-toggle" class="theme-toggle"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-brilliance" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16ZM1 8a7 7 0 0 0 7 7 3.5 3.5 0 1 0 0-7 3.5 3.5 0 1 1 0-7 7 7 0 0 0-7 7Z" />
        </svg></button>
</header>