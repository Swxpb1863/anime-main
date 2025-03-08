<?php

    session_start();
    session_unset();
    session_destroy();
    define("APPURL","http://localhost/anime-main");
    header("Location: ".APPURL."");

