<?php
 
namespace App\Filament\Widgets;

use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Subject;
use App\Models\Assignment;
use Filament\Forms\Get;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Contracts\View\View;

class StatsOverview extends BaseWidget
{

// protected function getCards(): array
// {
//     // Fetch subject names mapped by their IDs
//     $subjectNames = Subject::pluck('name', 'id');

//     // Get the total number of assignments per subject
//     $totalAssignmentsPerSubject = Assignment::groupBy('subject')
//         ->selectRaw('subject, count(*) as total')
//         ->pluck('total', 'subject');

//     // Get the currently authenticated user
//     $user = auth()->user();

//     // Get the submission count and rate for the specific user per subject
//     $userSubmissionData = $user->assignments->groupBy('subject')->map(function ($assignments, $subjectId) use ($totalAssignmentsPerSubject, $subjectNames) {
//         $subjectName = $subjectNames[$subjectId] ?? 'Unknown Subject';
//         $totalAssignments = $totalAssignmentsPerSubject[$subjectId] ?? 0;
//         $submissionCount = count($assignments);
//         $submissionRate = $totalAssignments > 0 ? ($submissionCount / $totalAssignments * 100) : 0;
//         return [
//             'count' => $submissionCount,
//             'rate' => number_format($submissionRate, 2) . '%'
//         ];
//     });

//     $cards = [];
//     foreach ($userSubmissionData as $subjectId => $data) {
//         $subjectName = $subjectNames[$subjectId] ?? 'Unknown Subject';
//         $cards[] = Stat::make($user->name . ' - ' . $subjectName, $data['count'] . ' (' . $data['rate'] . ')');
//     }

//     return $cards;
// }

protected function view(): View
{
    $users = User::with('assignments')->get();
    return view('filament.submit', compact('users'));
}

}