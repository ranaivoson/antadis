<?php

interface UserDatabaseInterface
{
    public function findOneByUsernameAndPasswordAndGroup(string $username, string $password, string $groupName);
    public function updateUserLastLogin(User $user);
}