<?php

$connection = new mysqli(
    "localhost",
    "root",
    "",
    "todolist"
);

if ($connection->connect_error) {
    exit("Connection failed: {$connection->connect_error}");
}