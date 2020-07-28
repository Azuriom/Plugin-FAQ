<?php

namespace Azuriom\Plugin\FAQ\Models;

use Azuriom\Models\Traits\HasMarkdown;
use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $answer
 * @property int $position
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Question extends Model
{
    use HasTablePrefix;
    use HasMarkdown;

    /**
     * The table prefix associated with the model.
     *
     * @var string
     */
    protected $prefix = 'faq_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'answer', 'position',
    ];

    public function parseAnswer()
    {
        return $this->parseMarkdown('answer');
    }
}
