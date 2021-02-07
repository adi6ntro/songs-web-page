<?php

function echo_secure($str){
    echo htmlentities($str, ENT_QUOTES, 'UTF-8');
}
