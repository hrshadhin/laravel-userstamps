<?php

namespace Hrshadhin\Userstamps;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class UserstampsTrait
 *
 * @property int created_by
 * @property int updated_by
 * @property int deleted_by
 * @method   string getTable()
 * @method   void observe($observer)
 * @method   BelongsTo belongsTo($related, $foreignKey = null, $otherKey = null, $relation = null)
 * @package  Hrshadhin\Userstamps
 */

trait UserstampsTrait
{
    /**
     * Boot the userstamps trait for a model.
     *
     * @return void
     */
    public static function bootUserstampsTrait()
    {
        static::observe(new UserstampsTraitObserver);
    }

    /**
     * Get user model who created the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo($this->getUserInstance(), $this->getCreatedByColumn());
    }

    /**
     * Get column name for created by.
     *
     * @return string
     */
    protected function getCreatedByColumn()
    {
        return 'created_by';
    }

    /**
     * Get user model who updated the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updater()
    {
        return $this->belongsTo($this->getUserInstance(), $this->getUpdatedByColumn());
    }

    /**
     * Get column name for updated by.
     *
     * @return string
     */
    protected function getUpdatedByColumn()
    {
        return 'updated_by';
    }

    /**
     * Get user model who deleted the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deletor()
    {
        return $this->belongsTo($this->getUserInstance(), $this->getDeletedByColumn());
    }

    /**
     * Get column name for deleted by.
     *
     * @return string
     */
    protected function getDeletedByColumn()
    {
        return 'deleted_by';
    }

    /**
     * Get created by user name.
     *
     * @return string
     */
    public function getCreatedByNameAttribute()
    {
        if ($this->{$this->getCreatedByColumn()}) {
            $user = $this->getUserInstance()->find($this->{$this->getCreatedByColumn()});

            return $user->name;
        }

        return '';
    }

    /**
     * Get Laravel's user class instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getUserInstance()
    {
        $class = config('auth.providers.users.model', User::class);

        return new $class;
    }

    /**
     * Get updated by user name.
     *
     * @return string
     */
    public function getUpdatedByNameAttribute()
    {
        if ($this->{$this->getUpdatedByColumn()}) {
            $user = $this->getUserInstance()->find($this->{$this->getUpdatedByColumn()});

            return $user->name;
        }

        return '';
    }

    /**
     * Get deleted by user name.
     *
     * @return string
     */
    public function getDeletedByNameAttribute()
    {
        if ($this->{$this->getDeletedByColumn()}) {
            $user = $this->getUserInstance()->find($this->{$this->getDeletedByColumn()});

            return $user->name;
        }

        return '';
    }


    public function isCreator($user_id=null) {
        if( !isset($user_id) ) {
            $user_id == auth()->user()->id;
        }
        return $this->created_by == $user_id;
    }
    
}