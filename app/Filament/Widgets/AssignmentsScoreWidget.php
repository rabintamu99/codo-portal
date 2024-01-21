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

class StatsOverview extends BaseWidget
{
    // protected function getStats(): array
    // {
    //     return [
    //         Stat::make('Cプログラミング 提出%', '90%')
    //         ->description('8% increase')
    //         ->descriptionIcon('heroicon-m-arrow-trending-up')
    //         ->color('success'),
    //     Stat::make('VBA 提出%', '81%')
    //         ->description('7% increase')
    //         ->descriptionIcon('heroicon-m-arrow-trending-down')
    //         ->color('danger'),
       
    //     ];
    // }
    // protected function getCards(): array
    // {
    //     //$totalUsers = User::count();
    //     // Add more statistics as needed
    //     $counts = User::withCount(['assignments' => function ($query) {
    //         $query->wherePivot('submitted', true);
    //     }])->get();

    //     return [
    //         Stat::make('Total Users', $counts)
    //             // Additional options can be chained here
    //     ];
    // }

    // protected function getCards(): array
    // {
    //     $userSubmissionCounts = User::withCount(['assignments' => function ($query) {
    //         $query->where('assignment_student.submitted', true); // Adjust the table name and column as per your schema
    //     }])->get()->mapWithKeys(function ($user) {
    //         return [$user->name => $user->assignments_count];
    //     });
    
    //     // Calculate the total number of submissions
    //     $totalSubmissions = array_sum($userSubmissionCounts->toArray());
    
    //     return [
    //         Stat::make('Total Submissions', $totalSubmissions),
    //         // Additional Stat cards can be added here
    //     ];
    // }


//     protected function getCards(): array
// {
//     $subjectSubmissionCounts = Assignment::join('subjects', 'assignments.subject', '=', 'subjects.id')
//         ->whereHas('students', function ($query) {
//             $query->where('assignment_student.submitted', true);
//         })
//         ->selectRaw('subjects.name as subject_name, count(*) as submission_count')
//         ->groupBy('subjects.name')
//         ->get();

//     $cards = [];
//     foreach ($subjectSubmissionCounts as $subject) {
//         $cards[] = Stat::make($subject->subject_name, $subject->submission_count);
//     }

//     return $cards;
// }



// protected function getCards(): array
// {
//     // Get the total number of assignments per subject
//     $totalAssignmentsPerSubject = Assignment::groupBy('subject')
//         ->selectRaw('subject, count(*) as total')
//         ->pluck('total', 'subject');

//     // Get the submission count and rate per student per subject
//     $studentSubmissionData = User::with(['assignments' => function ($query) {
//         $query->where('assignment_student.submitted', true);
//     }])->get()->mapWithKeys(function ($user) use ($totalAssignmentsPerSubject) {
//         return [$user->name => $user->assignments->groupBy('subject')->map(function ($assignments, $subject) use ($totalAssignmentsPerSubject) {
//             $totalAssignments = $totalAssignmentsPerSubject[$subject] ?? 0;
//             $submissionCount = count($assignments);
//             $submissionRate = $totalAssignments > 0 ? $submissionCount / $totalAssignments * 100 : 0;
//             return [
//                 'count' => $submissionCount,
//                 'rate' => number_format($submissionRate, 2) . '%'
//             ];
//         })];
//     });

//     $cards = [];
//     foreach ($studentSubmissionData as $studentName => $subjects) {
//         foreach ($subjects as $subjectId => $data) {
//             $cards[] = Stat::make($studentName . ' - ' . $subjectId, $data['count'] . ' (' . $data['rate'] . ')');
//         }
//     }

//     return $cards;
// }

// protected function getCards(): array
// {
//     // Fetch subject names mapped by their IDs
//     $subjectNames = Subject::pluck('name', 'id');

//     // Get the total number of assignments per subject
//     $totalAssignmentsPerSubject = Assignment::groupBy('subject')
//         ->selectRaw('subject, count(*) as total')
//         ->pluck('total', 'subject');

//     // Get the submission count and rate per student per subject
//     $studentSubmissionData = User::with(['assignments' => function ($query) {
//         $query->where('assignment_student.submitted', true);
//     }])->get()->mapWithKeys(function ($user) use ($totalAssignmentsPerSubject, $subjectNames) {
//         return [$user->name => $user->assignments->groupBy('subject')->map(function ($assignments, $subjectId) use ($totalAssignmentsPerSubject, $subjectNames) {
//             $subjectName = $subjectNames[$subjectId] ?? 'Unknown Subject';
//             $totalAssignments = $totalAssignmentsPerSubject[$subjectId] ?? 0;
//             $submissionCount = count($assignments);
//             $submissionRate = $totalAssignments > 0 ? $submissionCount / $totalAssignments * 100 : 0;
//             return [
//                 'count' => $submissionCount,
//                 'rate' => number_format($submissionRate, 2) . '%'
//             ];
//         })];
//     });

//     $cards = [];
//     foreach ($studentSubmissionData as $studentName => $subjects) {
//         foreach ($subjects as $subjectId => $data) {
//             $subjectName = $subjectNames[$subjectId] ?? 'Unknown Subject';
//             $cards[] = Stat::make($studentName . ' - ' . $subjectName, $data['count'] . ' (' . $data['rate'] . ')');
//         }
//    }

//     return $cards;
// }



// }


protected function getCards(): array
{
    // Fetch subject names mapped by their IDs
    $subjectNames = Subject::pluck('name', 'id');

    // Get the total number of assignments per subject
    $totalAssignmentsPerSubject = Assignment::groupBy('subject')
        ->selectRaw('subject, count(*) as total')
        ->pluck('total', 'subject');

    // Get the currently authenticated user
    $user = auth()->user();

    // Get the submission count and rate for the specific user per subject
    $userSubmissionData = $user->assignments->groupBy('subject')->map(function ($assignments, $subjectId) use ($totalAssignmentsPerSubject, $subjectNames) {
        $subjectName = $subjectNames[$subjectId] ?? 'Unknown Subject';
        $totalAssignments = $totalAssignmentsPerSubject[$subjectId] ?? 0;
        $submissionCount = count($assignments);
        $submissionRate = $totalAssignments > 0 ? ($submissionCount / $totalAssignments * 100) : 0;
        return [
            'count' => $submissionCount,
            'rate' => number_format($submissionRate, 2) . '%'
        ];
    });

    $cards = [];
    foreach ($userSubmissionData as $subjectId => $data) {
        $subjectName = $subjectNames[$subjectId] ?? 'Unknown Subject';
        $cards[] = Stat::make($user->name . ' - ' . $subjectName, $data['count'] . ' (' . $data['rate'] . ')');
    }

    return $cards;
}


}