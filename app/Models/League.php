<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class League
 * @package App\Models
 * @property $id
 * @property $facility_id
 * @property $title
 * @property $image_url
 * @property $start_date
 * @property $end_date
 * @property $week_count
 * @property $max_team_count
 * @property $min_player_count
 * @property $cost
 * @property $awards
 * @property $is_started
 * @property $is_open
 */
class League extends Model
{
    protected $table = 'leagues';

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }

    public function applications()
    {
        return $this->hasMany(LeagueApplication::class, 'league_id');
    }

    public function fixture()
    {
        return $this->hasMany(LeagueFixture::class, 'league_id');
    }

    public function fixtureByWeek($week_number)
    {
        return $this->hasMany(LeagueFixture::class, 'league_id')
            ->where('week_number', $week_number)
            ->orderBy('id', 'asc')
            ->get();
    }

    public function weeks()
    {
        return $this->hasMany(LeagueFixture::class, 'league_id')
            ->orderBy('week_number')
            ->groupBy('week_number')
            ->select(['week_number'])
            ->get();
    }

    public function applied($player_id)
    {
        $application = $this->applications()->where('player_id', '=', $player_id)->first();
        return ($application) ? true : false;
    }

    public function allow_application_for_limit()
    {
        $application_count = $this->applications()->count();
        return ($application_count < $this->max_team_count) ? true : false;
    }

}
