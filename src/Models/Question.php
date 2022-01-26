<?php

namespace Azuriom\Plugin\FAQ\Models;

use Azuriom\Models\Traits\Attachable;
use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

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
    use Attachable;
    use HasTablePrefix;

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

    public function getAttachmentsKey()
    {
        return 'answer';
    }

    public function getAttachmentsPath()
    {
        return 'faq/questions/attachments';
    }

    public function parseAnswer()
    {
        return new HtmlString($this->answer);
    }
}
