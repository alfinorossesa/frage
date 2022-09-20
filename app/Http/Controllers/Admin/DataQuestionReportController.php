<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionReport;
use App\Models\Question;
use Illuminate\Http\Request;

class DataQuestionReportController extends Controller
{
    public function index()
    {
        $questionReports = QuestionReport::latest()->get();

        return view('admin.data-question-report.index', compact('questionReports'));
    }

    public function show(QuestionReport $report)
    {
        return view('admin.data-question-report.show', compact('report'));
    }

    public function destroy(QuestionReport $report)
    {
        $report->delete();

        return redirect()->route('dataQuestionReport.index')->with('destroy', 'Report deleted!');
    }

    public function questionDelete(Question $question)
    {
        $question->delete();

        return redirect()->route('dataQuestionReport.index')->with('destroy', 'Question deleted!');
    }
}
