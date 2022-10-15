<?php

namespace App\Repositories;

use App\Models\AppMember;

class AppMembersRepository
{
    /**
     * Save a token
     *
     * @param Array $data
     * @return void
     */
    public function setToken(array $data): void
    {
        $appToken = $data["appToken"];
        $appID = $data["appID"];

        AppMember::updateOrCreate(["appID" => $appID], ["appToken" => $appToken]);
    }

    public function updateSettings(array $data): void
    {
        $appID = $data["appID"];
        $notificationsInterval = $data["notificationsInterval"];
        $inCountries = $data["inCountries"] ?? null;

        $appMember = AppMember::where("appID", $appID)->firstOrFail();
        $appMember->notificationsInterval = $notificationsInterval;
        $appMember->inCountries = $inCountries;
        $appMember->save();
    }
}
