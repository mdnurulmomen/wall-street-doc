<?php

namespace App\Services;

interface UserServiceInterface
{
    function index();
    function store(array $data);
    function update(array $data, $id);
    function destroy($user);
    function trashed();
    function restore($user);
    function delete($user);
}
