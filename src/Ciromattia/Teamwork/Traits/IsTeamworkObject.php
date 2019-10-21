<?php

namespace Ciromattia\Teamwork\Traits;

use Carbon\Carbon;
use Ciromattia\Teamwork\Facades\Teamwork;

trait IsTeamworkObject
{
    public static function findByTeamworkId($id, $withTrashed = false)
    {
        if ($withTrashed) {
            $mytraits = class_uses(self::class);
            if (isset($mytraits['SoftDeletes'])) {
                return self::withTrashed()
                    ->where('teamwork_id', $id)
                    ->first();
            }
        }
        return self::where('teamwork_id', $id)
            ->first();
    }

    public function hasTeamworkLink()
    {
        return !empty($this->teamwork_id);
    }

    public function setTeamworkObjectAttribute($value)
    {
        $this->attributes['teamwork_id'] = $value->id;
    }

    public function getTeamworkObjectAttribute()
    {
        if (!empty($this->teamwork_id)) {
            $twitem = Teamwork::{$this->twobjectname}($this->teamwork_id)->find();
            return $twitem;
        }
        return null;
    }

    public function getTeamworkLinkAttribute()
    {
        return null;
    }

    public function getTeamworkObjects()
    {
        return Teamwork::{$this->twobjectname}()->all();
    }

    /**
     * Getter for Teamwork object (should be overridden).
     *
     * @return mixed
     */
    public function getTeamworkObject()
    {
        return Teamwork::{$this->twobjectname}($this->teamwork_id)->all();
    }

    /**
     * Setter for Teamwork object (should be overridden).
     * @param $twobj
     */
    public function setTeamworkObject($twobj)
    {
        $this->teamwork_id = $twobj->id;
    }

    /**
     * Updates remote Teamwork object with this object's attributes.
     * Should be overwritten.
     * @param $twobj
     */
    public function pushTeamworkObject()
    {
    }

    /**
     * Updates this object's attributes with remote Teamwork object.
     * Should be overwritten.
     * @param $twobj
     */
    public function pullTeamworkObject()
    {
    }

    /**
     * Pushes or pulls from Teamwork by checking last updated timestamp.
     * @param $twobj
     * @throws \Exception
     */
    public function syncTeamworkObject($twobj = null)
    {
        if (empty($twobj)) {
            if (!$this->teamwork_id) {
                throw new \Exception('ID not set');
            } else {
                $twobj = $this->getTeamworkObject();
            }
        }
        $twlast = new Carbon($twobj->{'last-changed-on'});
        $mylast = $this->updated_at;
        if ($twlast > $mylast) {
            // Teamwork object has been updated more recently
            $this->pullTeamworkObject();
        } else {
            // Our object has been updated more recently, send changes to Teamwork
            // TODO: send changes to Teamwork
        }
    }
}