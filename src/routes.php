<?php
use Illuminate\Support\Facades\Route;

Route::post('fmt/edgecontent/format/create',  'EdgeWizz\Edgecontent\Controllers\FormatController@store')->name('fmt.edgecontent.format.create');
Route::post('fmt/edgecontent/format/edit/{id}',  'EdgeWizz\Edgecontent\Controllers\FormatController@edit')->name('fmt.edgecontent.format.edit');
Route::any('fmt/edgecontent/format/delete/{id}',  'EdgeWizz\Edgecontent\Controllers\FormatController@delete')->name('fmt.edgecontent.format.delete');

Route::post('fmt/edgecontent/problem_set/create',  'EdgeWizz\Edgecontent\Controllers\ProblemSetController@store')->name('fmt.edgecontent.problem_set.create');
Route::post('fmt/edgecontent/problem_set/edit/{id}',  'EdgeWizz\Edgecontent\Controllers\ProblemSetController@edit')->name('fmt.edgecontent.problem_set.edit');
Route::post('fmt/edgecontent/problem_set/addmore/{id}',  'EdgeWizz\Edgecontent\Controllers\ProblemSetController@addMore')->name('fmt.edgecontent.problem_set.addmore');
Route::any('fmt/edgecontent/problem_set/delete/{id}',  'EdgeWizz\Edgecontent\Controllers\ProblemSetController@delete')->name('fmt.edgecontent.problem_set.delete');

Route::get('fmt/edgecontent/getQuestions/{id}', 'EdgeWizz\Edgecontent\Controllers\ProblemSetController@getQuestions');

// Route::get('/fmt/edgecontent/seed/formats_table', 'EdgeWizz\Edgecontent\Controllers\FormatController@seeder');

Route::get('fmt/edgecontent/question/toggle/{id}', 'EdgeWizz\Edgecontent\Controllers\ProblemSetController@toggleActive')->name('fmt.edgecontent.psq.toggle');
Route::POST('fmt/edgecontent/question/change_format_set/{id}', 'EdgeWizz\Edgecontent\Controllers\ProblemSetController@change_problem_set')->name('fmt.edgecontent.psq.change_problem_set');
Route::POST('fmt/edgecontent/question/change_format_set_multi', 'EdgeWizz\Edgecontent\Controllers\ProblemSetController@change_problem_set_multi')->name('fmt.edgecontent.psq.change_problem_set_multi');


Route::POST('fmt/edgecontent/getTopics', 'EdgeWizz\Edgecontent\Controllers\ProblemSetController@getTopics')->name('fmt.edgecontent.select.getTopics');
Route::POST('fmt/edgecontent/getChapters', 'EdgeWizz\Edgecontent\Controllers\ProblemSetController@getChapters')->name('fmt.edgecontent.select.getChapters');


Route::POST('fmt/edgecontent/getChapters_without_topic', 'EdgeWizz\Edgecontent\Controllers\ProblemSetController@getChapters_without_topic')->name('fmt.edgecontent.select.getChapters_without_topic');

Route::POST('fmt/edgecontent/getSelectedChapters', 'EdgeWizz\Edgecontent\Controllers\ProblemSetController@getSelectedChapters')->name('fmt.edgecontent.select.getSelectedChapters');

Route::POST('fmt/edgecontent/getSelectedChapterss_without_topic', 'EdgeWizz\Edgecontent\Controllers\ProblemSetController@getSelectedChapterss_without_topic')->name('fmt.edgecontent.select.getSelectedChapterss_without_topic');

Route::get('fmt/edgecontent/removeoption/{que_id}/{option_id}', 'EdgeWizz\Edgecontent\Controllers\ProblemSetController@removeoption')->name('fmt.edgecontent.removeoption');