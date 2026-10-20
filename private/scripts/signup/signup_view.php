<?php

declare(strict_types=1);

function signup_inputs() {
    echo '<input type="text" name="email" placeholder="E-Mail">';


    echo '<input type="hidden" name="request" value="signup">';
    echo '<input type="hidden" name="redirect" value="signup">';
}