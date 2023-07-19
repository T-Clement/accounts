<?php


// color of row ->bg-success for add    bg-success-subtle
                // ->bg-danger for remove    bg-warning-subtle
function applyColorToOperation($number) {
    if ($number > 0) {
        return "bg-success-subtle";
    } elseif ($number < 0) {
        return "bg-warning-subtle";
    }
}

                