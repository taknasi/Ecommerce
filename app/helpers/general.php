<?php

function getFolder()
{
    return app()->getLocale() === "ar" ? "css-rtl" : "css";
}

define('pagination_count',15);
