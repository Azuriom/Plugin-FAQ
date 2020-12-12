<?php

use Azuriom\Plugin\FAQ\Models\Question;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SwitchToSpatieTranslationsFaq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faq_questions', function (Blueprint $table) {
            $table->text('name')->change();
        });

        $locale = App::getLocale();

        $rawModels = DB::table('faq_questions')->get();
        foreach ($rawModels as $key => $question) {
            $question = Question::find($question->id);
            $question
                ->setTranslation('name', $locale, $rawModels[$key]->name)
                ->setTranslation('answer', $locale, $rawModels[$key]->answer)
                ->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
