<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\AnswerReport;
use Illuminate\Http\Request;

class DataAnswerReportController extends Controller
{
    public function index()
    {
        $answerReports = AnswerReport::latest()->get();

        return view('admin.data-answer-report.index', compact('answerReports'));
    }

    public function show(AnswerReport $report)
    {
        return view('admin.data-answer-report.show', compact('report'));
    }

    public function destroy(AnswerReport $report)
    {
        $report->delete();

        return redirect()->route('dataAnswerReport.index')->with('destroy', 'Report deleted!');
    }

    public function answerDelete(Answer $answer)
    {
        $answer->delete();

        return redirect()->route('dataAnswerReport.index')->with('destroy', 'Answer deleted!');
    }
}
