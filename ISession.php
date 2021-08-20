<?php
interface ISession {
    function get(string $key);

    function set(string $key, $value);

    function isKeySet(string $key): bool;

    function clear();

    function isLoggedIn() : bool;
}
