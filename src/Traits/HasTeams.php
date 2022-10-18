<?php

namespace LaravelGreatApi\Access\Traits;

use LaravelGreatApi\Access\Models\Team;

trait HasTeams
{
    /**
     * Undocumented function
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'user_teams', 'user_id', 'team_id');
    }

    /**
     * Undocumented function
     *
     * @param string|array $teams
     * @return boolean
     */
    public function hasTeam(string|array $teams): bool
    {
        return $this->whereHas('teams', fn($q) => $q->whereIn('slug', $this->getArgs($teams)))->exists();
    }

    /**
     * Undocumented function
     *
     * @param string|array $permissions
     * @return boolean
     */
    public function hasTeamsPermissions(string|array $permissions): bool
    {
        return $this->teams()->whereHas('permissions', fn($q) => $q->whereIn('slug', $this->getArgs($permissions)))->exists();
    }

    /**
     * Undocumented function
     *
     * @param string|Team $team
     * @return array
     */
    public function assignTeam(string|Team $team): array
    {
        $team = is_string($team) ? Team::where('slug', $team)->first() : $team;

        return $this->teams()->syncWithoutDetaching($team ? $team->id : []);
    }
}
