<?php

function normalizeName($name) {
    return str_replace(' ', '-', preg_replace('/[^\d\sa-z]+/i', '', preg_replace("/&([a-z])[a-z]+;/i", "$1", strtolower(htmlentities(html_entity_decode($name))))));
}

function getStub($type) {
    return __DIR__ . "/stubs/$type.stub";
}
