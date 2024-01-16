<?php
 
namespace App\Filament\Widgets;
 
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Subject;
 
class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Cプログラミング 提出%', '90%')
            ->description('8% increase')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success'),
        Stat::make('VBA 提出%', '81%')
            ->description('7% increase')
            ->descriptionIcon('heroicon-m-arrow-trending-down')
            ->color('danger'),
       
        ];
    }

//     protected function getStats(): array
// {
//     $subjects = Subject::with('subject')->get();
//     $stats = [];

//     foreach ($subjects as $subject) {
//         $totalAssignments = 0;
//         $totalSubmissions = 0;

//         foreach ($subject->assignments as $assignment) {
//             $totalAssignments += $assignment->students->count();
//             $totalSubmissions += $assignment->students->filter(function ($student) {
//                 return $student->pivot->submitted;
//             })->count();
//         }

//         $submissionRate = $totalAssignments > 0 ? ($totalSubmissions / $totalAssignments) * 100 : 0;

//         $stats[] = Stat::make($subject->name . ' 提出%', number_format($submissionRate, 2) . '%')
//             // Add more properties as needed, like description, icon, color
//             ->color($submissionRate >= 80 ? 'success' : 'danger'); // Example condition
//     }


// }

protected function getCards(): array
{
    $submissionCounts = assignment_student::select('subject_id')
        ->selectRaw('COUNT(*) as submission_count')
        ->where('submitted', true) // Assuming 'submitted' is a boolean
        ->groupBy('subject_id')
        ->pluck('submission_count', 'subject_id');

    $cards = [];
    foreach ($submissionCounts as $subjectId => $count) {
        $subjectName = Subject::find($subjectId)->name; // Replace with actual method to get subject name

        $cards[] = Card::make($subjectName, $count);
    }

    return $cards;
}

}